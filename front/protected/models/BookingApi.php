<?php
/**
 * Raw Booking Api Model
 */

class BookingApi extends Api
{
    /**
     * Get booking(s)
     * @param array $options
     * @return array
     * @TODO: Decrease Cyclomatic and NPath complexity
     */
    public static function filter($options = array())
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Compile where
        $where = array();
        $return_first = False;
        if (isset($options['gig_id'])) {
            $where[] = 'ag.gig_id = ' . (int)$options['gig_id'];
        }
        if (isset($options['artist_id'])) {
            $return_first = isset($options['gig_id']);
            $where[] = 'ag.artist_id = ' . (int)$options['artist_id'];
        }
        if (isset($options['from_date'])) {
            $where[] = "ag.datetime_from >= '" . date('Y-m-d H:i:s', strtotime($options['from_date'])) . "'";
        }
        if (isset($options['to_date'])) {
            $where[] = "ag.datetime_to <= '" . date('Y-m-d H:i:s', strtotime($options['to_date'])) . "'";
        }
        if (isset($options['show_all']) && $options['show_all']) {
            $where[] = "ag.status <> " . ArtistGig::STATUS_HIDDEN;
        } else {
            $where[] = "(ag.status = " . ArtistGig::STATUS_CONFIRMED . " OR ag.status = " . ArtistGig::STATUS_ACCEPTED . ")";
        }
        if (!empty($where)) {
            $where = implode($where, " AND ");
        }

        // Check formatting options
        $is_promoter = isset($options['is_promoter']) ? True : False;
        $bounds = isset($options['bounds']) && is_array($options['bounds']) ? $options['bounds'] : null;

        // Check default order and limit
        $order = isset($options['is_active']) ?  'ASC' : 'DESC';
        $limit = isset($options['limit']) ? "LIMIT " . $options['limit'] : '';

        // Get data from DB
        $artistGigs = Yii::app()->db->createCommand("
            SELECT ag.id, ag.gig_id, ag.artist_id, ag.revenue_share, ag.price, ag.currency,
                 ag.datetime_from as datetime_from, ag.datetime_to as datetime_to, ag.timezone,
                 a.name AS artist_name, a.fb_id AS artist_fb_id, a.description AS artist_description,
                 ag.accommodation, ag.transfer, ag.status, ag.last_changed, a.alias AS artist_alias,
                 GROUP_CONCAT(DISTINCT aff.path) AS artist_files, GROUP_CONCAT(DISTINCT aff.thumb) AS artist_thumbs,
                 p.name AS promoter_name, p.alias AS promoter_alias,
                 GROUP_CONCAT(DISTINCT pff.path) AS promoter_files, p.fb_id AS promoter_fb_id,
                 v.name as venue, v.city, c.name as country, v.latitude, v.longitude, g.address,
                 g.name, g.type, g.capacity, g.price as gig_price, g.currency as gig_currency
            FROM artist_gig ag
            JOIN artist a ON a.id = ag.artist_id
            JOIN gig g ON g.id = ag.gig_id
            JOIN promoter p ON p.user_id = g.user_id
            LEFT JOIN promoter_file pf ON pf.promoter_id = p.id
            LEFT JOIN file pff ON pff.id = pf.file_id
            LEFT JOIN artist_file af ON af.artist_id = a.id
            LEFT JOIN file aff ON aff.id = af.file_id
            LEFT JOIN venue v ON g.venue_id = v.id
            LEFT JOIN country c ON v.country_id = c.id
            WHERE " . $where . "
            GROUP BY ag.id
            ORDER BY g.datetime_from " . $order . "
            " . $limit . ";
        ")->queryAll();

        // Normalize booking list
        if ($artistGigs) {
            if ($return_first) {
                $result = BookingApi::getFormatted(reset($artistGigs), $is_promoter, $bounds);
            } else {
                $result = array();
                foreach ($artistGigs as $artistGig) {
                    $result[] = BookingApi::getFormatted($artistGig, $is_promoter, $bounds);
                }
            }
            Cache::set(func_get_args(), $result);
            return $result;
        }

        return array();
    }

    public static function getFormatted($artistGig, $is_promoter = true, $bounds = null)
    {
        // Fix timings
        $datetime = strtotime($artistGig['datetime_from']);

        // Check update status
        $have_updates = ($artistGig['last_changed'] == User::ROLE_ARTIST && $is_promoter) ||
            ($artistGig['last_changed'] == User::ROLE_PROMOTER && !$is_promoter) ? 1 : 0;

        // Check radius
        $in_radius = 0;
        if (!empty($bounds)) {
            $distance = Model::distance($artistGig['latitude'], $artistGig['longitude'],
                                        $bounds['latitude'], $bounds['longitude']);

            if ($distance <= $bounds['radius']) {
                $in_radius = 1;
            }
        }

        // Check past state
        $is_past = 0;
        if ($artistGig['datetime_from'] < date('Y-m-d H:i:s')) {
            $is_past = 1;
        }

        return array(
            'id'                => $artistGig['id'],
            'gig_id'            => $artistGig['gig_id'],
            'artist_id'         => $artistGig['artist_id'],
            'artist_alias'      => $artistGig['artist_alias'],
            'datetime_from'     => $artistGig['datetime_from'],
            'datetime_to'       => $artistGig['datetime_to'],
            'timezone'          => TZInfo::get($artistGig['timezone']),
            'date'              => date('M, j Y', $datetime),
            'month'             => date('M', $datetime),
            'day'               => date('j', $datetime),
            'label'             => date('d.m', $datetime),
            'name'              => $artistGig['name'],
            'description'       => isset($artistGig['description']) ? $artistGig['description'] : '',
            'price'             => $artistGig['price'],
            'currency'          => $artistGig['currency'],
            'currency_symbol'   => Currency::getCurrencySymbolById($artistGig['currency']),
            'gig_price'         => $artistGig['gig_price'],
            'gig_currency'      => $artistGig['gig_currency'],
            'revenue_share'     => $artistGig['revenue_share'],
            'max_price'         => $artistGig['price'] + ($artistGig['gig_price'] * $artistGig['capacity'] * ($artistGig['revenue_share'] / 100)),
            'potential_fee'     => $artistGig['gig_price'] * $artistGig['capacity'] * ($artistGig['revenue_share'] / 100),
            'potential_revenue' => $artistGig['gig_price'] * $artistGig['capacity'],
            'accommodation_id'  => $artistGig['accommodation'],
            'accommodation'     => ArtistGig::getAccommodationById($artistGig['accommodation']),
            'transfer_id'       => $artistGig['transfer'],
            'transfertype'      => ArtistGig::getTransferTypeById($artistGig['transfer']),
            'type_id'           => $artistGig['type'],
            'type'              => Gig::getTypeById($artistGig['type']),
            'capacity'          => $artistGig['capacity'],
            'artist_name'       => $artistGig['artist_name'],
            'artist_link'       => '/' . $artistGig['artist_alias'],
            'artist_description'=> $artistGig['artist_description'],
            'artist_image'      => Model::getImage($artistGig['artist_files'], $artistGig['artist_fb_id']),
            'artist_thumb'      => Model::getImage($artistGig['artist_thumbs'], $artistGig['artist_fb_id'], 'thumb'),
            'promoter_name'     => $artistGig['promoter_name'],
            'promoter_link'     => '/promoter/' . $artistGig['promoter_alias'],
            'promoter_image'    => Model::getImage($artistGig['promoter_files'], $artistGig['promoter_fb_id']),
            'status'            => $artistGig['status'],
            'status_name'       => ArtistGig::getStatusById($artistGig['status']),
            'available_statuses'=> $is_past ? array() : ArtistGig::getAvailableStatusList($artistGig['status'], $is_promoter),
            'venue'             => array(
                'name'              => $artistGig['venue'],
                'city'              => $artistGig['city'],
                'country'           => $artistGig['country'],
                'latitude'          => $artistGig['latitude'],
                'longitude'         => $artistGig['longitude'],
                'address'           => $artistGig['address']
            ),
            'messages'          => MessageApi::getList($artistGig['gig_id'], $artistGig['artist_id']),
            'details_log'       => MessageApi::getGigLog($artistGig['gig_id'], $artistGig['artist_id']),
            'have_updates'      => $have_updates,
            'in_radius'         => $in_radius,
            'is_past'           => $is_past,
        );
    }

    /**
     * Update artistGig data
     * @param $data
     * @return bool
     */
    public static function update($data)
    {
        // Check required
        if (!$data['id']) {
            return false;
        }

        // Compile update query
        $set = array();
        foreach ($data as $field => $value) {
            if (in_array($field, array('datetime_from', 'datetime_to', 'timezone'))) {
                $set[] =  $field . "='" . $value . "'";
            } else {
                $set[] =  $field . "=" . $value;
            }
        }
        $set = implode(',', $set);

        // Clean all gig caches
        Cache::clean(Cache::GIG_NS);

        // Update and return result
        return Yii::app()->db->createCommand("
            UPDATE artist_gig
            SET " . $set . "
            WHERE id = " . $data['id'] . ";
        ")->execute();
    }

    /**
     * Update booking status
     * @param int $gig_id
     * @param int $artist_id
     * @param int $status
     * @param bool $is_promoter (optional), default True
     * @return mixed
     */
    public static function updateStatus($gig_id, $artist_id, $status, $is_promoter = true)
    {
        $last_changed = $is_promoter ? User::ROLE_PROMOTER : User::ROLE_ARTIST;

        // Clean all gig caches
        Cache::clean(Cache::GIG_NS);

        return Yii::app()->db->createCommand("
            UPDATE artist_gig
            SET status = " . $status . ", last_changed = " . $last_changed . "
            WHERE gig_id = " . $gig_id . "
             AND artist_id = " . $artist_id
        )->execute();
    }

    /**
     * Create message for updated data
     * @param array $old
     * @param array $new
     * @param User $user
     * @return bool
     */
    public static function createUpdateMessages($old, $new, $user)
    {
        // Check user
        $is_promoter = true;
        if ($user->role == User::ROLE_PROMOTER) {
            if ($user->promoter()) {
                $name = $user->promoter()->name;
            } else {
                return false;
            }
            $type = Message::TYPE_PROMOTER_UPDATE;
        } else {
            $is_promoter = false;
            if ($user->artist()) {
                $name = $user->artist()->name;
            } else {
                return false;
            }
            $type = Message::TYPE_ARTIST_UPDATE;
        }

        // Compile message
        $messages = array($name . ' changed booking details:');
        $check = array('price', 'currency', 'accommodation', 'transfer', 'datetime_from', 'datetime_to');
        foreach ($new as $field => $value) {
            if ($old[$field] != $value && in_array($field, $check)) {
                if ($old[$field] != 'Not set' || !empty($old[$field])) {
                    $messages[] = BookingApi::fieldLabel($field) . ' from ' . $old[$field] . ' to ' . $value;
                } else {
                    $messages[] = BookingApi::fieldLabel($field) . ' to ' . $value;
                }
            }
        }

        // Add message if has changes
        if (count($messages) > 1) {
            $messages = Yii::app()->db->quoteValue(implode("\r\n", $messages));

            // Clean all message caches
            Cache::clean(Cache::MESSAGE_NS);

            // Insert new message
            Yii::app()->db->createCommand("
                INSERT INTO message (type, gig_id, artist_id, message)
                VALUES (" . $type . ", " . $old['gig_id'] . ", " . $old['artist_id'] . ", " . $messages . ");
            ")->execute();

            // Clean all gig caches
            Cache::clean(Cache::GIG_NS);

            // Update booking status
            $status = $is_promoter ? ArtistGig::STATUS_ADJUSTED_BY_PROMOTER : ArtistGig::STATUS_ADJUSTED_BY_ARTIST;
            Yii::app()->db->createCommand("
                UPDATE artist_gig
                SET status = " . $status . "
                WHERE gig_id = " . $old['gig_id'] . "
                 AND artist_id = " . $old['artist_id']
            )->execute();

            return 1;
        }

        return 0;
    }

    public static function fieldLabel($field)
    {
        switch ($field) {
            case 'datetime_from':
                return 'Set Time From';
            case 'datetime_to':
                return 'Set Time To';
            default:
                return ucfirst(str_replace('_', ' ', $field));
        }
    }

}

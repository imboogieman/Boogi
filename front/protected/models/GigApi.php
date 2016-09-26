<?php
/**
 * Raw Gig Api Model
 */

class GigApi extends Api
{
    /**
     * Get gig(s)
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
        if (isset($options['id'])) {
            $where[] = 'g.id = ' . (int)$options['id'];
            $return_first = True;
        }
        if (isset($options['alias'])) {
            $where[] = "g.alias = '" . $options['alias'] . "'";
            $return_first = True;
        }
        if (isset($options['promoter_id'])) {
            $where[] = "p.id = " . (int)$options['promoter_id'];
        }
        if (isset($options['show_all']) && $options['show_all']) {
            $where[] = "ag.status <> " . ArtistGig::STATUS_HIDDEN;
        } else {
            $where[] = "(ag.status = " . ArtistGig::STATUS_CONFIRMED . " OR ag.status = " . ArtistGig::STATUS_ACCEPTED . ")";
        }
        if (isset($options['from_date'])) {
            $where[] = "g.datetime_from >= '" . date('Y-m-d H:i:s', strtotime($options['from_date'])) . "'";
        }
        if (isset($options['to_date'])) {
            $where[] = "g.datetime_to <= '" . date('Y-m-d H:i:s', strtotime($options['to_date'])) . "'";
        }
        if (!empty($where)) {
            $where = implode($where, " AND ");
        }

        // Check default order and limit
        $order = isset($options['is_active']) ?  'ASC' : 'DESC';
        $limit = isset($options['limit']) ? "LIMIT " . $options['limit'] : '';

        // Get gig
        $gigs = Yii::app()->db->createCommand("
            SELECT g.id, g.name, g.description, g.type, g.capacity, g.price, g.currency,
                g.datetime_from, g.datetime_to, g.timezone,
                v.id AS venue_id, v.name AS venue, v.city, v.longitude, v.latitude, c.name AS country, g.address,
                (SELECT COUNT(id) FROM artist_gig WHERE gig_id = g.id AND status = " . ArtistGig::STATUS_OPEN . " ) as ag_open,
                (SELECT COUNT(id) FROM artist_gig WHERE gig_id = g.id AND status = " . ArtistGig::STATUS_ACCEPTED . " ) as ag_accepted,
                (SELECT COUNT(id) FROM artist_gig WHERE gig_id = g.id AND status = " . ArtistGig::STATUS_ADJUSTED_BY_ARTIST . ") as ag_adjusted_by_artist,
                (SELECT COUNT(id) FROM artist_gig WHERE gig_id = g.id AND status = " . ArtistGig::STATUS_ADJUSTED_BY_PROMOTER . ") as ag_adjusted_by_promoter,
                (SELECT COUNT(id) FROM artist_gig WHERE gig_id = g.id AND status = " . ArtistGig::STATUS_REJECTED . " ) as ag_rejected,
                (SELECT COUNT(id) FROM artist_gig WHERE gig_id = g.id AND status = " . ArtistGig::STATUS_CONFIRMED . " ) as ag_confirmed
            FROM gig g
            JOIN venue v ON v.id = g.venue_id
            LEFT JOIN country c ON c.id = v.country_id
            LEFT JOIN artist_gig ag ON ag.gig_id = g.id
            JOIN promoter p ON p.user_id = g.user_id
            WHERE " . $where . "
            GROUP BY g.id
            ORDER BY g.datetime_from " . $order . "
            " . $limit . ";
        ")->queryAll();

        // Normalize gig list
        if ($gigs) {
            if ($return_first) {
                $result = GigApi::getFormatted(reset($gigs), $options);
            } else {
                foreach ($gigs as $gig) {
                    $result[] = GigApi::getFormatted($gig, $options);
                }
            }
            Cache::set(func_get_args(), $result);
            return $result;
        }

        return array();
    }

    /**
     * Update gig data
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
            if (in_array($field, array('id', 'user_id'))) {
                continue;
            }
            if (in_array($field, array('name', 'description', 'address', 'datetime_from', 'datetime_to', 'timezone'))) {
                $set[] =  $field . "='" . $value . "'";
            } else {
                $set[] =  $field . "=" . (int)$value;
            }
        }

        // Clean all gig caches
        Cache::clean(Cache::GIG_NS);

        // Update and return result
        return Yii::app()->db->createCommand("
            UPDATE gig
            SET " . implode(',', $set) . "
            WHERE id = " . $data['id'] . "
              AND user_id = " . $data['user_id'] . ";
        ")->execute();
    }

    /**
     * Create message for updated data
     * @param array $old
     * @param array $new
     * @param Promoter $promoter
     * @return bool
     */
    public static function createUpdateMessages($old, $new, $promoter)
    {
        // Compile message
        $messages = array($promoter->name . ' changed gig details:');
        $check = array('name', 'description', 'price', 'currency', 'capacity', 'type', 'datetime_from', 'datetime_to');
        foreach ($new as $field => $value) {
            if ($old[$field] != $value && in_array($field, $check)) {
                if ($old[$field] != 'Not set' || !empty($old[$field])) {
                    $messages[] = GigApi::fieldLabel($field) . ' from ' . $old[$field] . ' to ' . $value;
                } else {
                    $messages[] = GigApi::fieldLabel($field) . ' to ' . $value;
                }
            }
        }

        // Add message if has changes
        if (count($messages) > 1) {
            $messages = Yii::app()->db->quoteValue(implode("\r\n", $messages));

            // Clean all message caches
            Cache::clean(Cache::MESSAGE_NS);

            // Create messages for all artists
            $bookings = BookingApi::filter(array('gig_id' => $old['id'], 'show_all' => true));
            foreach ($bookings as $booking) {
                Yii::app()->db->createCommand("
                    INSERT INTO message (type, gig_id, artist_id, message)
                    VALUES (" . Message::TYPE_PROMOTER_UPDATE . ", " . $booking['gig_id'] . ", " . $booking['artist_id'] . ", " . $messages . ");
                ")->execute();
            }

            // Clean all gig caches
            Cache::clean(Cache::GIG_NS);

            // Update booking status
            Yii::app()->db->createCommand("
                UPDATE artist_gig
                SET status = " . ArtistGig::STATUS_ADJUSTED_BY_PROMOTER . "
                WHERE gig_id = " . $old['id'] . ";"
            )->execute();

            return 1;
        }

        return 0;
    }

    public static function fieldLabel($field)
    {
        switch ($field) {
            case 'datetime_from':
                return 'Date From';
            case 'datetime_to':
                return 'Date To';
            default:
                return ucfirst(str_replace('_', ' ', $field));
        }
    }

    public static function getFormatted($gig, $options = array())
    {
        // Fix timings
        $datetime = strtotime($gig['datetime_from']);

        // Calculate statuses
        $status_confirmed = (int)$gig['ag_confirmed'] + (int)$gig['ag_accepted'];
        $status_open = (int)$gig['ag_open'] + (int)$gig['ag_adjusted_by_artist'] + (int)$gig['ag_adjusted_by_promoter'];

        // Update options
        $options['gig_id'] = $gig['id'];
        $options['is_promoter'] = true;
        $gig['bookings'] = BookingApi::filter($options);

        // Calculate bookings metrics
        $have_updates = 0;
        $start_time = array();
        $end_time = array();
        $line_up = array();
        if ($datetime >= date('Y-m-d H:i:s')) {
            if (!empty($gig['bookings'])) {
                foreach ($gig['bookings'] as &$booking) {
                    $have_updates += $booking['have_updates'];
                    $start_time[] = $booking['datetime_from'];
                    $end_time[] = $booking['datetime_to'];
                    $line_up[] = array(
                        'artist_name'   => $booking['artist_name'],
                        'start_time'    => date('H:i', strtotime($booking['datetime_from'])),
                        'end_time'      => date('H:i', strtotime($booking['datetime_to'])),
                    );
                }
            }
        }

        return array(
            'id'            => $gig['id'],
            'name'          => $gig['name'],
            'datetime_from' => $gig['datetime_from'],
            'datetime_to'   => $gig['datetime_to'],
            'timezone'      => TZInfo::get($gig['timezone']),
            'date'          => date('M, j Y', $datetime),
            'month'         => date('M', $datetime),
            'day'           => date('j', $datetime),
            'start_time'    => $start_time ? min($start_time) : '',
            'end_time'      => $end_time ? max($end_time) : '',
            'description'   => $gig['description'],
            'type_id'       => $gig['type'],
            'type'          => Gig::getTypeById($gig['type']),
            'capacity'      => $gig['capacity'],
            'price'         => $gig['price'],
            'currency'      => $gig['currency'],
            'revenue'       => $gig['price'] * $gig['capacity'],
            'statuses'      => array(
                array('id' => ArtistGig::STATUS_CONFIRMED, 'count' => $status_confirmed),
                array('id' => ArtistGig::STATUS_OPEN, 'count' => $status_open),
                array('id' => ArtistGig::STATUS_REJECTED, 'count' => (int)$gig['ag_rejected']),
            ),
            'address'       => $gig['address'],
            'venue'         => array(
                'id'        => $gig['venue_id'],
                'name'      => $gig['venue'],
                'city'      => $gig['city'],
                'country'   => $gig['country'],
                'longitude' => $gig['longitude'],
                'latitude'  => $gig['latitude'],
            ),
            'have_updates'  => $have_updates,
            'is_past'       => $gig['datetime_from'] >= date('Y-m-d H:i:s') ? 0 : 1,
            'bookings'      => $gig['bookings'],
            'line_up'       => $line_up,
            'details_log'   => MessageApi::getGigLog($gig['id'])
        );
    }

    public static function mergeGigs($gigs)
    {
        $result = array();
        foreach($gigs as $gig) {
            $index = $gig['id'];
            if (isset($gig['venue']) && isset($gig['venue']['latitude']) && isset($gig['venue']['longitude']) &&
                !empty($gig['venue']['longitude']) && !empty($gig['venue']['longitude'])) {
                $index = $gig['venue']['latitude'] . $gig['venue']['longitude'] . date('m', strtotime($gig['datetime']));
            }

            if (isset($result[$index])) {
                if (!$result[$index]['is_multi']) {
                    $result[$index]['is_multi'] = 2;
                    $result[$index]['name'] .= '<br />' . $gig['name'];
                } else {
                    $result[$index]['name'] .= '<br />' . $gig['name'];
                    $result[$index]['is_multi']++;
                }
                $result[$index]['label'] = "*";
                $result[$index]['id_list'][] = $gig['id'];
            } else {
                $gig['is_multi'] = isset($gig['is_multi']) ? $gig['is_multi'] : 0;
                $result[$index] = $gig;
            }
        }
        return array_values($result);
    }
}

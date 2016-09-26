<?php
/**
 * High Speed Model for API calls
 */

class PromoterApi extends Api
{
    /**
     * Get promoters list
     * @param int $promoter_id
     * @return array
     */
    public static function getList($promoter_id = 0)
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Get promoter list
        $promoters = Yii::app()->db->createCommand("
            SELECT p.id, p.name, p.alias, p.description, p.fb_id, CONCAT(f.path) as files,
                (SELECT COUNT(*) FROM promoter_promoter WHERE follow_id = p.id AND promoter_id = " . $promoter_id . ") AS following
            FROM promoter p
            LEFT JOIN promoter_file pf ON pf.promoter_id = p.id
            LEFT JOIN file f ON f.id = pf.file_id
            GROUP BY p.id;
        ")->queryAll();

        // Compile result
        $result = array();
        if ($promoters) {
            foreach ($promoters as $promoter) {
                $result[] = array(
                    'id'            => $promoter['id'],
                    'name'          => $promoter['name'],
                    'image'         => Model::getImage($promoter['files'], $promoter['fb_id']),
                    'link'          => '/promoter/' . $promoter['alias'],
                    'description'   => $promoter['description'],
                    'following'     => $promoter['following'] > 0 ? 1 : 0,
                );
            }
        }

        Cache::set(func_get_args(), $result);
        return $result;
    }

    /**
     * Alias for get promoter method
     * @param int $promoter_id
     * @param string|null $alias
     * @return array|bool
     */
    public static function get($promoter_id, $alias = null)
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Check promoter id and alias
        if ((!$promoter_id || $promoter_id == 'undefined') && !$alias) {
            return false;
        }

        // Get promoter where
        $where = $promoter_id && $promoter_id != 'undefined' ?
            "p.id = " . $promoter_id : "p.alias = '" . $alias . "' AND p.alias IS NOT NULL";

        // Get promoter info
        $promoter = Yii::app()->db->createCommand("
            SELECT p.id, p.user_id, p.fb_id, p.name, u.email, u.plan, u.plan_activated, p.alias, p.description,
                p.latitude, p.longitude, p.radius, p.is_approved, p.address, p.facebook, p.twitter, p.homepage,
                GROUP_CONCAT(DISTINCT f.path) as files,
                GROUP_CONCAT(DISTINCT f.crop) as crops,
                GROUP_CONCAT(DISTINCT f.thumb) as thumbs
            FROM promoter p
            JOIN user u ON u.id = p.user_id
            LEFT JOIN promoter_file pf ON pf.promoter_id = p.id
            LEFT JOIN file f ON f.id = pf.file_id
            WHERE " . $where . "
            GROUP BY p.id;
        ")->queryRow();

        // Compile result
        $result = false;
        if ($promoter) {
            $result = array(
                'id'            => $promoter['id'],
                'user_id'       => $promoter['user_id'],
                'image'         => Model::getImage($promoter['files'], $promoter['fb_id']),
                'crop'          => Model::getImage($promoter['crops'], $promoter['fb_id'], 'crop'),
                'thumb'         => Model::getImage($promoter['thumbs'], $promoter['fb_id'], 'thumb'),
                'is_approved'   => $promoter['is_approved'] ? 1 : 0,
                'name'          => $promoter['name'],
                'email'         => $promoter['email'],
                'link'          => '/promoter/' . $promoter['alias'],
                'description'   => $promoter['description'],
                'latitude'      => $promoter['latitude'],
                'longitude'     => $promoter['longitude'],
                'radius'        => $promoter['radius'],
                'plan'          => UserApi::getPlanName($promoter['plan']),
                'plan_expired'  => $promoter['plan_activated'],
                'gigs'          => self::getGigs($promoter['id'], false),
                'address'       => $promoter['address'],
                'social'        => !empty($promoter['facebook']) || !empty($promoter['twitter']) || !empty($promoter['homepage']),
                'facebook'      => $promoter['facebook'],
                'facebook_name' => $promoter['facebook'],
                'twitter'       => $promoter['twitter'],
                'twitter_name'  => $promoter['twitter'],
                'homepage'      => $promoter['homepage'],
                'homepage_name' => $promoter['homepage'],
            );
        }

        Cache::set(func_get_args(), $result);
        return $result;
    }

    /**
     * Get promoters events
     * @param int $promoter_id
     * @param int $offset
     * @return array
     */
    public static function getEvents($promoter_id, $offset = 0)
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Check pagination
        $limit = $offset + 30;

        // Get list
        $events = Yii::app()->db->createCommand("
            SELECT e.id, e.datetime, e.type, e.status,
                e.init_id, e.init_name, e.init_link, e.init_type,
                e.target_id, e.target_name, e.target_link, e.target_type,
                e.creator_id, e.creator_name, e.creator_link
            FROM event e
            WHERE (e.status = 1 AND e.init_id = " . $promoter_id . " AND e.type <> " . Event::GIG_CREATE . ")
              OR (e.status = 1 AND e.init_type = 'Promoter' AND e.init_id IN (
                SELECT pp.follow_id
                FROM promoter_promoter pp
                WHERE pp.promoter_id = " . $promoter_id . "
                  AND e.type <> " . Event::ARTIST_CREATE . "
              ))
              OR (e.status = 1 AND e.init_type = 'Artist' AND e.init_id IN (
                SELECT ap.artist_id
                FROM artist_promoter ap
                WHERE ap.promoter_id = " . $promoter_id . "
              ))
              OR (e.status = 0 AND
                ((e.init_id = " . $promoter_id . " AND e.init_type = 'Promoter') OR (e.target_id = " . $promoter_id . " AND e.target_type = 'Promoter'))
              )
            GROUP BY e.init_id, e.init_type, e.datetime
            ORDER BY e.datetime DESC
            LIMIT " . $offset . ", " . $limit . ";
        ")->queryAll();

        // Compile result
        $result = array();
        if ($events) {
            foreach ($events as $event) {
                $follow = array(
                    'type'        => $event['type'],
                    'is_followed' => $event['init_id'] != $promoter_id,
                    'follow_name' => $event['creator_name'],
                    'follow_link' => $event['creator_link'],
                );

                $event_data = array(
                    'id'    => $event['id'],
                    'date'  => date('D, d M Y', strtotime($event['datetime'])),
                    'type'  => Event::getTypeById($follow),
                    'status'=> $event['status'],
                    'init'  => array(
                        'id'    => $event['init_id'],
                        'name'  => $event['init_name'],
                        'link'  => $event['init_link'],
                    ),
                    'target'=> array(
                        'id'    => $event['target_id'],
                        'name'  => $event['target_name'],
                        'link'  => $event['target_link'],
                    ),
                );

                // Fix self pointer
                if ($event['init_type'] == 'Promoter' && $event['init_id'] == $promoter_id) {
                    $event_data['init']['name'] = 'You';
                }
                if ($event['target_type'] == 'Promoter' && $event['target_id'] == $promoter_id) {
                    $event_data['target']['name'] = 'You';
                }

                $result[] = $event_data;
            }
        }

        Cache::set(func_get_args(), $result);
        return $result;
    }

    // @TODO: Replace $_COOKIE global variable
    public static function getFollowedArtists($promoter_id)
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Get list
        $artists = Yii::app()->db->createCommand("
            SELECT a.id, a.name, a.alias, a.description, a.fb_id,
                GROUP_CONCAT(DISTINCT f.path) as files,
                GROUP_CONCAT(v.latitude, ',' ,v.longitude SEPARATOR ';') as coords,
                COUNT(DISTINCT ag.id) AS gig_count,
                COUNT(DISTINCT ap.id) AS promoter_count
            FROM artist_promoter ap
            JOIN artist a ON a.id = ap.artist_id
            LEFT JOIN artist_gig ag ON ag.artist_id = ap.artist_id
            LEFT JOIN gig g ON g.id = ag.gig_id
            LEFT JOIN venue v ON v.id = g.venue_id
            LEFT JOIN artist_file af ON af.artist_id = a.id
            LEFT JOIN file f ON f.id = af.file_id
            WHERE ap.promoter_id = " . $promoter_id . "
              AND g.datetime_from > NOW()
            GROUP BY ap.artist_id
            ORDER BY ap.timestamp;
        ")->queryAll();

        // Get promoter bounds
        $bounds = false;
        $user = User::getLogged();
        if ($user && $user->promoter()) {
            $promoter = $user->promoter();
            $bounds = array(
                'latitude'  => $promoter->latitude ? $promoter->latitude : $_COOKIE['latitude'],
                'longitude' => $promoter->longitude ? $promoter->longitude : $_COOKIE['longitude'],
                'radius'    => $promoter->radius ? $promoter->radius / 1000 : Model::DEFAULT_RADIUS / 1000
            );
        }

        // Compile result
        $result = array();
        if ($artists) {
            foreach ($artists as $artist) {
                // Check gigs in radius
                $in_radius = false;
                if (!empty($artist['coords']) && $bounds) {
                    $in_radius = self::_checkCoords($artist['coords'], $bounds);
                }

                $result[] = array(
                    'id'            => $artist['id'],
                    'image'         => Model::getImage($artist['files'], $artist['fb_id']),
                    'name'          => $artist['name'],
                    'link'          => '/' . $artist['alias'],
                    'description'   => $artist['description'],
                    'gig_count'     => $artist['gig_count'],
                    'promoter_count'=> $artist['promoter_count'],
                    'following'     => 1,
                    'in_radius'     => $in_radius ? 1 : 0
                );
            }
        }

        Cache::set(func_get_args(), $result);
        return $result;
    }

    /**
     * Check if artist gigs in radius
     * @param array $coords
     * @param array $bounds
     * @return bool
     */
    private static function _checkCoords($coords, $bounds)
    {
        $pairs = explode(';', $coords);
        foreach ($pairs as $coords) {
            $data = explode(',', $coords);
            if (!empty($coords) && !empty($bounds) && count($data) == 2) {
                $distance = Model::distance($data[0], $data[1], $bounds['latitude'], $bounds['longitude']);
                if ($distance <= $bounds['radius']) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function getFollowedPromoters($promoter_id)
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Get list
        $promoters = Yii::app()->db->createCommand("
            SELECT p.id, p.name, p.alias, p.description, p.fb_id,
                GROUP_CONCAT(DISTINCT f.path) as files
            FROM promoter_promoter pp
            JOIN promoter p ON p.id = pp.follow_id
            LEFT JOIN promoter_file pf ON pf.promoter_id = pp.follow_id
            LEFT JOIN file f ON f.id = pf.file_id
            WHERE pp.promoter_id = " . $promoter_id . "
            GROUP BY pp.follow_id
            ORDER BY pp.timestamp;
        ")->queryAll();

        // Compile result
        $result = array();
        if ($promoters) {
            foreach ($promoters as $promoter) {
                $result[] = array(
                    'id'            => $promoter['id'],
                    'image'         => Model::getImage($promoter['files'], $promoter['fb_id']),
                    'name'          => $promoter['name'],
                    'link'          => '/promoter/' . $promoter['alias'],
                    'description'   => $promoter['description'],
                    'following'     => 1
                );
            }
        }

        Cache::set(func_get_args(), $result);
        return $result;
    }

    public static function getGigs($promoter_id, $show_all = true)
    {
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        $result = array(
            'active' => GigApi::filter(array(
                'promoter_id'   => $promoter_id,
                'from_date'     => date('Y-m-d H:i:s'),
                'is_active'     => true,
                'show_all'      => $show_all,
                'limit'         => 30
            )),
            'past'   => GigApi::filter(array(
                'promoter_id'   => $promoter_id,
                'to_date'       => date('Y-m-d H:i:s'),
                'show_all'      => $show_all,
                'limit'         => 30
            )),
        );

        $result['active_count'] = count($result['active']);
        $result['past_count'] = count($result['active']);

        $result['show_active_label'] = $result['active_count'] > count($result['active']);
        $result['show_past_label'] = $result['past_count'] > count($result['past']);

        Cache::set(func_get_args(), $result);
        return $result;
    }

    public static function updateByAccount($account)
    {
        $promoter = Promoter::getLogged();
        $promoter->mergeAccount($account);
        EventApi::updateAccount(array(
            'id'   => $promoter->id,
            'name' => $promoter->name,
            'link' => $promoter->getLink(),
        ));
        Mailer::sendAccountBookingEmails($promoter, $account);
        Promoter::deleteAccount($account);
    }
}
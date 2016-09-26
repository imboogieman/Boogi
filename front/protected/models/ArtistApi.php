<?php
/**
 * Raw Artist Api Model
 * @TODO: Decrease Overall complexity
 */

class ArtistApi
{
    const LIMIT = 30;
    const OFFSET = 0;

    /**
     * Get artist list
     * @param array $options
     * @return array
     * @TODO: Decrease Cyclomatic and NPath complexity
     */
    public static function getList($options = array())
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Check pagination
        $limit = isset($options['limit']) && !empty($options['limit']) ? $options['limit'] : self::LIMIT;
        $offset = isset($options['offset']) && !empty($options['offset']) ? $options['offset'] : self::OFFSET;

        // Get current promoter id
        $promoter = Promoter::getLogged();
        $promoter_id = $promoter ? $promoter->id : 0;

        // Check search query
        $search = '';
        if (isset($options['query'])) {
            // Check search output, if empty - skip it
            $artist_count = Yii::app()->db->createCommand("
                SELECT COUNT(id)
                FROM artist
                WHERE name LIKE '%" . $options['query'] . "%'
            ")->queryScalar();

            if ($artist_count) {
                $search = " AND a.name LIKE '%" . $options['query'] . "%' ";
            }
        }

        // Get list
        $artists = Yii::app()->db->createCommand("
            SELECT a.id, a.name, a.alias, a.description, a.fb_id, a.latitude, a.longitude,
                GROUP_CONCAT(DISTINCT f.path) as files,
                COUNT(DISTINCT ag.id) AS gig_count,
                COUNT(DISTINCT ap.id) AS promoter_count,
                (SELECT COUNT(*) FROM artist_promoter WHERE artist_id = a.id AND promoter_id = " . $promoter_id . ") AS following
            FROM artist a
            LEFT JOIN artist_gig ag ON ag.artist_id = a.id
            LEFT JOIN gig g ON ag.gig_id = g.id
            LEFT JOIN artist_promoter ap ON ap.artist_id = a.id
            LEFT JOIN promoter p ON ap.promoter_id = p.id
            LEFT JOIN artist_file af ON af.artist_id = a.id
            LEFT JOIN file f ON f.id = af.file_id
            WHERE g.datetime_from >= '" . date('Y-m-d') . "'
              " . $search . "
              AND (ag.status = " . ArtistGig::STATUS_CONFIRMED . " OR ag.status = " . ArtistGig::STATUS_ACCEPTED . ")
            GROUP BY a.id
            ORDER BY gig_count DESC
            LIMIT " . $offset . ", " . $limit . ";"
        )->queryAll();

        if ($artists) {
            $result = array_map(array('ArtistApi', 'getFormatted'), $artists);
            Cache::set(func_get_args(), $result);
            return $result;
        }

        return false;
    }

    /**
     * Alias for get artist method
     * @param int $id
     * @param string|null $alias
     * @return array|bool
     * @TODO: Decrease Cyclomatic and NPath complexity
     * @TODO: Replace $_COOKIE global variable
     */
    public static function get($id, $alias = null)
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Check alias and id
        if ((!$id || $id == 'undefined') && !$alias) {
            return false;
        }

        // Get current promoter id
        $bounds = false;
        $following = '';
        $user = User::getLogged();
        if ($user && $user->promoter()) {
            $promoter = $user->promoter();
            $promoter_id = $promoter->id;
            $bounds = array(
                'latitude'  => $promoter->latitude ? $promoter->latitude : $_COOKIE['latitude'],
                'longitude' => $promoter->longitude ? $promoter->longitude : $_COOKIE['longitude'],
                'radius'    => $promoter->radius ? $promoter->radius / 1000 : Model::DEFAULT_RADIUS / 1000
            );
            $following = ", (SELECT COUNT(*) FROM artist_promoter WHERE artist_id = a.id AND promoter_id = " . $promoter_id . ") AS following";
        }

        // Get artist
        $where = $id && $id != 'undefined' ? "a.id = " . $id : "a.alias = '" . $alias . "' AND a.alias IS NOT NULL";
        $artist = Yii::app()->db->createCommand("
            SELECT a.id, a.name, a.alias, a.description, a.fb_id, a.latitude, a.longitude,
                GROUP_CONCAT(DISTINCT f.path) as files,
                COUNT(DISTINCT ag.id) AS gig_count,
                COUNT(DISTINCT ap.id) AS promoter_count" . $following . "
            FROM artist a
            LEFT JOIN artist_gig ag ON ag.artist_id = a.id
            LEFT JOIN gig g ON ag.gig_id = g.id AND g.datetime_from >= NOW()
            LEFT JOIN artist_promoter ap ON ap.artist_id = a.id
            LEFT JOIN promoter p ON ap.promoter_id = p.id
            LEFT JOIN artist_file af ON af.artist_id = a.id
            LEFT JOIN file f ON f.id = af.file_id
            WHERE " . $where . "
            GROUP BY a.id;
        ")->queryRow();

        if ($artist) {
            $result = ArtistApi::getFormatted($artist);
            $result['gigs'] = ArtistApi::getBookings($artist['id'], $bounds, false);
            $result['gig_count'] = $result['gigs']['active_count'];
            Cache::set(func_get_args(), $result);
            return $result;
        }

        return false;
    }

    /**
     * Return booking list for artist
     * @param int $artist_id
     * @param array|null $show_all optional
     * @param bool $show_all optional
     * @return array
     */
    public static function getBookings($artist_id, $bounds = null, $show_all = true)
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        $result = array(
            'active' => BookingApi::filter(array(
                'artist_id'     => $artist_id,
                'bounds'        => $bounds,
                'is_active'     => true,
                'show_all'      => $show_all,
                'from_date'     => date('Y-m-d H:i:s')
            )),
            'past' => BookingApi::filter(array(
                'artist_id'     => $artist_id,
                'bounds'        => $bounds,
                'show_all'      => $show_all,
                'to_date'       => date('Y-m-d H:i:s')
            ))
        );

        $result['active_count'] = count($result['active']);
        $result['past_count'] = count($result['past']);

        $result['show_active_label'] = $result['active_count'] > count($result['active']);
        $result['show_past_label'] = $result['past_count'] > count($result['past']);

        Cache::set(func_get_args(), $result);
        return $result;
    }

    public static function searchByQuery($query, $limit = 7)
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Check DB
        $artists =  Yii::app()->db->createCommand("
            SELECT a.name, a.alias, a.description, a.fb_id, CONCAT(f.path) as files
            FROM artist a
            LEFT JOIN artist_file af ON af.artist_id = a.id
            LEFT JOIN file f ON f.id = af.file_id
            WHERE a.name LIKE '%" . $query . "%'
            ORDER BY a.name ASC
            LIMIT " . $limit . ";"
        )->queryAll();

        $result = array();
        foreach ($artists as $artist) {
            $result[] = array(
                'name'          => $artist['name'],
                'link'          => $artist['alias'],
                'description'   => $artist['description'],
                'image'         => Model::getImage($artist['files'], $artist['fb_id'], 'small')
            );
        }

        Cache::set(func_get_args(), $result);
        return $result;
    }

    public static function searchOnFacebook($query, $mild = false)
    {
        $fb_ids = array();
        $artists = Artist::model()->findAll('fb_id > 0');
        foreach ($artists as $artist) {
            $fb_ids[] = $artist->fb_id;
        }

        try {
            $fb_search_data = Facebook::search($query);
            if (isset($fb_search_data['data']) && count($fb_search_data['data'])) {
                $result = array();
                foreach ($fb_search_data['data'] as $item) {
                    if (!in_array($item['id'], $fb_ids) && strstr(strtolower($item['category']), 'musician')) {

                            $result[] = array(
                                'id'    => $item['id'],
                                'name'  => $item['name'],
                                'link'  => 'https://www.facebook.com/' . $item['id'],
                                'image' => 'https://graph.facebook.com/' . $item['id'] . '/picture?type=large'
                            );
                    }

                    if (count($result) == 30) break;
                }
                return count($result) ? $result : false;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function importFromFacebook($fb_id)
    {
        $artist = Artist::model()->find('fb_id = :fb_id', array(':fb_id' => $fb_id));
        if ($artist) {
            return self::get($artist->id);
        }

        try {
            $fb_graph_data = Facebook::get($fb_id);
            if ($fb_graph_data && $artist = Facebook::addArtist($fb_graph_data['name'], $fb_graph_data)) {
                // Clean all artist caches
                Cache::clean(Cache::ARTIST_NS);
                return self::get($artist->id);
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function importGigs($fb_id)
    {
        $artist = Artist::model()->find('fb_id = :fb_id', array(':fb_id' => $fb_id));

        $bit_result = ArtistApi::importArtistGigsFromBandsintown($artist);
        $fb_result = ArtistApi::importArtistGigsFromFacebook($artist);

        return $bit_result + $fb_result;
    }

    // @TODO: Decrease Cyclomatic and NPath complexity
    public static function importArtistGigsFromBandsintown($artist)
    {
        $result = 0;
        $command = new Command(null, null);
        try {
            $dataUrl = 'http://api.bandsintown.com/artists/'
                . rawurlencode($artist->name) . '/events.json?artist_id=fbid_' . $artist->fb_id
                . '&api_version=2.0&app_id=' .  Yii::app()->params['bitApiKey'];

            $data = file_get_contents($dataUrl);
            $data = \CJSON::decode($data);
        } catch (Exception $e) {
            return false;
        }

        if (count($data)) {
            foreach($data as $event) {
                if (isset($event['id'])) {
                    if (isset($event['title']) && isset($event['datetime']) && isset($event['venue'])) {
                        $transaction = $artist->dbConnection->beginTransaction();

                        // Get or create new venue
                        $venue_id = $command->getOrCreateVenue($event['venue']);
                        if (!$venue_id) {
                            $transaction->rollback();
                            continue;
                        }

                        // Create new or use existing gig
                        $gig = $command->getOrCreateGig(array(
                            'ds_id'         => $event['id'],
                            'ds_type'       => DataSource::BANDSINTOWN,
                            'name'          => $event['title'],
                            'description'   => isset($event['description']) ? $event['description'] : '',
                            'venue_id'      => $venue_id,
                            'datetime'      => date('Y-m-d H:i:s', strtotime($event['datetime'])),
                        ));
                        if (!$gig->id) {
                            $transaction->rollback();
                            continue;
                        }

                        // Link gig to artist
                        $artist_gig_id = $command->getOrCreateArtistGig($artist, $gig);
                        if (!$artist_gig_id) {
                            $transaction->rollback();
                            continue;
                        }

                        // Commit result
                        $transaction->commit();
                        $result++;

                        // Clean all artist caches
                        Cache::clean(Cache::GIG_NS);

                        // Create events
                        $artist->getOrCreateEvent(Event::GIG_CREATE, $gig);
                        foreach ($artist->artistPromoters as $artistPromoter) {
                            $artist->getOrCreateEvent(Event::ARTIST_TRACK, $gig, $artistPromoter->promoter);
                        }
                    }
                }
            }
        }

        return $result;
    }

    public static function importArtistGigsFromFacebook($artist)
    {
        $result = 0;
        $command = new Command(null, null);

        $data = Facebook::events($artist->fb_id);
        if (isset($data['data']) && count($data['data'])) {
            foreach ($data['data'] as $event) {
                if (isset($event['id'])) {
                    $event_data = Facebook::get($event['id']);
                    if (!$event_data) {
                        continue;
                    }

                    if ($event_data && isset($event_data['name']) && isset($event_data['location']) && isset($event_data['venue'])) {
                        $transaction = $artist->dbConnection->beginTransaction();

                        // Get or create new venue
                        $venue_id = $command->getOrCreateVenue($event_data['venue']);
                        if (!$venue_id) {
                            $transaction->rollback();
                            continue;
                        }

                        // Create new or use existing gig
                        $gig = $command->getOrCreateGig(array(
                            'ds_id'     => $event_data['id'],
                            'ds_type'   => DataSource::FACEBOOK,
                            'name'      => $event_data['name'],
                            'venue_id'  => $venue_id,
                            'datetime'  => date('Y-m-d H:i:s', strtotime($event_data['start_time'])),
                        ));
                        if (!$gig->id) {
                            $transaction->rollback();
                            continue;
                        }

                        // Link gig to artist
                        $artist_gig_id = $command->getOrCreateArtistGig($artist, $gig);
                        if (!$artist_gig_id) {
                            $transaction->rollback();
                            continue;
                        }

                        // Commit result
                        $transaction->commit();
                        $result++;

                        // Clean all artist caches
                        Cache::clean(Cache::GIG_NS);

                        // Create events
                        $artist->getOrCreateEvent(Event::GIG_CREATE, $gig);
                        foreach ($artist->artistPromoters as $artistPromoter) {
                            $artist->getOrCreateEvent(Event::ARTIST_TRACK, $gig, $artistPromoter->promoter);
                        }
                    }
                }
            }
        }

        return $result;
    }

    public static function getFeaturedArtists()
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        // Get current promoter id
        $promoter = Promoter::getLogged();
        $promoter_id = $promoter ? $promoter->id : 0;

        // Get featured artists
        $artists = Yii::app()->db->createCommand("
            SELECT a.id, a.name, a.alias, a.description, a.fb_id, a.latitude, a.longitude,
                GROUP_CONCAT(DISTINCT f.path) as files,
                COUNT(DISTINCT ag.id) AS gig_count,
                COUNT(DISTINCT ap.id) AS promoter_count,
                (SELECT COUNT(*) FROM artist_promoter WHERE artist_id = a.id AND promoter_id = " . $promoter_id . ") AS following
            FROM artist a
            LEFT JOIN artist_gig ag ON ag.artist_id = a.id
            LEFT JOIN gig g ON ag.gig_id = g.id
            LEFT JOIN artist_promoter ap ON ap.artist_id = a.id
            LEFT JOIN promoter p ON ap.promoter_id = p.id
            LEFT JOIN artist_file af ON af.artist_id = a.id
            LEFT JOIN file f ON f.id = af.file_id
            WHERE g.datetime_from >= '" . date('Y-m-d') . "'
              AND (ag.status = " . ArtistGig::STATUS_CONFIRMED . " OR ag.status = " . ArtistGig::STATUS_ACCEPTED . ")
            GROUP BY a.id
            ORDER BY gig_count DESC
            LIMIT 6;"
        )->queryAll();

        if ($artists) {
            $result = array_map(array('ArtistApi', 'getFormatted'), $artists);
            Cache::set(func_get_args(), $result);
            return $result;
        }

        return false;
    }

    public static function getArtistsCount()
    {
        // Check cache
        $result = Cache::get(func_get_args());
        if ($result) return $result;

        $result = Yii::app()->db->createCommand("
            SELECT COUNT(id)
            FROM artist
        ")->queryScalar();

        Cache::set(func_get_args(), $result);
        return $result;
    }

    public static function getFormatted($artist)
    {
        return array(
            'id'                => $artist['id'],
            'image'             => Model::getImage($artist['files'], $artist['fb_id']),
            'name'              => $artist['name'],
            'link'              => '/' . $artist['alias'],
            'description'       => $artist['description'],
            'gig_count'         => $artist['gig_count'],
            'promoter_count'    => $artist['promoter_count'],
            'latitude'          => $artist['latitude'],
            'longitude'         => $artist['longitude'],
            'following'         => isset($artist['following']) && !empty($artist['following']) ? 1 : 0
        );
    }
}
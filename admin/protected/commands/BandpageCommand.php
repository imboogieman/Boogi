<?php


class BandpageCommand extends Command
{
    public function __construct($name, $runner)
    {
        parent::__construct($name, $runner);
        $this->_dataSource = DataSource::BANDPAGE;
    }

    // @TODO: Decrease Cyclomatic complexity, NPath complexity
    // @TODO: Split method for submethods, decrease the number of lines
    public function actionUpdateEvents()
    {
        if (!$access_token = $this->_getBandpageAccessToken()) {
            return -1;
        }

        $processed = $artistCounter = $eventCounter = $venueCounter = 0;
        $gigCounter = $artistGigCounter = $updatedCounter = 0;
        $artists = Artist::model()->findAll('bp_id > 0 AND ds_type = :ds_type', array(':ds_type' => $this->_dataSource));

        // Get all existing GIGs DS ids
        $existingDataSourceIds = Gig::getDSIds($this->_dataSource);

        // Check all artist in DB
        $importedDataSourceIds = array();
        foreach ($artists as $artist) {
            $artistCounter++;
            try {
                $context = stream_context_create(array(
                    'http' => array(
                        'method'    => 'GET',
                        'header'    => 'Authorization: Bearer ' . $access_token
                    )
                ));

                $url = 'https://api-read.bandpage.com/' . $artist->bp_id . '/events';
                $data = file_get_contents($url, false, $context);

                if ($http_response_header[0] != 'HTTP/1.1 200 OK') {
                    Command::log($http_response_header[0], CLogger::LEVEL_ERROR, __CLASS__);
                    continue;
                } else {
                    $data = \CJSON::decode($data);
                }
            } catch (Exception $e) {
                Command::log($e->getMessage(), CLogger::LEVEL_ERROR, __CLASS__);
                continue;
            }

            if (count($data)) {
                foreach ($data as $event) {
                    $processed++;

                    if (isset($event['bid'])) {
                        if (isset($event['name']) && isset($event['localDatetime']) && isset($event['venue'])) {
                            $transaction = $artist->dbConnection->beginTransaction();

                            // Get or create new venue
                            $venue_id = $this->getOrCreateVenue($data['venue']);
                            if (!$venue_id) {
                                $this->_printErrors($this->_errors);
                                $transaction->rollback();
                                continue;
                            }
                            if ($this->_isVenueCreated) {
                                $venueCounter++;
                            }

                            // Create new or use existing gig
                            $gig = $this->getOrCreateGig(array(
                                'ds_id'     => $data['bid'],
                                'ds_type'   => $this->_dataSource,
                                'name'      => $data['name'],
                                'venue_id'  => $venue_id,
                                'datetime'  => date('Y-m-d H:i:s', $data['localDatetime']),
                            ));
                            if (!$gig->id) {
                                $this->_printErrors($this->_errors);
                                $transaction->rollback();
                                continue;
                            }
                            if ($this->_isGigCreated) {
                                $gigCounter++;
                            }

                            // Link gig to artist
                            $artist_gig_id = $this->getOrCreateArtistGig($artist, $gig);
                            if (!$artist_gig_id) {
                                $this->_printErrors($this->_errors);
                                $transaction->rollback();
                                continue;
                            }
                            if ($this->_isArtistGigCreated) $artistGigCounter++;

                            // Commit result
                            $transaction->commit();

                            // Log message
                            $message = 'Gig ' . $event['title'] . ($this->_isGigCreated ? ' created' : ' updated');
                            Command::log($message, CLogger::LEVEL_INFO, __CLASS__, false, true);

                            // Calculate counters
                            $importedDataSourceIds[] = $data['id'];
                            $updatedCounter++;

                            // Create events
                            if (!in_array($data['bid'], $existingDataSourceIds)) {
                                $artist->getOrCreateEvent(Event::GIG_CREATE, $gig);
                                foreach ($artist->artistPromoters as $artistPromoter) {
                                    $artist->getOrCreateEvent(Event::ARTIST_TRACK, $gig, $artistPromoter->promoter);
                                    $eventCounter++;
                                }
                                $eventCounter++;
                            }
                        }
                    }
                }
            }
        }

        // Clean unused GIGs
        try {
            $gigsDeleted = Gig::clean($importedDataSourceIds, $this->_dataSource);
        } catch (Exception $e) {
            $gigsDeleted = -1;
            Command::log($e->getMessage(), CLogger::LEVEL_ERROR, __CLASS__);
        }

        // Show report
        $message = 'Artists processed: ' . $artistCounter .
            '; Artist gigs: ' . $artistGigCounter .
            '; Gigs processed: ' . $processed .
            '; Gigs updated: ' . ($updatedCounter - $gigCounter) .
            '; Gigs created: ' . $gigCounter .
            '; Gigs deleted: ' . $gigsDeleted .
            '; Events: ' . $eventCounter .
            '; Venues: ' . $venueCounter;

        Command::log($message, CLogger::LEVEL_INFO, __CLASS__, false, true);
        return 0;
    }

    private function _getBandpageAccessToken()
    {
        $bpAppId = Yii::app()->params['bpAppId'];
        $bpSecret = Yii::app()->params['bpSecret'];

        try {
            $url = 'https://api-read.bandpage.com/token';

            $query = http_build_query(array(
                'client_id'     => $bpAppId,
                'grant_type'    => 'client_credentials'
            ));

            $context = stream_context_create(array(
                'http' => array(
                    'method'    => 'POST',
                    'header'    => 'Authorization: Basic ' . base64_encode($bpAppId . ':' . $bpSecret),
                    'content'   => $query
                )
            ));

            $data = file_get_contents($url, false, $context);
            $data = \CJSON::decode($data);
        } catch (Exception $e) {
            Command::log($e->getMessage(), CLogger::LEVEL_ERROR, __CLASS__);
            return 0;
        }

        if (isset($data['access_token'])) {
            return $data['access_token'];
        }

        Command::log('Authorization failed', CLogger::LEVEL_ERROR, __CLASS__);
        return 0;
    }
}

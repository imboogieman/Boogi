<?php


class FacebookCommand extends Command
{
    protected $errors;

    public function __construct($name, $runner)
    {
        parent::__construct($name, $runner);
        $this->_dataSource = DataSource::FACEBOOK;
    }

    // @TODO: Decrease Cyclomatic complexity, NPath complexity
    // @TODO: Split method for submethods, decrease the number of lines
    public function actionUpdateEvents()
    {
        if (!$access_token = $this->_getFacebookAccessToken()) {
            return -1;
        }

        $processed = $artistCounter = $eventCounter = $venueCounter = $gigCounter = $artistGigCounter = $updatedCounter = 0;
        $artists = Artist::model()->findAll('fb_id > 0 AND ds_type = :ds_type', array(':ds_type' => $this->_dataSource));

        // Get all existing GIGs DS ids
        $existingDataSourceIds = Gig::getDSIds($this->_dataSource);

        // Check all artist in DB
        $importedDataSourceIds = array();
        foreach ($artists as $artist) {
            $artistCounter++;
            try {
                $data_url = 'https://graph.facebook.com/' . $artist->fb_id . '/events?' . $access_token;
                $data = file_get_contents($data_url, false, $this->_context());
                $data = \CJSON::decode($data);
            } catch (Exception $e) {
                Command::error($e->getMessage());
                continue;
            }

            if (isset($data['data']) && count($data['data'])) {
                foreach ($data['data'] as $event) {
                    $processed++;

                    if (isset($event['id'])) {
                        try {
                            $data_url = 'https://graph.facebook.com/' . $event['id'] . '?' . $access_token;
                            $data = file_get_contents($data_url, false, $this->_context());
                            $data = \CJSON::decode($data);
                        } catch (Exception $e) {
                            Command::error($e->getMessage());
                            continue;
                        }

                        if ($data && isset($data['name']) && isset($data['location']) && isset($data['venue'])) {
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
                                'ds_id' => $data['id'],
                                'ds_type' => $this->_dataSource,
                                'name' => $data['name'],
                                'venue_id' => $venue_id,
                                'datetime' => date('Y-m-d H:i:s', strtotime($data['start_time'])),
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
                            if ($this->_isArtistGigCreated) {
                                $artistGigCounter++;
                            }

                            // Commit result
                            $transaction->commit();

                            // Log message
                            $message = 'Gig ' . $data['name'] . ($this->_isGigCreated ? ' created' : ' updated');
                            Command::info($message);

                            // Calculate counters
                            $importedDataSourceIds[] = $data['id'];
                            $updatedCounter++;

                            // Create events
                            if (!in_array($data['id'], $existingDataSourceIds)) {
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
            Command::error($e->getMessage());
        }

        // Show report
        $updatedCounter = ($updatedCounter - $gigCounter) > 0 ? ($updatedCounter - $gigCounter) : 0;
        $message = 'Artists processed: ' . $artistCounter .
            '; Artist gigs: ' . $artistGigCounter .
            '; Gigs processed: ' . $processed .
            '; Gigs updated: ' . $updatedCounter .
            '; Gigs created: ' . $gigCounter .
            '; Gigs deleted: ' . $gigsDeleted .
            '; Events: ' . $eventCounter .
            '; Venues: ' . $venueCounter;

        Command::info($message);
        return 0;
    }

    // @TODO: Decrease Cyclomatic complexity
    public function actionUpdateArtists()
    {
        $updated = 0;
        $artists = Artist::model()->findAll('fb_id > 0');

        // Update artists
        foreach ($artists as $artist) {
            try {
                $url = 'https://graph.facebook.com/' . $artist->fb_id;
                $data = file_get_contents($url, false, $this->_context());
                $data = \CJSON::decode($data);
            } catch (Exception $e) {
                Command::error($e->getMessage());
                continue;
            }

            if ($data) {
                // Try to get location from google
                if (empty($artist->latitude) && empty($artist->longitude)) {
                    if (!empty($data['hometown'])) {
                        $artist->description = $data['hometown'];
                    }

                    if ($artist->description) {
                        try {
                            $url = 'http://maps.google.com/maps/api/geocode/json?sensor=false&address=' . urlencode($data['hometown']);
                            $data = file_get_contents($url, false, $this->_context());
                            $data = \CJSON::decode($data);
                        } catch (Exception $e) {
                            Command::error($e->getMessage());
                            continue;
                        }

                        if ($data['status'] == 'OK') {
                            $artist->description = $data['results'][0]['formatted_address'];

                            $geometry = $data['results'][0]['geometry'];
                            $artist->latitude = $geometry['location']['lat'];
                            $artist->longitude = $geometry['location']['lng'];
                        }
                    }
                }

                $artist->save();
                $updated++;
            }
        }

        Command::info('Update counters: a = ' . $updated);
        return 0;
    }
}

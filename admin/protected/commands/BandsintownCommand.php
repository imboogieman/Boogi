<?php


class BandsintownCommand extends Command
{

    public function __construct($name, $runner)
    {
        parent::__construct($name, $runner);
        $this->_dataSource = DataSource::BANDSINTOWN;
    }

    // @TODO: Decrease Cyclomatic complexity, NPath complexity
    // @TODO: Split method for submethods, decrease the number of lines
    public function actionUpdateEvents()
    {
        $processed = $artistCounter = $eventCounter = $venueCounter = $gigCounter = $artistGigCounter = $updatedCounter = 0;
        $artists = Artist::model()->findAll('fb_id > 0');

        // Get all existing GIGs DS ids
        $existingDataSourceIds = Gig::getDSIds($this->_dataSource);

        // Check all artist in DB
        $importedDataSourceIds = array();
        foreach ($artists as $artist) {
            $artistCounter++;
            try {
                $url = 'http://api.bandsintown.com/artists/'
                    . rawurlencode($artist->name) . '/events.json?artist_id=fbid_' . $artist->fb_id
                    . '&api_version=2.0&app_id=' .  Yii::app()->params['bitApiKey'];

                $context = stream_context_create(array('http' => array('ignore_errors' => true)));
                $data = file_get_contents($url, false, $context);
                $data = \CJSON::decode($data);
            } catch (Exception $e) {
                Command::error($e->getMessage());
                continue;
            }

            if (count($data)) {
                foreach($data as $event) {
                    $processed++;

                    if (isset($event['id'])) {
                        if (isset($event['title']) && isset($event['datetime']) && isset($event['venue'])) {
                            $transaction = $artist->dbConnection->beginTransaction();

                            // Get or create new venue
                            $venue_id = $this->getOrCreateVenue($event['venue']);
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
                                'ds_id'         => $event['id'],
                                'ds_type'       => $this->_dataSource,
                                'name'          => $event['title'],
                                'description'   => isset($event['description']) ? $event['description'] : '',
                                'venue_id'      => $venue_id,
                                'datetime'      => date('Y-m-d H:i:s', strtotime($event['datetime'])),
                            ));
                            if (!$gig->id) {
                                $this->_printErrors($this->_errors);
                                $transaction->rollback();
                                continue;
                            }
                            if ($this->_isGigCreated) $gigCounter++;

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
                            $message = 'Gig ' . $event['title'] . ($this->_isGigCreated ? ' created' : ' updated');
                            Command::info($message);

                            // Calculate counters
                            $importedDataSourceIds[] = $event['id'];
                            $updatedCounter++;

                            // Create events
                            if (!in_array($event['id'], $existingDataSourceIds)) {
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
}

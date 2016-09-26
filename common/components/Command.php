<?php
/**
 * Command is the customized base command class.
 * All command classes for this application should extend from this base class.
 */
class Command extends CConsoleCommand
{
    protected $_dataSource;
    protected $_errors;
    protected $_isGigCreated;
    protected $_isVenueCreated;
    protected $_isArtistGigCreated;

    /**
     * @param $message
     * @param string $level (optional) default INFO
     * @param string $category (optional) default command
     * @param bool $log (optional) default True
     * @param bool $out (optional) default True
     */
    public static function log($message, $level = CLogger::LEVEL_INFO, $category = __CLASS__, $log = true, $out = true)
    {
        if ($log) Yii::log($message, $level, $category);
        if ($out) echo '[' . strtoupper($level) . '] ' . $message . PHP_EOL;
    }

    /**
     * @param $message
     */
    public static function info($message)
    {
        Command::log($message, CLogger::LEVEL_INFO, __CLASS__, false, true);
    }

    public static function error($message)
    {
        Command::log($message, CLogger::LEVEL_ERROR, __CLASS__);
    }
    /**
     * @param Event|Venue|Artist $model
     * @return int
     */
    protected function _updateRecords($model)
    {
        $updated = $deleted = $skipped = $error = 0;
        $records = $model->findAll();
        Command::info(count($records) . ' ' . get_class($model) .'(s) will be updated');

        // Update records
        foreach($records as $record) {
            switch ($record->updateData()) {
                case Model::STATUS_UPDATED:
                    $updated++;
                    break;
                case Model::STATUS_ERROR:
                    $error++;
                    break;
                case Model::STATUS_DELETED:
                    $deleted++;
                    break;
                default:
                    $skipped++;
                    break;
            }
        }

        Command::info('Result u:' . $updated . '; d:' . $deleted . '; s:' . $skipped . '; e:' . $error);
        return 0;
    }

    /**
     * Recursive read directory and return array of allowed files
     * @param string $directory
     * @return array|bool $result
     */
    protected function _getDirList($directory)
    {
        clearstatcache();
        $result = array();

        try {
            $directory = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
            foreach ($directory as $filename => $path) {
                if ($path->isFile()) {
                    $result[] = realpath($filename);
                }
            }
            return $result;
        } catch (Exception $e) {
            Command::error($e->getMessage());
            return false;
        }
    }

    /**
     * Get or create gig by DataSource
     * @param mixed $data
     * @return Gig|null
     * @TODO: Decrease Cyclomatic complexity, NPath complexity
     */
    public function getOrCreateGig($data)
    {
        // Check ids
        if (!isset($data['ds_id']) || !isset($data['ds_type'])) {
            $this->_errors = array();
            if (!isset($data['ds_id'])) {
                $this->_errors[] = array(
                    'field'     => 'ds_id',
                    'message'   => 'Has empty value'
                );
            }
            if (!isset($data['ds_type'])) {
                $this->_errors[] = array(
                    'field'     => 'ds_type',
                    'message'   => 'Has empty value'
                );
            }
            return 0;
        }

        // Get or create new gig
        $gig = Gig::model()->find('ds_id = :ds_id AND ds_type = :ds_type', array(
            ':ds_id'    => $data['ds_id'],
            ':ds_type'  => $data['ds_type']
        ));
        if (!$gig) {
            $this->_isGigCreated = true;

            $gig            = new Gig;
            $gig->user_id   = DataSource::DEFAULT_IMPORT_USER;
            $gig->ds_id     = $data['ds_id'];
            $gig->ds_type   = $data['ds_type'];
        } else {
            $this->_isGigCreated = false;
        }

        // Update gig data
        $gig->name          = isset($data['name']) ? strip_tags($data['name']) : '';
        $gig->description   = isset($data['description']) ? strip_tags($data['description']) : '';
        $gig->venue_id      = isset($data['venue_id']) ? $data['venue_id'] : '';
        $gig->datetime_from = isset($data['datetime']) ? $data['datetime'] : '';
        $gig->datetime_to   = date('Y-m-d H:i:s', strtotime($gig->datetime_from) + 60 * 60 * 24);
        $gig->price         = 1;

        // Save result and return
        if ($gig->save()) {
            return $gig;
        } else {
            $this->_errors = $gig->getErrors();
        }

        return false;
    }

    /**
     * Get or create venue by DataSource
     * @param mixed $data
     * @return Venue|null
     * @TODO: Decrease Cyclomatic complexity, NPath complexity
     */
    public function getOrCreateVenue($data)
    {
        // Check coords
        if (!isset($data['latitude']) || !isset($data['longitude'])) {
            $this->_errors = array();
            if (!isset($data['latitude'])) {
                $this->_errors[] = array(
                    'field'     => 'latitude',
                    'message'   => 'Has empty value'
                );
            }
            if (!isset($data['longitude'])) {
                $this->_errors[] = array(
                    'field'     => 'longitude',
                    'message'   => 'Has empty value'
                );
            }
            return 0;
        }

        // Check existing Venue
        $venue = Venue::model()->find('latitude = :latitude AND longitude = :longitude', array(
            ':latitude' => (float)$data['latitude'], ':longitude' => (float)$data['longitude']
        ));
        if ($venue) {
            $this->_isVenueCreated = false;
            return $venue->id;
        }

        // Create new venue
        $venue = new Venue;

        $venue->ds_id       = isset($data['id']) ? $data['id'] : 0;
        $venue->ds_type     = $this->_dataSource;

        $country = null;
        if (isset($data['country'])) {
            if ($this->_dataSource == DataSource::BANDPAGE) {
                if ($country = Country::getByISO2($data['country'])) {
                    $venue->country_id  = $country->id;
                }
            } else {
                if ($country = Country::getByName($data['country'])) {
                    $venue->country_id  = $country->id;
                }
            }
        }

        $venue->name        = isset($data['name']) ? strip_tags($data['name']) : '';
        $venue->city        = isset($data['city']) ? strip_tags($data['city']) : '';
        $venue->address     = isset($data['address']) ?
            strip_tags($data['address']) : isset($data['name']) ? strip_tags($data['name']) : '';
        $venue->latitude    = isset($data['latitude']) ? $data['latitude'] : '';
        $venue->longitude   = isset($data['longitude']) ? $data['longitude'] : '';

        if (empty($venue->name)) {
            $name = array();
            if ($country) {
                $name[] = $country->name;
            }
            if ($venue->city) {
                $name[] = $venue->city;
            }
            $venue->name = implode(', ', $name);
        }
        $venue->name = substr($venue->name, 0, 64);

        if ($venue->save()) {
            $this->_isVenueCreated = true;
            return $venue->id;
        } else {
            $this->_errors = $venue->getErrors();
        }

        return 0;
    }

    /**
     * Get or create gig by DataSource
     * @param Artist $artist
     * @param Gig $gig
     * @return ArtistGig|null
     */
    public function getOrCreateArtistGig($artist, $gig)
    {
        // Check existing ArtistGig
        $artistGig = ArtistGig::model()->find('artist_id = :artist_id AND gig_id = :gig_id', array(
            ':artist_id'=> $artist->id,
            ':gig_id'   => $gig->id
        ));
        if ($artistGig) {
            $this->_isArtistGigCreated = false;
            return $artistGig->id;
        }

        // Create new ArtistGig
        $artistGig                  = new ArtistGig;
        $artistGig->artist_id       = $artist->id;
        $artistGig->gig_id          = $gig->id;
        $artistGig->datetime_from   = $gig->datetime_from;
        $artistGig->datetime_to     = $gig->datetime_to;
        $artistGig->status          = ArtistGig::STATUS_ACCEPTED;
        $artistGig->price           = 1;

        if ($artistGig->save()) {
            $this->_isArtistGigCreated = true;
            return $artistGig->id;
        } else {
            $this->_errors = $artistGig->getErrors();
        }

        return false;
    }

    protected function _context()
    {
        return stream_context_create(
            array(
                'http' => array(
                    'ignore_errors' => true
                )
            )
        );
    }

    protected function _printErrors($errors)
    {
        if ($errors) {
            foreach ($errors as $e) {
                Command::error($e['field'] . ' - ' . $e['message']);
            }
        }
    }

    protected function _getFacebookAccessToken()
    {
        $fbAppId = Yii::app()->params['fbAppId'];
        $fbSecret = Yii::app()->params['fbSecret'];

        try {
            $data_url = 'https://graph.facebook.com/oauth/access_token?client_id=' .
                $fbAppId . '&client_secret=' . $fbSecret . '&grant_type=client_credentials';
            return file_get_contents($data_url, false, $this->_context());
        } catch (Exception $e) {
            Command::error($e->getMessage());
            return 0;
        }
    }

    protected function _extractFirstEmail($string)
    {
        $pattern = '/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/';
        $matches = array();
        preg_match_all($pattern, $string, $matches);
        return count($matches) ? $matches[0] : false;
    }
}
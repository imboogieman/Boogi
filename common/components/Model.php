<?php

/**
 * Wrapper class to perform global operation
 * @TODO: Decrease Overall complexity
 * @TODO: Consider refactoring to keep number of methods under 10
 * @TODO: Replace $_SERVER global variable
 */
class Model extends CActiveRecord
{
    const DEFAULT_LATITUDE = 53.9;
    const DEFAULT_LONGITUDE = 27.6;
    const DEFAULT_RADIUS = 1000000;
    const DEFAULT_ADDRESS = 'Minsk, Belarus';

    const STATUS_SKIPPED = 1;
    const STATUS_UPDATED = 2;
    const STATUS_DELETED = 3;
    const STATUS_ERROR = 4;

    const LIMIT = 30;
    const OFFSET = 0;

    /**
     * @var array $character_replace_table replace table for strict symbols
     */
    public static $character_replace_table = array(
         ' '  => '-', '.' => '-', '?' => '-', '/' => '-',
        '\\' => '-', '*' => '-', ':' => '-', '*' => '-',
        '\'' => '-', '<' => '-', '>' => '-', '|' => '-',
        '+'  => '-', ',' => '-', '"' => '-', '_' => '-',
        '&' => 'and', '(' => '', ')' => '', '[' => '',
        ']' => '', '{' => '', '}' => '', '#' => '-',
        '!' => 'i', '^' => '-'
    );

    /**
     * @var array $character_replace_table replace table for strict symbols
     */
    public static $allowed_tags = array(
        '<h3>', '<p>', '<br>', '<b>', '<i>', '<u>',
        '<code>', '<ul>', '<ol>', '<li>', '<img>'
    );

    /**
     * Admin emails
     * @var array
     */
    public static $admin_emails = array(
        'manti.by@gmail.com',
        'roman@wemade.biz',
        'djchantcharmant@gmail.com',
        'ivanovartem915@gmail.com'
    );

    /**
     * Related params
     * @var array
     */
    protected $_related_params = array();

    /**
     * Return current location by client ip
     * @return mixed
     */
    public static function getCurrentLocation()
    {
        return self::getLocationByIp(self::getCurrentIp());
    }

    /**
     * Return location by ip
     * @param string $ip
     * @return mixed
     */
    public static function getLocationByIp($ip)
    {
        $link = 'http://www.iptolatlng.com?ip=' . urlencode($ip);
        return CJSON::decode(file_get_contents($link));
    }

    /**
     * Return client ip
     * @return string
     */
    public static function getCurrentIp()
    {
        if (Yii::app()->params['isDebug']) {
            return '178.126.63.149';
        }

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Bind params for related models
     * @param array $post
     */
    public function bindRelatedParams($post)
    {
        if (count($this->_related_params)) {
            foreach ($this->_related_params as $key => $value) {
                if (isset($post[$key])) $this->_related_params[$key] = $post[$key];
            }
        }
    }

    /**
     * Return original image
     * @return string
     * @TODO: Decrease NPath complexity
     */
    public function getMainImage($relative = True)
    {
        $entity = $this->tableName() . 'Files';

        if ($this->$entity) {
            $images = $this->$entity;
            $image = end($images);
            return $relative ? '/' . $image->file->path : Yii::app()->params['baseUrl'] . '/' . $image->file->path;
        }

        if (isset($this->fb_id) && $this->fb_id > 0) {
            return 'https://graph.facebook.com/' . $this->fb_id . '/picture?type=large';
        }

        if (isset($this->ds_id) && $this->ds_id > 0 && $this->ds_type == DataSource::FACEBOOK) {
            return 'https://graph.facebook.com/' . $this->ds_id . '/picture?type=large';
        }

        return $relative ? '/images/default.png' : Yii::app()->params['baseUrl'] . '/images/default.png';
    }

    /**
     * Return cropped image
     * @return string
     * @TODO: Decrease NPath complexity
     */
    public function getCropImage($relative = True)
    {
        $entity = $this->tableName() . 'Files';

        if ($this->$entity) {
            $images = $this->$entity;
            $image = end($images);
            return $relative ? '/' . $image->file->crop : Yii::app()->params['baseUrl'] . '/' . $image->file->crop;
        }

        if (isset($this->fb_id) && $this->fb_id > 0) {
            return 'https://graph.facebook.com/' . $this->fb_id . '/picture?width=250&height=250';
        }

        if (isset($this->ds_id) && $this->ds_id > 0 && $this->ds_type == DataSource::FACEBOOK) {
            return 'https://graph.facebook.com/' . $this->ds_id . '/picture?width=250&height=250';
        }

        return $relative ? '/images/default.png' : Yii::app()->params['baseUrl'] . '/images/default.png';
    }

    /**
     * Return cropped image
     * @return string
     * @TODO: Decrease NPath complexity
     */
    public function getThumbImage($relative = True)
    {
        $entity = $this->tableName() . 'Files';

        if ($this->$entity) {
            $images = $this->$entity;
            $image = end($images);
            return $relative ? '/' . $image->file->thumb : Yii::app()->params['baseUrl'] . '/' . $image->file->thumb;
        }

        if (isset($this->fb_id) && $this->fb_id > 0) {
            return 'https://graph.facebook.com/' . $this->fb_id . '/picture?width=50&height=50';
        }

        if (isset($this->ds_id) && $this->ds_id > 0 && $this->ds_type == DataSource::FACEBOOK) {
            return 'https://graph.facebook.com/' . $this->ds_id . '/picture?width=50&height=50';
        }

        return $relative ? '/images/default.png' : Yii::app()->params['baseUrl'] . '/images/default.png';
    }

    public function getImageTag($width = 80)
    {
        return '<img src="' . $this->getMainImage(false) . '" width="' . $width . '" />';
    }

    public static function getImage($files, $fb_id = null, $size = 'original')
    {
        if (!empty($files)) {
            $files = explode(',', $files);
            return '/' . end($files);
        } elseif (!empty($fb_id)) {
            switch($size) {
                case 'crop':
                    $size = '?width=250&height=250';
                    break;
                case 'thumb':
                    $size = '?width=50&height=50';
                    break;
                default:
                    $size = '?type=large';
                    break;
            }
            return 'https://graph.facebook.com/' . $fb_id . '/picture' . $size;
        } else {
            return '/images/default.png';
        }
    }

    /**
     * Fix timestamp format
     * @return bool
     */
    protected function beforeValidate()
    {
        $timestamp = CDateTimeParser::parse($this->timestamp, 'dd/MM/yyyy');
        if ($timestamp === false) {
            $this->timestamp = date('Y-m-d H:i:s');
        } else {
            $this->timestamp = date('Y-m-d H:i:s', $timestamp);
        }

        return parent::beforeValidate();
    }

    /**
     * Convert models array to select list
     * @param array $array
     * @param string $key (optional)
     * @param string $val (optional)
     * @return array
     */
    public static function arrayToList($array, $key = 'id', $val = 'name')
    {
        $result = array();

        foreach ($array as $id => $name) {
            $result[] = array(
                $key => $id,
                $val => $name,
            );
        }

        return $result;
    }

    /**
     * Return default site latitude
     * @return float
     */
    public static function getDefaultLatitude()
    {
        return self::DEFAULT_LATITUDE;
    }

    /**
     * Return default site longitude
     * @return float
     */
    public static function getDefaultLongitude()
    {
        return self::DEFAULT_LONGITUDE;
    }

    /**
     * Return default site radius
     * @return int
     */
    public static function getDefaultRadius()
    {
        return self::DEFAULT_RADIUS;
    }

    /**
     * Return default site address
     * @return string
     */
    public static function getDefaultAddress()
    {
        return self::DEFAULT_ADDRESS;
    }

    /**
     * Generate alias from name
     * @param bool $force
     * @return bool
     */
    public function generateAlias($force = false)
    {
        if (empty($this->alias) || $force) {
            $alias = Model::createAlias($this->name);
            $alias = $this->id . ($alias ? '-' . $alias : '');
            $this->alias = substr($alias, 0, 64);
            return parent::save();
        }
        return true;
    }

    /**
     * Create alias from input string
     * @param string $string
     * @return string $string
     */
    public static function translitString($string)
    {
        // Replace non english characters
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    }

    /**
     * Create alias from input string
     * @param string $string
     * @return string $string
     */
    public static function createAlias($string)
    {
        // Replace non english characters
        $string = Model::translitString($string);

        // Convert to lowercase and replace illegal characters
        $string = strtr(strtolower($string), self::$character_replace_table);

        // Remove duplicates
        $string = preg_replace("/-+/", "-", $string);

        // Trim length and return
        return $string != '-' ? $string : '';
    }

    /**
     * Return Model by id or new object
     * @param int $id
     * @return ArtistGig|Gig|Venue|Model
     */
    public static function getOrCreate($id)
    {
        $class_name = get_called_class();

        $object = null;
        if (!empty($id)) {
            $object = $class_name::model($class_name)->findByPk($id);
        }

        if (!$object) {
            $object = new $class_name;
        }

        return $object;
    }

    /**
     * Create event for current object
     * @param string $type
     * @param Model $target
     * @param Model $creator
     * @param int $email_status
     * @return Event
     */
    public function getOrCreateEvent($type, $target, $creator = null, $email_status = Event::EMAIL_NOT_SENT)
    {
        $event = Event::model()->find('type = :type AND init_id = :init_id AND init_type = :init_type AND target_id = :target_id AND target_type = :target_type', array(
            ':type'         => $type,
            ':init_id'      => $this->id,
            ':init_type'    => get_class($this),
            ':target_id'    => $target->id,
            ':target_type'  => get_class($target)
        ));
        if (!$event) {
            $event = new Event;
            $event->datetime = date('Y-m-d H:i:s');

            if (!empty($email_status)) {
                $event->email_status = $email_status;
            }
        }
        $event->type = $type;

        $event->init_id = $this->id;
        $event->init_link = $this->getLink();
        $event->init_name = $this->name;
        $event->init_type = get_class($this);

        $event->target_id = $target->id;
        $event->target_link = $target->getLink();
        $event->target_name = $target->name;
        $event->target_type = get_class($target);

        if (!empty($creator)) {
            $event->creator_id = $creator->id;
            $event->creator_link = $creator->getLink();
            $event->creator_name = $creator->name;
            $event->creator_type = get_class($creator);
        }

        // Save and send admin notification
        if ($event->save()) {
            // Di
            if ($type == Event::BOOKING_CREATE && false) {
                $eventEmail = new EventEmail($event);
                $adminEmail = Yii::app()->params['adminEmail'];
                $eventEmail->setTo($adminEmail);
                $eventEmail->send();
            }
            return $event;
        }

        return false;
    }

    /**
     * Return formatted date for object timestamp
     * @param string $format
     * @return string
     */
    public function getDate($format = 'D, d M Y')
    {
        return $this->timestamp ? date($format, strtotime($this->timestamp)) : '';
    }

    /**
     * Sort list by date
     * @param Model $a
     * @param Model $b
     * @return int
     */
    public static function sortByDate($a, $b)
    {
        $a = strtotime($a['date']);
        $b = strtotime($b['date']);

        if ($a == $b) {
            return 0;
        }

        return ($a > $b) ? -1 : 1;
    }

    /**
     * Sort list by timestamp
     * @param Model $a
     * @param Model $b
     * @return int
     */
    public static function sortByTimestamp($a, $b)
    {
        if ($a['timestamp'] == $b['timestamp']) {
            return 0;
        }

        return ($a['timestamp'] > $b['timestamp']) ? -1 : 1;
    }

    /**
     * Return artist frontend link
     * @return string
     */
    public function getLink()
    {
        $class = strtolower(get_class($this));
        return '/' . $class . '/' . $this->alias;
    }

    /**
     * Return artist frontend link
     * @param string $type
     * @param int $target_id
     * @return CDbCacheDependency|CChainedCacheDependency
     * @TODO: Remove unused before check
     */
    public static function getCacheDependency($type, $target_id = null)
    {
        $userDependency = new CDbCacheDependency("SELECT timestamp FROM user WHERE id = " . (int)$target_id);
        $artistDependency = new CDbCacheDependency("SELECT timestamp FROM artist WHERE user_id = " . (int)$target_id);
        $promoterDependency = new CDbCacheDependency("SELECT timestamp FROM promoter WHERE user_id = " . (int)$target_id);

        $artistGigDependency = new CDbCacheDependency("SELECT MAX(timestamp) FROM artist_gig");
        $artistFileDependency = new CDbCacheDependency("SELECT MAX(timestamp) FROM artist_file");

        $artistPromoterDependency = new CDbCacheDependency("SELECT MAX(timestamp) FROM artist_promoter");
        $promoterPromoterDependency = new CDbCacheDependency("SELECT MAX(timestamp) FROM promoter_promoter");

        $eventDependency = new CDbCacheDependency("SELECT MAX(timestamp) FROM event");
        $gigDependency = new CDbCacheDependency("SELECT MAX(timestamp) FROM gig");
        $venueDependency = new CDbCacheDependency("SELECT MAX(timestamp) FROM venue");
        $messageDependency = new CDbCacheDependency("SELECT MAX(timestamp) FROM message");

        switch($type) {
            case 'artist':
                return new CChainedCacheDependency(array(
                    $artistDependency, $artistPromoterDependency
                ));
            case 'artist_gig':
                return new CChainedCacheDependency(array(
                    $artistDependency, $gigDependency, $artistGigDependency
                ));
            case 'artist_list':
                return new CChainedCacheDependency(array(
                    $userDependency, $artistDependency, $artistGigDependency, $artistFileDependency, $artistPromoterDependency
                ));
            case 'gig':
                return $gigDependency;
            case 'gig_list':
                return new CChainedCacheDependency(array(
                    $gigDependency, $venueDependency
                ));
            case 'promoter':
                return new CChainedCacheDependency(array(
                    $promoterDependency, $artistPromoterDependency, $promoterPromoterDependency
                ));
            case 'promoter_list':
                return new CChainedCacheDependency(array(
                    $promoterDependency, $promoterPromoterDependency
                ));
            case 'event':
                return $eventDependency;
            case 'dashboard':
                return new CChainedCacheDependency(array(
                    $promoterPromoterDependency, $artistPromoterDependency, $eventDependency, $gigDependency
                ));
            case 'user':
                return new CChainedCacheDependency(array(
                    $userDependency, $artistDependency, $promoterDependency
                ));
            case 'venue':
                return $venueDependency;
            case 'message':
                return $messageDependency;
        }
    }

    public static function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344);
    }

    public function getErrors($attribute = null)
    {
        $errors = array();
        foreach (parent::getErrors($attribute) as $field => $messages) {
            $errors[] = array(
                'field'     => $field,
                'message'   => implode(', ', $messages)
            );
        }
        return $errors;
    }

    public static function extractFirstEmail($string)
    {
        $pattern = '/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/';
        $matches = array();
        preg_match_all($pattern, $string, $matches);
        return count($matches) ? $matches[0] : false;
    }

    public static function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $earth_radius = 6371;

//        $delta_lat = deg2rad($latitude2 - $latitude1);
//        $delta_lon = deg2rad($longitude2 - $longitude1);
//
//        $rad = sin($delta_lat/2) * sin($delta_lon/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($delta_lon/2) * sin($delta_lon/2);
//        $distance = $earth_radius * 2 * asin(sqrt($rad));
        $rad = acos( cos( deg2rad($latitude1) ) * cos( deg2rad( $latitude2 ) )
                     * cos( deg2rad( $longitude2 ) - deg2rad($longitude1) )
                     + sin( deg2rad($latitude1) ) * sin( deg2rad( $latitude2 ) ) );
        $distance = $rad * $earth_radius;

        return $distance;
    }

    public static function getPageTitle($url)
    {
        $page = @file_get_contents($url);
        if (!$page) {
            return null;
        }

        $matches = array();
        if (preg_match('/<title>(.*?)<\/title>/', $page, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public static function parseDateTime($date, $time)
    {
        $datetime = DateTime::createFromFormat('d.m.Y h:i A', $date . ' ' . $time);
        return $datetime ? $datetime->format('Y-m-d H:i:s') : $date . ' ' . $time;
    }

    public static function getVersion()
    {
        ob_start();
        $version = '0.8.1';
        system('git rev-list --count v' . $version . '..HEAD');
        $revision = (int)ob_get_contents();
        $version = $version . '.' . sprintf("%d", $revision);
        ob_end_clean();
        return $version;
    }
}

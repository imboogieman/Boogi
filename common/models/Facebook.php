<?php

/**
 * This is the Facebook helper class
 *
 */
class Facebook
{
    public static $access_token;
    public static $errors = array();

    private static $context;

    private static function context()
    {
        if (self::$context) {
            return self::$context;
        }

        self::$context = stream_context_create(array(
            'http' => array(
                'timeout'       => 10,
                'ignore_errors' => true
            )
        ));

        return self::$context;
    }

    public static function getAccessToken()
    {
        if (self::$access_token) {
            return self::$access_token;
        }

        $fbAppId = Yii::app()->params['fbAppId'];
        $fbSecret = Yii::app()->params['fbSecret'];

        try {
            self::$access_token = file_get_contents('https://graph.facebook.com/oauth/access_token?client_id=' .
                $fbAppId . '&client_secret=' . $fbSecret . '&grant_type=client_credentials', false, self::context());

            return self::$access_token;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function get($id)
    {

        try {
            $fb_graph_data = file_get_contents('https://graph.facebook.com/' . $id .
                '?'  . self::getAccessToken(), false, self::context());

            return \CJSON::decode($fb_graph_data);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function search($query)
    {
        try {
            $fb_search_data = file_get_contents('https://graph.facebook.com/search?q=' . urlencode($query) .
                '&type=page&' . self::getAccessToken(), false, self::context());

            return \CJSON::decode($fb_search_data);
        } catch (Exception $e) {
            return false;
        }
    }

    // @TODO: Decrease Cyclomatic and NPath complexity
    public static function addArtist($name, $data)
    {
        $artist = new Artist;
        $transaction = $artist->dbConnection->beginTransaction();

        // Defaults
        $latitude = User::getDefaultLatitude();
        $longitude = User::getDefaultLongitude();
        $description = '';

        if (isset($data['location'])) {
            $latitude = $data['location']['latitude'];
            $longitude = $data['location']['longitude'];
            $description = $data['location']['country'] . ', ' . $data['location']['city'];
        } else {
            $address = '';

            if (isset($data['current_location'])) {
                $address = $data['current_location'];
            } elseif (isset($data['hometown'])) {
                $address = $data['hometown'];
            }

            try {
                $address = file_get_contents('http://maps.google.com/maps/api/geocode/json?sensor=false&address='
                    . urlencode($address), false, self::context());

                $address = \CJSON::decode($address);
            } catch (Exception $e) {
                $address = array('status' => 'ERROR');
            }

            if ($address['status'] == 'OK') {
                $geometry = $address['results'][0]['geometry'];
                $latitude = $geometry['location']['lat'];
                $longitude = $geometry['location']['lng'];
                $description = $address['results'][0]['formatted_address'];
            }
        }

        $artist->attributes = array(
            'name' => $name,
            'fb_id' => $data['id'],
            'latitude' => $latitude,
            'longitude' => $longitude,
            'description' => $description,
            'ds_type' => DataSource::FACEBOOK
        );

        $email = '';
        if (isset($data['email'])) {
            $email = $data['email'];
        } elseif (isset($data['general_manager'])) {
            $email = Model::extractFirstEmail($data['general_manager']);
        } elseif (isset($data['booking_agent'])) {
            $email = Model::extractFirstEmail($data['booking_agent']);
        }

        if (!$email && isset($data['username'])) {
            $email = $data['username'] . '@boogi.co';
        } else {
            $email = Model::createAlias($name) . '@boogi.co';
        }

        $artist->bindRelatedParams(array(
            'email' => $email,
            'password' => 'starway2014',
            'role' => USER::ROLE_ARTIST,
        ));

        try {
            if ($artist->save()) {
                $transaction->commit();
                return $artist;
            } else {
                $transaction->rollback();
                self::$errors = $artist->getErrors();
                return false;
            }
        } catch (Exception $e) {
            $transaction->rollback();
            self::$errors[] = array(
                'field'     => null,
                'message'   => '[NOTICE] ' . $e->getCode() . ' ' . $e->getMessage()
            );
            return false;
        }
    }

    public static function events($fb_id)
    {
        try {
            $data = file_get_contents('https://graph.facebook.com/' . $fb_id . '/events?' .
                self::getAccessToken(), false, self::context());

            return \CJSON::decode($data);
        } catch (Exception $e) {
            return false;
        }
    }
}

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
                '?fields=current_location,location,hometown,name,id,emails,general_manager,booking_agent,username&'
                . self::getAccessToken(), false, self::context());

            return \CJSON::decode($fb_graph_data);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function search($query)
    {
        try {
            $fb_search_data = file_get_contents('https://graph.facebook.com/search?q=' . urlencode($query) .
                '&type=page&&fields=id,name.limit(100),category&' . self::getAccessToken(), false, self::context());

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

    public static function getPages($access_token) {
        try {
            $data_url = 'https://graph.facebook.com/v2.8/me/accounts?fields=description,description_html,website,single_line_address,'.
                        'founded,name,phone,category_list,category,start_info&access_token=' . $access_token;
            $data = file_get_contents($data_url, false);
            $data = \CJSON::decode($data);
            return $data;
        } catch (Exception $e) {
            Command::error($e->getMessage());
            return 0;
        }
    }

    public static function getProfile($access_token){
        try {
            $data_url = 'https://graph.facebook.com/v2.5/me?fields=email,first_name,last_name&access_token='
                        . $access_token;
            $data = file_get_contents($data_url, false);
            $data = \CJSON::decode($data);
            return $data;
        } catch (Exception $e) {
            Command::error($e->getMessage());
            return 0;
        }
    }

    public static function generateFbUrl() {

        $fbAppId = Yii::app()->params['fbAppId'];
        $domain = Yii::app()->params['baseUrl'];

        $data_url = 'https://www.facebook.com/dialog/oauth?client_id=' .
                    $fbAppId . '&scope=manage_pages,email,public_profile&redirect_uri='. $domain . 'api/user/fbauth';
        return $data_url;
    }

    public static function getAccessMarker($code){
        $fbAppId = Yii::app()->params['fbAppId'];
        $fbSecret = Yii::app()->params['fbSecret'];
        $domain = Yii::app()->params['baseUrl'];

        $data_url = 'https://graph.facebook.com/v2.8/oauth/access_token?client_id=' .
                    $fbAppId . '&client_secret=' . $fbSecret . '&code=' . $code.
                    '&redirect_uri=' . $domain . 'api/user/fbauth';
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $data_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            curl_close($ch);
            $data = \CJSON::decode($response);

            return $data;
        } catch (Exception $e) {
            Command::error($e->getMessage());
            return 0;
        }
    }
}

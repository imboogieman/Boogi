<?php


class GeoCoder {

    public static $errors = array();

    public static function decode($address)
    {
        try {
            $data = file_get_contents('http://maps.google.com/maps/api/geocode/json?sensor=false&address=' . urlencode($address));
            $data = \CJSON::decode($data);

            if ($data['status'] == 'OK') {
                return array(
                    'id'        => $data['results'][0]['place_id'],
                    'address'   => $data['results'][0]['formatted_address'],
                    'latitude'  => $data['results'][0]['geometry']['lat'],
                    'longitude' => $data['results'][0]['geometry']['lng'],
                );
            }
        } catch (Exception $e) {
            self::$errors[] = $e;
        }
        return false;
    }
}
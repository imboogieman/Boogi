<?php
/**
 * Raw Gig Api Model
 */

class VenueApi
{
    /**
     * Get artist list
     * @param array $data
     * @return bool
     * @TODO: Decrease Cyclomatic and NPath complexity
     */
    public static function update($data)
    {
        // Check required
        if (!$data['data']) {
            return true;
        }

        // Compile update query
        $venue_data = \CJSON::decode($data['data']);
        $set[] = "ds_id=" . (int)$venue_data['id'];
        $set[] = $venue_data['name'] ? "name='" . $venue_data['name'] . "'" : "name='" . $data['name'] . "'";

        if (isset($json['website'])) $set[] = "name='" . $venue_data['website'] . "'";
        if ($country = DataSource::getGoogleGCResponseValue('country', $venue_data)) {
            if ($country = Country::getByISO2($country)) {
                $set[] = "country_id=" . $country->id;
            }
        }

        $city = DataSource::getGoogleGCResponseValue('locality', $venue_data);
        if ($city) $set[] = "city='" . $city . "'";

        $address = DataSource::getGoogleGCResponseValue('route', $venue_data);
        if ($address) {
            $street = DataSource::getGoogleGCResponseValue('street_number', $venue_data);
            if ($street) {
                $set[] = "address='" . $address . ', ' . $street . "'";
            } else {
                $set[] = "address='" . $address . "'";
            }
        }

        $latitude = DataSource::getGoogleGCResponseValue('latitude', $venue_data);
        $longitude = DataSource::getGoogleGCResponseValue('longitude', $venue_data);
        if ($latitude && $longitude) {
            $set[] = "latitude=" . $latitude;
            $set[] = "longitude=" . $longitude;
        }

        $set = implode(',', $set);

        // Clean all artist caches
        Cache::clean(Cache::GIG_NS);

        // Update and return result
        return Yii::app()->db->createCommand("
            UPDATE venue
            SET " . $set . "
            WHERE id = " . $data['id'] . ";
        ")->execute();
    }
}
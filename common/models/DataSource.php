<?php

/**
 * This is the model class helper for external data sources
 */
class DataSource
{
    const STARWAY = 0;
    const FACEBOOK = 1;
    const GOOGLE = 2;
    const BANDSINTOWN = 3;
    const BANDPAGE = 4;
    const RESIDENTADVISOR = 5;
    const GIGATOOLS = 6;
    const SONGKICK = 7;
    const CROWDSURGE = 8;
    const REVERBNATION = 9;

    const DEFAULT_IMPORT_USER = 1;

    // @TODO: Decrease Cyclomatic complexity
    public static function getName($type)
    {
        switch ($type) {
            case self::STARWAY:
                return 'Starway';
            case self::FACEBOOK:
                return 'Facebook';
            case self::GOOGLE:
                return 'Google';
            case self::BANDSINTOWN:
                return 'Bandsintown';
            case self::BANDPAGE:
                return 'Bandpage';
            case self::RESIDENTADVISOR:
                return 'ResidentAdvisor';
            case self::GIGATOOLS:
                return 'GigaTools';
            case self::SONGKICK:
                return 'SongKick';
            case self::CROWDSURGE:
                return 'CrowdSurge';
            case self::REVERBNATION:
                return 'ReverbNation';
            default:
                return 'Unknown';
        }
    }

    public static function getArray()
    {
        return array(
            self::STARWAY,
            self::FACEBOOK,
            self::GOOGLE,
            self::BANDSINTOWN,
            self::BANDPAGE,
            self::RESIDENTADVISOR,
            self::GIGATOOLS,
            self::SONGKICK,
            self::CROWDSURGE,
            self::REVERBNATION
        );
    }

    public static function getList()
    {
        $result = array();
        foreach (self::getArray() as $item) {
            $result[$item] = self::getName($item);
        }
        return $result;
    }

    // @TODO: Decrease Cyclomatic complexity
    public static function getGoogleGCResponseValue($attr, $response)
    {
        if ($attr == 'latitude' || $attr == 'longitude') {
            if (isset($response['geometry']) && isset($response['geometry']['location'])) {
                $location = $response['geometry']['location'];
                if (count($location) == 2) {
                    if ($attr == 'latitude') {
                        return (float) reset($location);
                    } else {
                        return (float) end($location);
                    }
                }
            }
        } else {
            if (isset($response['address_components'])) {
                foreach ($response['address_components'] as $component) {
                    if (isset($component['types']) && in_array($attr, $component['types'])) {
                        return $component['long_name'];
                    }
                }
            }
        }

        return null;
    }

    public static function getForArtistSelect()
    {
        return array(
            self::FACEBOOK      => self::getName(self::FACEBOOK),
            self::BANDSINTOWN   => self::getName(self::BANDSINTOWN),
            self::BANDPAGE      => self::getName(self::BANDPAGE),
        );
    }
}

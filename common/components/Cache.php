<?php

class Cache
{
    const PROMOTER_NS = 'promoter';
    const ARTIST_NS = 'artist';
    const GIG_NS = 'gig';
    const MESSAGE_NS = 'message';

    protected static $_map = array(
        'PromoterApi' => array(
            'get'                   => 'promoter',
            'getList'               => 'promoter-list',
            'getEvents'             => 'promoter-event-list',
            'getFollowedArtists'    => 'promoter-followed-artist-list',
            'getFollowedPromoters'  => 'promoter-followed-promoter-list',
            'getGigs'               => 'promoter-gig-list',
            'getActiveGigs'         => 'promoter-active-gig-list',
            'getPastGigs'           => 'promoter-past-gig-list',
            'getActiveGigsCount'    => 'promoter-active-gig-count',
            'getPastGigsCount'      => 'promoter-past-gig-count'
        ),
        'ArtistApi' => array(
            'get'                   => 'artist',
            'getList'               => 'artist-list',
            'searchByQuery'         => 'artist-search',
            'getFeaturedArtists'    => 'artist-featured-list',
            'getArtistsCount'       => 'artist-count',
            'getActiveGigs'         => 'artist-active-gig-list',
            'getPastGigs'           => 'artist-past-gig-list',
            'getActiveGigsCount'    => 'artist-active-gig-count',
            'getPastGigsCount'      => 'artist-past-gig-count'
        ),
        'GigApi' => array(
            'get'                   => 'gig',
            'getList'               => 'gig-list',
            'getBookingDetails'     => 'gig-details',
            'getByAlias'            => 'gig-search',
            'getBookings'           => 'gig-booking-list'
        ),
        'MessageApi' => array(
            'getList'               => 'message-list',
            'getGigLog'             => 'message-gig-log',
        )
    );

    protected static function _index($class, $method)
    {
        if (isset(self::$_map[$class]) && isset(self::$_map[$class][$method])) {
            return self::$_map[$class][$method];
        }
        return strtolower($class) . '-' . strtolower($method);
    }

    protected static function _getIndexes()
    {
        return Yii::app()->cache->get('indexes');
    }

    protected static function _appendIndex($index)
    {
        $indexes = self::_getIndexes();
        if (!is_array($indexes)) $indexes = array();
        $indexes[] = $index;
        return Yii::app()->cache->set('indexes', $indexes, 300);
    }

    public static function get($data, $class = __CLASS__, $method = __METHOD__)
    {
        if (!Yii::app()->params['enableCache']) return false;

        $index = self::_index($class, $method) .'-' . serialize($data);
        return Yii::app()->cache->get($index);
    }

    public static function set($data, $result, $class = __CLASS__, $method = __METHOD__)
    {
        if (!Yii::app()->params['enableCache']) return false;

        $index = self::_index($class, $method) .'-' . serialize($data);
        if (Yii::app()->cache->set($index, $result, 300)) {
            return self::_appendIndex($index);
        }

        return false;
    }

    public static function clean($namespace)
    {
        if (!Yii::app()->params['enableCache']) return false;

        $indexes = self::_getIndexes();
        foreach ($indexes as $index) {
            if (strstr($index, $namespace)) {
                Yii::app()->cache->delete($index);
            }
        }
    }
}
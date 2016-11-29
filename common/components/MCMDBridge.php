<?php

/**
 * Helper for Mailchimp and Mandrill templates
 * User: Alexander Chaika
 * Date: 2/11/2015
 * Time: 09:09
 */
class MCMDBridge
{
    /**
     * Email templates
     */
    const PROMOTER_REGISTRATION = 1;
    const USER_RESET_PASSWORD = 2;

    const PROMOTER_BOOKING_SEND = 3;
    const PROMOTER_BOOKING_CONFIRM = 4;
    const PROMOTER_BOOKING_ADJUST = 5;
    const PROMOTER_BOOKING_REJECT = 6;

    const PROMOTER_BOOKING_MESSAGE = 7;
    const PROMOTER_BOOKING_MESSAGE_REPLY = 8;

    const USER_ACTIVATION = 10;
    const USER_RETENTION = 11;
    const USER_RETENTION_REPLY = 12;

    const PROMOTER_UPGRADE = 13;
    const PROMOTER_UPDATE = 14;

    const PROMOTER_FOLLOWERS = 15;
    const PROMOTER_GIG_IN_RADIUS = 16;

    const ARTIST_BOOKING_REQUEST = 17;
    const ARTIST_BOOKING_ADJUST = 18;
    const ARTIST_BOOKING_ACCEPT = 19;
    const ARTIST_BOOKING_REJECT = 20;

    const ARTIST_BOOKING_MESSAGE = 21;
    const ARTIST_BOOKING_MESSAGE_REPLY = 22;

    private static $_mc_map = array(
        self::PROMOTER_REGISTRATION => 158777,
        self::USER_RESET_PASSWORD => 163581,

        self::PROMOTER_BOOKING_SEND => 158869,
        self::PROMOTER_BOOKING_CONFIRM => 173981,
        self::PROMOTER_BOOKING_ADJUST => 158929,
        self::PROMOTER_BOOKING_REJECT => 158941,

        self::PROMOTER_BOOKING_MESSAGE => 158961,
        self::PROMOTER_BOOKING_MESSAGE_REPLY=> 158973,

        self::USER_ACTIVATION => 158989,
        self::USER_RETENTION => 158997,
        self::USER_RETENTION_REPLY => 0,

        self::PROMOTER_UPGRADE => 158865,
        self::PROMOTER_UPDATE => 169053,

        self::PROMOTER_FOLLOWERS => 172485,
        self::PROMOTER_GIG_IN_RADIUS => 172533,

        self::ARTIST_BOOKING_REQUEST => 173969,
        self::ARTIST_BOOKING_ADJUST => 173973,
        self::ARTIST_BOOKING_ACCEPT => 158905,
        self::ARTIST_BOOKING_REJECT => 173977,

        self::ARTIST_BOOKING_MESSAGE => 173985,
        self::ARTIST_BOOKING_MESSAGE_REPLY => 0,
    );

    public static function getTemplateNameById($id)
    {
        if ($source_id = self::_getSourceId($id)) {
            $result = Yii::app()->db->createCommand("
                SELECT name
                FROM mailchimp_template
                WHERE source_id = " . $source_id . ";
            ")->queryColumn();
            return count($result) ?  current($result) : false;
        }
        return false;
    }

    protected static function _getSourceId($id)
    {
        return isset(self::$_mc_map[$id]) ? self::$_mc_map[$id] : 0;
    }
}
<?php

/**
 * This is the model class helper for external data sources
 */
class ApiStatus
{
    const SUCCESS = 200;
    const ERROR = 500;
    const NO_RECORDS = 204;
    const REQ_LOGIN = 401;
    const INVALID = 400;
    const NOT_FOUND = 404;

    public static function getName($type)
    {
        switch ($type) {
            case self::SUCCESS:
                return 'SUCCESS';
            case self::ERROR:
                return 'ERROR';
            case self::NO_RECORDS:
                return 'NO_RECORDS';
            case self::REQ_LOGIN:
                return 'REQ_LOGIN';
            case self::INVALID:
                return 'INVALID';
            case self::NOT_FOUND:
                return 'NOT_FOUND';
            default:
                return 'UNKNOWN';
        }
    }

    public static function getArray()
    {
        return array(
            self::SUCCESS,
            self::ERROR,
            self::NO_RECORDS,
            self::REQ_LOGIN,
            self::INVALID,
            self::NOT_FOUND,
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

    public static function getDict()
    {
        $result = array();
        foreach (self::getArray() as $item) {
            $result[self::getName($item)] = $item;
        }
        return $result;
    }
}

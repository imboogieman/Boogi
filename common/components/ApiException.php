<?php

class ApiException extends Exception
{
    const UNKNOWN_ERROR = 1001;
    const PASSWORDS_DOES_NOT_MATCH = 1002;
    const WRONG_PASSWORD = 1003;

    const CAN_NOT_SAVE_FILE = 2001;
    const CAN_NOT_UPLOAD_FILE = 2002;
    const CAN_NOT_MOVE_FILE = 2003;

    private static $_message_map = array(
        self::UNKNOWN_ERROR             => "Unknown Error",
        self::PASSWORDS_DOES_NOT_MATCH  => "Passwords doesn't match",
        self::WRONG_PASSWORD            => "Wrong old password",
        self::CAN_NOT_SAVE_FILE         => "Can't save your picture, please try again",
        self::CAN_NOT_UPLOAD_FILE       => "Can't upload your picture, please try again",
        self::CAN_NOT_MOVE_FILE         => "Somewhere we lost your picture, please try again",
    );

    private static $_field_map = array(
        self::UNKNOWN_ERROR             => "unknown",
        self::PASSWORDS_DOES_NOT_MATCH  => "retype_password",
        self::WRONG_PASSWORD            => "old_password",
        self::CAN_NOT_SAVE_FILE         => "image",
        self::CAN_NOT_UPLOAD_FILE       => "image",
        self::CAN_NOT_MOVE_FILE         => "image",
    );

    public static function raise($code)
    {
        if (isset(self::$_message_map[$code])) {
            throw new ApiException(self::$_message_map[$code], $code);
        } else {
            throw new ApiException(self::$_message_map[self::UNKNOWN_ERROR], self::UNKNOWN_ERROR);
        }
    }

    public function getApiError()
    {
        return array(
            'field'     => ApiException::$_field_map[$this->getCode()],
            'message'   => $this->getMessage()
        );
    }
}
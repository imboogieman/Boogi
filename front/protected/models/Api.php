<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 20.07.15
 * Time: 16:01
 */

class Api {

    /**
     * Add one day to each time if next_day set
     * @param string $time_group
     * @return array
     */
    protected static function _fix_next_day_time($time_group)
    {
        $result = array();
        $time_group = explode(',', $time_group);

        if (!empty($time_group)) {
            foreach ($time_group as $time) {
                $time = explode(':', $time);
                $result[] = $time[1] == 1 ? $time[0] + 60 * 60 * 24 : $time[0];
            }
        }

        return $result;
    }
}
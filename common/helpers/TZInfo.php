<?php


class TZInfo extends DateTimeZone
{

    public static function get($id)
    {
        $id = trim($id);
        if (empty($id)) $id = 'UTC';

        $tz = new DateTimeZone($id);
        $dt = new DateTime('now', $tz);
        $of = $tz->getOffset($dt) / (60 * 60);
        $of = $of < 0 ? '-' . abs($of) : '+' . $of;
        $index = number_format(($tz->getOffset($dt) / (60 * 60)) + 24, 1) . $tz->getName();

        return array(
            'name'      => $tz->getName(),
            'offset'    => $tz->getOffset($dt),
            'index'     => $index,
            'canonical' => '(GMT ' . $of . ') ' . $tz->getName(),
        );
    }

    public static function getAll()
    {
        $result = array();
        $identifiers = DateTimeZone::listIdentifiers();
        foreach ($identifiers as $id) {
            $result[] = TZInfo::get($id);
        }
        usort($result, array('TZInfo', 'sortOrder'));
        return $result;
    }

    public static function getDefault()
    {
        return TZInfo::get('');
    }

    public static function sortOrder($a, $b)
    {
        if ($a['index'] == $b['index']) return 0;
        return $a['index'] > $b['index'] ? 1 : -1;
    }
}
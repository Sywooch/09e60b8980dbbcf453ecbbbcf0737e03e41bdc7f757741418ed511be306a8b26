<?php

class DATA {

    public static $TIME_ZONE = 'Europe/Moscow';

    public static function poster($start, $end) {
        $ns = new DateTimeZone(self::$TIME_ZONE);
        $s = null;
        $d = null;
        if (!empty($start)) {
            $date = new DateTime($start, $ns);
            $s = ' с <b>' . $date->format('H:i d-m-Y') . '</b>';
        }
        if (!empty($end)) {
            $date = new DateTime($start, $ns);
            $d = ' до <b>' . $date->format('H:i d-m-Y') . '</b>';
        }

//        echo $date->format('Y-m-d H:i:sP');
        return $s . $d;
    }

}

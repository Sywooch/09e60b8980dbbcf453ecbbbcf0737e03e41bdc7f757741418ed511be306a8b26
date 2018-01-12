<?php

class DATA {

    public static $TIME_ZONE = 'Europe/Moscow';
    public static $FORMAT = 'd-m-Y H:i';

//     public static $POSTER_COMMENTS = 'd-m-Y H:i';
    public static function getTimeZone() {
        if (!empty(CONTROLER_DOMAIN::getCity()['time_zone'])) {
            return CONTROLER_DOMAIN::getCity()['time_zone'];
        } else {
            return self::$TIME_ZONE;
        }
    }

    public static function poster($start, $end) {
        $s = null;
        $d = null;
        if (!empty($start)) {
            $date = new DateTime($start);
            $s = ' с <b>' . $date->format(self::$FORMAT) . '</b>';
        }
        if (!empty($end)) {
            $date = new DateTime($end);
            $d = ' до <b>' . $date->format(self::$FORMAT) . '</b>';
        }
        return $s . $d;
    }

    public static function comments($data) {
        $start = $data["created_at"];
        $s = null;
        if (!empty($start)) {
            $date = new DateTime($start);
            $date->setTimeZone(new DateTimeZone(self::getTimeZone()));
            $s = $date->format(self::$FORMAT);
        }
        $data["created_at"] = $s;
        $data["updated_at"] = '';
        return $data;
    }

    public static function news($data) {
        if (!empty($data)) {
            foreach ($data as $key => $vol) {
                $start = $vol["date"];
                $s = null;
                if (!empty($start)) {
                    $date = new DateTime($start);
                    $date->setTimeZone(new DateTimeZone(self::getTimeZone()));
                    $s = $date->format(self::$FORMAT);
                }
                $data[$key]["date"] = $s;
            }
        }
        return $data;
    }

    public static function communication($data) {
        $date = new DateTime($data);
        $date->setTimeZone(new DateTimeZone(self::getTimeZone()));
        $data = $date->format(self::$FORMAT);
        return $data;
    }

    public static function posterCheker($end) {
        $data = true;
        $endDate = new DateTime($end);
        $now = new DateTime("now");
        $now->setTimeZone(new DateTimeZone(self::getTimeZone()));
        if ($now > $endDate) {
            $data = false;
        }
        return $data;
    }

}

<?php

class DATA {

    public static $TIME_ZONE = 'Europe/Moscow';
    public static $FORMAT = 'd-m-Y H:i';

//     public static $POSTER_COMMENTS = 'd-m-Y H:i';
    public static function getTimeZone() {
        if (CONTROLER_DOMAIN::getCity()['time_zone']) {
            return CONTROLER_DOMAIN::getCity()['time_zone'];
        } else {
            return self::$TIME_ZONE;
        }
    }

    public static function poster($start, $end) {
        $ns = new DateTimeZone(self::getTimeZone());
        $s = null;
        $d = null;
        if (!empty($start)) {
            $date = new DateTime($start, $ns);
            $s = ' с <b>' . $date->format(self::$FORMAT) . '</b>';
        }
        if (!empty($end)) {
            $date = new DateTime($end, $ns);
            $d = ' до <b>' . $date->format(self::$FORMAT) . '</b>';
        }

//        echo $date->format('Y-m-d H:i:sP');
        return $s . $d;
    }

    public static function comments($data) {
        $start = $data["created_at"];
//        var_dump($start);die;
        $ns = new DateTimeZone(self::getTimeZone());
        $s = null;
        if (!empty($start)) {
            $date = new DateTime($start, $ns);
            $s = $date->format(self::$FORMAT);
        }
        $data["created_at"] = $s;
        $data["updated_at"] = '';
        return $data;
    }

    public static function news($data) {
        if (!empty($data)) {
            $ns = new DateTimeZone(self::getTimeZone());
            foreach ($data as $key => $vol) {
                $start = $vol["date"];
//        var_dump($start);die;

                $s = null;
                if (!empty($start)) {
                    $date = new DateTime($start, $ns);
                    $s = $date->format(self::$FORMAT);
                }
                $data[$key]["date"] = $s;
            }
        }
        return $data;
    }

}

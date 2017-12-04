<?php

class DATA {

    public static $TIME_ZONE = 'Europe/Moscow';
    public static $FORMAT = 'd-m-Y H:i';

//     public static $POSTER_COMMENTS = 'd-m-Y H:i';

    public static function poster($start, $end) {
        $ns = new DateTimeZone(self::$TIME_ZONE);
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
        $ns = new DateTimeZone(self::$TIME_ZONE);
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
            $ns = new DateTimeZone(self::$TIME_ZONE);
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

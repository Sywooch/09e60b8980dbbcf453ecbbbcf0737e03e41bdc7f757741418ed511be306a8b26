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

    public static function comments($data) {
        $start = $data["created_at"];
//        var_dump($start);die;
        $ns = new DateTimeZone(self::$TIME_ZONE);
        $s = null;
        if (!empty($start)) {
            $date = new DateTime($start, $ns);
            $s = $date->format('d-m-Y H:i');
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
                    $s = $date->format('d-m-Y H:i');
                }
                $data[$key]["date"] = $s;
            }
        }
        return $data;
    }

}

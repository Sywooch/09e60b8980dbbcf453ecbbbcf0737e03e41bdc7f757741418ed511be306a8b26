<?php

class CONTROLER_DOMAIN {

    private static $city = null;
    private static $obj = null;

    public static function getCity() {
        if (self::$city === null) {
            self::makeModel();
        }
        return self::$city;
    }

    public static function getObj() {
        if (self::$obj === null) {
            self::makeModel();
        }
        return self::$obj;
    }

    private static function makeModel() {
        $data = null;
        $data = self::domain();
        if (!empty($data)) {
            $citys = self::city();
            if (!empty($citys[$data['city']])) {
                self::$city = $citys[$data['city']];
                self::$obj = $data['obj'];
                if ($data['obj'] == 'api' && $citys[$data['city']]['api'] != 1) {
                    self::$obj = null;
                }
            }
        }
    }

    private static function domain() {
        $data = null;
        $sub = explode(".", strtolower($_SERVER ["SERVER_NAME"]));
//        var_dump($sub);die;
        $pi = explode("-", $sub[0]);
//        var_dump($pi);
//        die;
        if ($pi[0] == 'api') {
            $data['city'] = $pi[1];
            $data['obj'] = 'api';
        } else {
            $data['city'] = $pi[0];
            $data['obj'] = 'manager';
        }
        return $data;
    }

    private static function city() {
        return yaml_parse_file(__DIR__ . '/../framework/config/domain.yml');
    }

}

<?php

define("MAIN_DOMAIN", "city.ooogoroda.mobi");

class MODELING {

    public static function run() {
        $data = [];
        $met = self::getMethod();

        if (!empty($met['error'])) {
            $data['status'] = 'error';
            $data['response'] = $met['error'];
        } else {
            $data['status'] = 'success';
            $data['response'] = $met;
        }

        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
        }
        print json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    private static function getMethod() {
        $data = [];
        $mod = self::getModelName();
        if (!empty($mod)) {
            if (class_exists($mod['model']) && method_exists($mod['model'], $mod['action']) && $mod['model'] != 'DB') {
                $obj = new $mod['model'];
                $met = $obj->$mod['action']();
                if (!empty($met)) {
                    $data = $met;
                }
            }
        }
        return $data;
    }

    private static function getPaths() {
        $paths = array();
        $request = trim($_SERVER["REQUEST_URI"], '/');
        if (!empty(parse_url($request)["path"])) {
            $url = urldecode(parse_url($request)["path"]);
            $paths = array_filter(explode('/', $url), 'trim');
        }
        if (!empty($paths)) {
            return $paths;
        } else {
            return NULL;
        }
    }

    private static function getModelName() {
        $data = null;
        $paths = self::getPaths();
        if (!empty($paths[0]) && empty($paths[1])) {
            $mod = explode('.', $paths[0]);
            if (!empty($mod[1])) {
                $data['model'] = $mod[0];
                $data['action'] = $mod[1];
            }
        }
        return $data;
    }

}

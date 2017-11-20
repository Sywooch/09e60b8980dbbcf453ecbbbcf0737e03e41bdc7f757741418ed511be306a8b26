<?php

class DB {

    private static $connection = NULL;

    function __construct($type = null) {

        $config = require(__DIR__ . '/../../framework/config/db.php');
        $dbname = ROUTING::getCity();
        self::$connection = new mysqli('localhost', $config['username'], $config['password'], $dbname['dbname']);
    }

    public static function cnn() {
        if (self::$connection === NULL) {
            new self;
        }
        return self::$connection;
    }

    public static function q_array($query) {
        if ($result = self::cnn()->query($query)) {
            $data = [];
            while ($obj = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = $obj;
            }
            return $data;
        } else {
            return [];
        }
    }

    public static function q_array_id($query) {
        if ($result = self::cnn()->query($query)) {
            $data = array();
            while ($obj = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[$obj['id']] = $obj;
            }
            return $data;
        } else {
            return NULL;
        }
    }

    public static function q_array_key($query, $key = NULL) {
        $result = self::cnn()->query($query);
        if ($result && $key != NULL) {
            $data = array();
            while ($obj = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = $obj[$key];
            }
            return $data;
        } else {
            return NULL;
        }
    }

    public static function q_num($query) {
        if ($result = self::cnn()->query($query)) {
            return $result->num_rows;
        } else {
            return NULL;
        }
    }

    public static function q_line($query) {
        //var_dump($query);
        if ($result = self::cnn()->query($query . ' LIMIT 1')) {
            return $result->fetch_array(MYSQLI_ASSOC);
        } else {
            return '';
        }
    }

    public static function q_($query) {
        $error = NULL;
        self::cnn()->query($query) OR $error = self::cnn()->error;
        return $error;
    }

    public static function res($query) {
        return $data = self::cnn()->real_escape_string($query);
    }

}

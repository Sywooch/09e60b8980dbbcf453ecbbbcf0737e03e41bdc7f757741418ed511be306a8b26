<?php

class MCACHE {

  private static $m = null;

  private function __construct() {
    self::$m = new Memcached;
    self::$m->addServer('localhost', 11211);
  }

  public static function obj() {
    if (!self::$m) {
      new self;
    }
    return self::$m;
  }

  public static function get($key) {
    return self::obj()->get($key);
  }

  public static function set($key, $value = null, $expiration = null) { //expiration sec.
    return self::obj()->set($key, $value, $expiration);
  }

}


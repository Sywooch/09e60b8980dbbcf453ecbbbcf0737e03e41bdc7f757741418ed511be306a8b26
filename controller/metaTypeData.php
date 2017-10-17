<?php

class MTD {

  public static function get() {
    $metaTypeData = require(__DIR__ . '/../framework/config/metaTypeData.php');
    return $metaTypeData;
  }

  public static function getName() {
    $data = [];
    $mtd = self::get();
    foreach ($mtd as $key => $vol) {
      $data[$key] = $vol['name'];
    }
    return $data;
  }

//  public static function getModelId($model = null) {
//    $data = [];
//    $mtd = self::get();
//    foreach ($mtd as $key => $vol) {
//      if ($model) {
//        if ($model == $vol['model']) {
//          return $key;
//        } else {
//          $data = null;
//        }
//      } else {
//        $data[$key] = $vol['model'];
//      }
//    }
//    return $data;
//  }

}

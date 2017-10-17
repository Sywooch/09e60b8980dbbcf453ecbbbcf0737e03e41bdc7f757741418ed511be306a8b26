<?php

require(__DIR__ . '/domain.php');
require(__DIR__ . '/firewall.php');
require(__DIR__ . '/metaTypeData.php');

class ROUTING {

  public static function getFirewall() {
    
  }

  public static function getCity() {
    return CONTROLER_DOMAIN::getCity();
  }

  public static function getObj() {
    return CONTROLER_DOMAIN::getObj();
  }

  public static function run() {
//    var_dump(self::getCity(),self::getObj());die;
    if (self::getCity() && self::getObj()) {
      if (self::getObj() == 'api') {
        require(__DIR__ . '/../api/load.php');
        require(__DIR__ . '/../api/modeling.php');
        MODELING::run();
      } elseif (self::getObj() == 'manager') {

        require(__DIR__ . '/../framework/vendor/autoload.php');
        require(__DIR__ . '/../framework/vendor/yiisoft/yii2/Yii.php');
        $config = require(__DIR__ . '/../framework/config/web.php');

        (new yii\web\Application($config))->run();
      }
    }
  }

}

<?php

if (!empty(ROUTING::getCity()['dbname'])) {
  $dbname = ROUTING::getCity()['dbname'];
}
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=' . $dbname, //old db: 'admin_api'
    'username' => 'admin_api',
    'password' => 'uTtMU4cfbm',
    'charset' => 'utf8',
];

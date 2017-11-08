<?php
// require(__DIR__ . '/../features/memcached/memcached.php');
require(__DIR__ . '/../features/db/db.php');
require(__DIR__ . '/mail.php');
require(__DIR__ . '/image.php');
require(__DIR__ . '/comments.php');
require(__DIR__ . '/distance.php');
//var_dump(__DIR__ . '/mail.php');die;

foreach (glob(__DIR__ . "/moduls/*.php") as $filename) {
  include $filename;
}

//var_dump(MCACHE::get('dd'));
//$dd = new DB('user');
//
//var_dump($dd::q_line('SELECT * FROM user'));
//die('dddd');

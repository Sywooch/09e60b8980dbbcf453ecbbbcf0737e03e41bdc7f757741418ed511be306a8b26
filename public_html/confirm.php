<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require(__DIR__ . '/../api/load.php');
if (!empty($_GET['action'])) {
  if ($_GET['action'] == 'mail_confirm') {
    if (!empty($_GET['email']) && !empty($_GET['hash'])) {
      if (filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
        $db = new DB('user');
        $query = "SELECT * FROM `user` WHERE email = '" . DB::res($_GET['email']) . "'";
        $user = $db::q_line($query);
        if ($user) {
          $hash = User::getHash($user);
          if ($hash == $_GET['hash']) {
            if ($user['email_confirm'] == 0) {
              $status = $db::q_("UPDATE `user` SET email_confirm = 1 WHERE id = " . $user['id']);
              if (!$status) {
                echo '<h2>Ваш емайл подтвержден</h2>';
              }
            }
          }
        }
      }
    }
  }
}

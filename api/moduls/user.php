<?php

class User {

  private static $db = null;
  private static $session_user = null;

  public function __construct() {
    self::$db = new DB('user');
  }

  public function reg() {
    $data = null;
    if (!empty($_POST['method'])) {
      switch ($_POST['method']) {
        case 'email':
          $data = self::regEmail();
          break;
        case 1:
          echo "i равно 1";
          break;
        case 2:
          echo "i равно 2";
          break;
      }
    }
    return $data;
  }

  private static function regEmail() {
    $data = null;
    $db = self::$db;
    if (!empty($_POST['name']) && !empty($_POST['f_name']) && !empty($_POST['email']) && !empty($_POST['pass'])) {
      if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        if (strlen($_POST["pass"]) > 6) {
          $query = "INSERT INTO `user` SET name = '" . DB::res($_POST['name']) . "', "
                  . " f_name = '" . DB::res($_POST['f_name']) . "', "
                  . " email = '" . DB::res($_POST['email']) . "', "
                  . " pass = '" . DB::res($_POST['pass']) . "' ";
//          var_dump($query);die;
          $error = $db::q_($query);
          if (!$error) {
            $user = DB::q_line("SELECT * FROM `user` ORDER BY id DESC");
            IMAGE::ProfileImgSave($user);
            if (!MAILER::sendConfirmEmail($user)) {
              $data = 'OK';
            } else {
              $data['error']['code'] = 'ure-5';
              $data['error']['message'] = '';
            }
          } else {
            $data['error']['code'] = 'ure-4';
            $data['error']['message'] = '';
          }
        } else {
          $data['error']['code'] = 'ure-3';
          $data['error']['message'] = '';
        }
      } else {
        $data['error']['code'] = 'ure-2';
        $data['error']['message'] = '';
      }
    } else {
      $data['error']['code'] = 'ure-1';
      $data['error']['message'] = '';
    }
    return $data;
  }

  public function update() {
    $this->accessToken();
    if (self::$session_user) {
      if (!empty($_POST['name']) && !empty($_POST['f_name'])) {
        $db = self::$db;
        $query = "UPDATE `user` SET "
        . " name = '" . DB::res($_POST['name']) . "', "
        . " f_name = '" . DB::res($_POST['f_name'] ). "' "
        . " WHERE id  = " . self::$session_user['id'];
        $error = $db::q_($query);
        if (!$error) {
          self::accessToken();
          $photo = IMAGE::ProfileImgSave(self::$session_user);
          if (!empty($photo) && empty($photo['error'])) {
            $data['name'] = self::$session_user['name'];
            $data['f_name'] = self::$session_user['f_name'];
            $data['photo_250'] = $photo;
          } else {
            $data['name'] = self::$session_user['name'];
            $data['f_name'] = self::$session_user['f_name'];
             $data['photo_250'] = self::$session_user['photo_250'];
          }
        } else {
          $data['error']['code'] = 'uu-2';
          $data['error']['message'] = '';
        }
      }
    } else {
      $data['error']['code'] = 'uu-1';
      $data['error']['message'] = '';
    }
    return $data;
  }

  public function login() {
    $data = null;
    if (!empty($_POST['method'])) {
      switch ($_POST['method']) {
        case 'email':
          $data = self::loginEmail();
          break;
        case 1:
          echo "i равно 1";
          break;
        case 2:
          echo "i равно 2";
          break;
      }
    }
    return $data;
  }

  private static function loginEmail() {
    $data = NULL;
    $db = self::$db;
    if (!empty($_POST['email']) && !empty($_POST['pass'])) {
      if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $query = "SELECT * FROM user where email = '" . DB::res($_POST['email']) . "' "
                . " AND binary pass = '" . DB::res($_POST['pass']) . "' "
                . " AND active = 1 "
                . " AND email_confirm = 1";
        $user = $db::q_line($query);
        if ($user) {
          $data = self::updateToken($user);
          $data['name'] = $user['name'];
          $data['f_name'] = $user['f_name'];
          $data['photo_250'] = $user['photo_250'];
        } else {
          $data['error']['code'] = 'ule-3';
          $data['error']['message'] = 'Неправильный логин или пароль или вы не подтвердили ваш email';
        }
      } else {
        $data['error']['code'] = 'ule-2';
        $data['error']['message'] = '';
      }
    } else {
      $data['error']['code'] = 'ule-1';
      $data['error']['message'] = '';
    }
    return $data;
  }

  private static function updateToken($user) {
    $data = null;
    $query = "UPDATE `user` SET `token` = md5(RAND()+RAND()) , token_update_date = NOW() WHERE id = " . $user['id'];
    $db = self::$db;
    if (!$db::q_($query)) {
      return $db::q_line("SELECT token FROM `user` WHERE id = " . $user['id']);
    }
  }

  public function accessToken() {
    $data = null;
    $db = self::$db;
    $header = getallheaders();
    if (!empty($header['X-Access-Token'])) {
      $query = "SELECT * FROM `user` WHERE token = '" . DB::res($header['X-Access-Token']) . "'";
      $req = $db::q_line($query);
      if ($req) {
        self::$session_user = $req;
        $data = 'OK';
      } else {
        $data['error']['code'] = 'ua-2';
        $data['error']['message'] = 'Ваш сессия не действительно';
      }
    } else {
      $data['error']['code'] = 'ua-1';
      $data['error']['message'] = 'Вы не авторизованы';
    }
//    $data = $header;
    return $data;
  }

  public static function getHash($user) {
    return md5($user['email'] . $user['token']);
  }

}

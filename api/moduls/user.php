<?php

class User {
######################  DADA BASE #########################

    private static $connection = null;
    protected $session_user = null;

    public function __construct() {
        if (!self::$connection) {
            self::$connection = new mysqli('localhost', 'db_users', 'db_users', 'db_users');
        }
    }

    public static function cnn() {
        if (self::$connection === NULL) {
            new self;
        }
        return self::$connection;
    }

    public static function q_array($query) {
        if ($result = self::cnn()->query($query)) {
            $data = array();
            while ($obj = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = $obj;
            }
            return $data;
        } else {
            return NULL;
        }
    }

    public static function q_line($query) {
        if ($result = self::cnn()->query($query . ' LIMIT 1')) {
            return $result->fetch_array(MYSQLI_ASSOC);
        } else {
            return NULL;
        }
    }

    public static function q_($query) {
        $error = NULL;
        self::cnn()->query($query) OR $error = self::cnn()->error;
        return $error;
    }

    public static function res($query) {
        return self::cnn()->real_escape_string($query);
    }

    ##################  MHETOD ########################

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
        if (!empty($_POST['name']) && !empty($_POST['f_name']) && !empty($_POST['email']) && !empty($_POST['pass'])) {
            $email = trim($_POST['email']);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (strlen($_POST["pass"]) > 6) {
                    $query = "INSERT INTO `user` SET name = '" . DB::res($_POST['name']) . "', "
                            . " f_name = '" . DB::res($_POST['f_name']) . "', "
                            . " email = '" . DB::res($_POST['email']) . "', "
                            . " pass = '" . DB::res($_POST['pass']) . "' ";
//          var_dump($query);die;
                    $error = self::q_($query);
                    if (!$error) {
                        $user = self::q_line("SELECT * FROM `user` ORDER BY id DESC");
                        IMAGE::ProfileImgSave($user);
                        if (!MAILER::sendConfirmEmail($user)) {
                            $data = 'OK';
                        } else {
                            $data['error']['code'] = 'ure-5';
                            $data['error']['message'] = 'Возникло проблемо с оправки емайла';
                        }
                    } else {
                        $data['error']['code'] = 'ure-4';
                        $data['error']['message'] = 'Данный Email адрес уже используется';
                    }
                } else {
                    $data['error']['code'] = 'ure-3';
                    $data['error']['message'] = 'Пароли должны содержать не менее 7-ми символов';
                }
            } else {
                $data['error']['code'] = 'ure-2';
                $data['error']['message'] = 'Неправильный формат Е-майл адреса';
            }
        } else {
            $data['error']['code'] = 'ure-1';
            $data['error']['message'] = 'Не все поля заполнены';
        }
        return $data;
    }

    public function update() {
        $this->accessToken();
        if ($this->session_user) {
            if (!empty($_POST['name']) && !empty($_POST['f_name'])) {
                $query = "UPDATE `user` SET "
                        . " name = '" . DB::res($_POST['name']) . "', "
                        . " f_name = '" . DB::res($_POST['f_name']) . "' "
                        . " WHERE id  = " . $this->session_user['id'];
                $error = self::q_($query);
                if (!$error) {
                    $this->accessToken();
                    $photo = IMAGE::ProfileImgSave($this->session_user);
//                    var_dump($photo);die;
                    if (!empty($photo) && empty($photo['error'])) {
                        $data['name'] = $this->session_user['name'];
                        $data['f_name'] = $this->session_user['f_name'];
                        $data['photo_250'] = $photo;
                    } else {
                        $data['name'] = $this->session_user['name'];
                        $data['f_name'] = $this->session_user['f_name'];
                        $data['photo_250'] = $this->session_user['photo_250'];
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
        if (!empty($_POST['email']) && !empty($_POST['pass'])) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $query = "SELECT * FROM user where email = '" . DB::res($_POST['email']) . "' "
                        . " AND binary pass = '" . DB::res($_POST['pass']) . "' "
                        . " AND active = 1 "
                        . " AND email_confirm = 1";
                $user = self::q_line($query);
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
                $data['error']['message'] = 'Неправильный формат Е-майл адреса';
            }
        } else {
            $data['error']['code'] = 'ule-1';
            $data['error']['message'] = 'Не все поля заполнены';
        }
        return $data;
    }

    private static function updateToken($user) {
        $query = "UPDATE `user` SET `token` = md5(RAND()+RAND()) , token_update_date = NOW() WHERE id = " . $user['id'];
        if (!self::q_($query)) {
            return self::q_line("SELECT token FROM `user` WHERE id = " . $user['id']);
        }
    }

    public function accessToken() {
        $data = null;
        $header = getallheaders();
        if (!empty($header['X-Access-Token'])) {
            $query = "SELECT * FROM `user` WHERE token = '" . DB::res($header['X-Access-Token']) . "'";
            $req = self::q_line($query);
            if ($req) {
                $this->session_user = $req;
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

    public static function get() {
        $user = new self;

        $re = $user->accessToken();
        $data = $user->session_user;
        if ($data) {
            unset($data['token'], $data['pass'], $data['hash'], $data['token_update_date'], $data['active'], $data['email_confirm_hash']);
        }
        return $data;
    }

    public static function getUsers($users_id = []) {
        $data = [];
        if (!empty($users_id) && is_array($users_id)) {
            $in_id = implode(',', $users_id);
            $query = "SELECT id , name , f_name , photo_250 FROM `user` WHERE id IN ( $in_id )";
            $data = self::q_array($query);
        }
        return $data;
    }

    public function resetPassword() {
        $data = '';
        if (!empty($_POST['email'])) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $query = "SELECT * FROM user where email = '" . self::res($_POST['email']) . "' "
//                        . " AND binary pass = '" . DB::res($_POST['pass']) . "' "
                        . " AND active = 1 ";
//                        . " AND email_confirm = 1";
                $user = self::q_line($query);
                if ($user) {
//                    $UT = self::updateToken($user);
                    if (!MAILER::sendResetEmail($user)) {
                        $data = 'OK';
                    } else {
                        $data['error']['code'] = 'ure-5';
                        $data['error']['message'] = 'Возникло проблемо с оправки емайла';
                    }
                } else {
                    $data['error']['code'] = 'ule-3';
                    $data['error']['message'] = 'Неправильный email';
                }
            } else {
                $data['error']['code'] = 'ule-2';
                $data['error']['message'] = 'Неправильный формат Е-майл адреса';
            }
        }
        return $data;
    }

}

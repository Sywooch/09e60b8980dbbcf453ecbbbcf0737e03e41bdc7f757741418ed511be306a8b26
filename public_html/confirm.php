<?php
//
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require(__DIR__ . '/../api/load.php');
if (!empty($_GET['action'])) {
//    var_dump($_GET['action']);
    if (!empty($_GET['email']) && !empty($_GET['hash'])) {

        if (filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
            $db = new User();
            $query = "SELECT * FROM `user` WHERE email = '" . $db::res($_GET['email']) . "'";
            $user = $db::q_line($query);
//                var_dump($user, $query);
            if ($user) {
                $hash = User::getHash($user);
//                var_dump($hash);
                if ($hash == $_GET['hash']) {
                    echo 'проверка успешно<br>';
                    if ($_GET['action'] == 'mail_confirm') {
                        if ($user['email_confirm'] == 0) {
                            $status = $db::q_("UPDATE `user` SET email_confirm = 1 WHERE id = " . $user['id']);
                            if (!$status) {
                                echo '<h2>Ваш емайл подтвержден</h2><p>наш труд, любовь и вдохновение!</p>';
                            } else {
                                echo '<h2>Внутренняя ошибка, возникло непредвиденное исключение Code:3</h2>';
                            }
                        } else {
                            echo '<h2>Ваш емайл подтвержден!!!</h2>';
                        }
                    } elseif ($_GET['action'] == 'reset') {
                        if (@strlen($_POST['pass']) > 6) {
                            $status = $db::q_("UPDATE `user` SET email_confirm = 1 , pass = " . $db::res($_POST['pass']) . " WHERE id = " . $user['id']);
                            if (!$status) {
                                echo '<h2>"Поздравляем" :) Пароль изменен</h2>';
                            } else {
                                echo '<h2>Внутренняя ошибка, возникло непредвиденное исключение Code:10</h2>';
                            }
                            die;
                        }
                        if (isset($_POST['pass'])) {
                            echo '<h2 style="color:red">Ошибка, Пароли должны содержать не менее 7-ми символов</h2>';
                        }
                        ?>
                        <form action="" method="post">
                            Новый пароль:<br>
                            <input type="text" name="pass">
                            <br>
                            <br>
                            <input type="submit" value="Отправить">
                        </form> 

                        <p>Пароли должны содержать не менее 7-ми символов</p>
                        <?
                    }
                } else {
                    echo '___ooo___<br>';
                }
            }
        }
    }
}
?>
✮❀ヅ❤♫ oooGoroda.mobi
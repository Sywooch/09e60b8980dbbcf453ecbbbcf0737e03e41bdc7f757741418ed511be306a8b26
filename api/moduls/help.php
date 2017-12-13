<?php

class Help {

    public function get() {
        $mail = self::sendMail();
        if (!$mail) {
            return DB::q_line("SELECT * FROM help");
        } else {
            return $mail;
        }
    }

    private static function sendMail() {
        if (!empty($_POST['name']) && !empty($_POST['tel']) && !empty($_POST['email']) && !empty($_POST['text'])) {
            $content = self::mailContent();
            $to = DB::q_line("SELECT * FROM settings")['value'];
            $error = MAILER::send('vsemdostavka@list.ru', $content, 'Помощь');
            $error = MAILER::send($to, $content, 'Помощь');
            if ($error) {
                return ['error' => ['code' => 1, 'message' => 'error']];
            } else {
                return 'OK';
            }
        }
    }

    private static function mailContent() {
        return '<h2>Помощь</h2>'
                . '<ul>'
                . '<li>'
                . 'Имя: ' . $_POST['name']
                . '</li>'
                . '<li>'
                . 'Tel:' . $_POST['tel']
                . '</li>'
                . '<li>'
                . 'Email:' . $_POST['email']
                . '</li>'
                . '<li>'
                . 'text:' . $_POST['text']
                . '</li>'
                . '</ul>';
    }

}

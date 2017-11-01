<?php

class Advertising {

    public function get() {
        $mail = self::sendMail();
        if (!$mail) {
            return DB::q_line("SELECT * FROM advertising");
        } else {
            return $mail;
        }
    }

    private static function sendMail() {
        if (!empty($_POST['name']) && !empty($_POST['tel']) && !empty($_POST['email'])) {
            $content = self::mailContent();
            $to = DB::q_line("SELECT * FROM settings")['email'];
            $error = MAILER::send('vsemdostavka@list.ru', $content, 'Насчет рекламы');
            $error = MAILER::send($to, $content, 'Насчет рекламы');
            if ($error) {
                return ['error' => ['code' => 1, 'message' => 'error']];
            } else {
                return 'OK';
            }
        }
    }

    private static function mailContent() {
        return '<h2>Запрос на рекламу</h2>'
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
                . '</ul>'
                . '';
    }

}

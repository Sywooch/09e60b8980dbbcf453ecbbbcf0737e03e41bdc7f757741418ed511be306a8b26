<?php

class MAILER {

  public static function send($to, $content, $subject = NULL, $from = 'no-replay@ooogoroda.mobi') {
    $body = self::body($content);
    $error = self::sender($to, $subject, $from, $body);
    return $error;
  }

  private static function body($content) {
    ob_start();
    ?>
    <table style="table-layout: fixed; width: 100%">
        <tr>
            <td style="background-color: #333;"><? include(__DIR__ . "/../features/mailer/view/top.php"); ?></td>
        </tr>
        <tr>
            <td ><? print_r($content); ?></td>
        </tr>
        <tr>
            <td  style="background-color: #333;height: 20px;"><? include(__DIR__ . "/../features/mailer/view/bottom.php"); ?></td>
        </tr>
    </table>
    <?php
    $body = ob_get_contents();
    ob_end_clean();
    return $body;
  }

  private static function sender($to, $subject, $from, $body) {
    $error = NULL;
    require_once (__DIR__ . '/../features/mailer/PHPMailerAutoload.php');

    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->IsMail();
    $mail->From = $from;
    $mail->FromName = "Города";
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $mail->XMailer = 'ooogoroda.mobi';
    if (!$mail->send()) {
      $error = $mail->ErrorInfo;
    }
    return $error;
  }

  public static function sendConfirmEmail($user) {
    $hash = User::getHash($user);
    $content = self::getConfirmContent($user['email'], $hash);
    return self::send($user['email'], $content, 'Активация аккаунта');
  }

  private static function getConfirmContent($email, $hash) {
    ob_start();
    ?>
    <h2>Подтверждение регистрации</h2>
    <p>Перейдите пожалуйста по этой ссылке для подтверждения 
        <a href="http://<?= MAIN_DOMAIN ?>/confirm.php?action=mail_confirm&email=<?= $email ?>&hash=<?= $hash ?>">
            http://<?= MAIN_DOMAIN ?>/confirm.php?email=<?= $email ?>&hash=<?= $hash ?>
        </a>
    </p>
    <?
    $Content = ob_get_contents();
    ob_end_clean();
    return $Content;
  }

}

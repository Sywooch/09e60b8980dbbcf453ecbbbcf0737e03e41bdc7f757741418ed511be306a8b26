<?php

/* @var $this yii\web\View */
/* @var $client app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/reset-password', 'token' => $client->password_reset_token]);
?>
Здравствуйте <?= $client->first_name ?>,

Перейдите по приведенной ниже ссылке, чтобы сбросить пароль:

<?= $resetLink ?>

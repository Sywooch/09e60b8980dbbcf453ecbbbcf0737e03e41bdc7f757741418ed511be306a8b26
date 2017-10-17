<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $client app\models\Clients */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/reset_password', 'token' => $client->password_reset_token]);
?>
<div class="password-reset">
    <p>Здравствуйте <?= Html::encode($client->first_name) ?>,</p>

    <p>Перейдите по приведенной ниже ссылке, чтобы сбросить пароль:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>

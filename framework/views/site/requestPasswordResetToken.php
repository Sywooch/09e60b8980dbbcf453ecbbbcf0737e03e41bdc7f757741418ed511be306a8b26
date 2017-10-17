<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\PasswordResetRequestForm */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="well no-padding" id="login">
			<? $form = yii\widgets\ActiveForm::begin([
				'id'=>'login-form',
				'fieldConfig' => ['options' => ['tag'=>'section'],'labelOptions' => ['class' => 'label']],
				'method'=>'post',
				'enableClientValidation'=>true,
				'options'=>[
					'class'=>'smart-form client-form',
					'validateOnSubmit'=>true,
					'afterValidate' => "js: function(form, data, hasError){Admin.AjaxFormSend(form, data, hasError)}",
					'afterValidateAttribute' => "js:function(form, attribute, data, hasError){Admin.AjaxFormValidate(form, attribute, data, hasError)}"
				]
			])?>
            <header> <?= Html::encode($this->title) ?> </header>
            <fieldset>
	            <?= $form->field($model, 'account_email', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-envelope"></i>{input}{error}{hint}</label>'])->textInput(['autofocus' => true]) ?>
	            <?= $form->field($model, 'captcha', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->widget(Captcha::className()) ?>
            </fieldset>
            <footer>

                <div class="pull-left"> <?= Html::a('Авторизация','login', ['class' => 'btn btn-default']) ?></div>
                <div class="pull-right"> <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?></div>
            </footer>
			<?yii\widgets\ActiveForm::end()?>
        </div>
    </div>
</div>
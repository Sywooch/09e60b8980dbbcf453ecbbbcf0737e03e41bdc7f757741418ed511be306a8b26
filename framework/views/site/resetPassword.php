<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('cabinet', 'Сброс пароля');
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
				<?= $form->field($model, 'password', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->passwordInput(['autofocus' => true]) ?>
				<?= $form->field($model, 'repassword', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->passwordInput(['autofocus' => true]) ?>

            </fieldset>
            <footer>
	            <?= Html::submitButton(Yii::t('cabinet', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
            </footer>
			<?yii\widgets\ActiveForm::end()?>
        </div>
    </div>
</div>
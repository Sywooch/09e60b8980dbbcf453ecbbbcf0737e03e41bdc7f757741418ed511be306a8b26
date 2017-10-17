<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Авторизация';
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
            <header> Авторизация </header>
            <fieldset>
				<?=$form->field($model,'account_name', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-user"></i>{input}{error}{hint}</label>'])?>
				<?=$form->field($model,'account_password', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-lock"></i>{input}{error}<a href="/restore">{hint}</a></label>'])->passwordInput()
					->hint('Забыли пароль?')?>
				<?=$form->field($model,'rememberMe', ['template' => "<label class='checkbox'> {input}<i></i>{error}{hint}{$model->getAttributeLabel('rememberMe')}</label>",
					'options' => ['id' => 'loginform-rememberme'],'labelOptions' => ['class' => 'label'],'hintOptions' => ['class' => 'note']])->checkbox([], false)
				?>
            </fieldset>
            <footer>
                <button type="submit" class="btn btn-primary">Войти</button>
            </footer>
			<?yii\widgets\ActiveForm::end()?>
        </div>
    </div>
</div>

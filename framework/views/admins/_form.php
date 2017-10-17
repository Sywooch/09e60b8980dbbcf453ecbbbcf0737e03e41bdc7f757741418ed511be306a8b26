<?php
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
	<?php $form = ActiveForm::begin(['id' => 'wizard-1', 'enableClientValidation' => true, 'options' => ['class' => 'smart-form', 'novalidate' => 'novalidate']]); ?>
    <fieldset>
		<? if ($model->isNewRecord): ?>
            <section><?= $form->field($model, 'account_name', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->textInput() ?></section>
            <section><?= $form->field($model, 'account_email',['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->textInput() ?></section>
            <section><?= $form->field($model, 'password', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->passwordInput() ?></section>
		<? endif; ?>
        <section><?= $form->field($model, 'first_name', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->textInput() ?></section>
        <section><?= $form->field($model, 'last_name', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->textInput() ?></section>
    	<? if (!$model->isNewRecord): ?>
            <section><?= $form->field($model, 'new_password', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->passwordInput() ?></section>
		<? endif; ?>
        <section><?= $form->field($model, 'profile')->dropDownList(User::profilesList()) ?></section>
    </fieldset>
    <fieldset>
        <section>
            <label class="label">Права доступа</label>
            <div class="row">
                <div class="col col-4">
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[admins]', isset($model->access['admins'])?:false,  [ 'checked' => isset($model->access['admins'])?:false])?>
                        <i></i>Администраторы
                    </label>
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[news]', isset($model->access['news'])?:false,  [ 'checked' => isset($model->access['news'])?:false])?>
                        <i></i>Новости
                    </label>
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[clients]', isset($model->access['clients'])?:false,  [ 'checked' => isset($model->access['clients'])?:false])?>
                        <i></i>Пользователи
                    </label>
                </div>
                <div class="col col-4">

                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[organizations]', isset($model->access['organizations'])?:false,  [ 'checked' => isset($model->access['organizations'])?:false])?>
                        <i></i>Организации
                    </label>

                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[shares]', isset($model->access['shares'])?:false,  [ 'checked' => isset($model->access['shares'])?:false])?>
                        <i></i>Акции
                    </label>

                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[poster]', isset($model->access['poster'])?:false,  [ 'checked' => isset($model->access['poster'])?:false])?>
                        <i></i>Афиши
                    </label>
                </div>
                <div class="col col-4">
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[filters]', isset($model->access['filters'])?:false,  [ 'checked' => isset($model->access['filters'])?:false])?>
                        <i></i>Фильтры
                    </label>
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[communication]', isset($model->access['communication'])?:false,  [ 'checked' => isset($model->access['communication'])?:false])?>
                        <i></i>Общение
                    </label>
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[buttons]', isset($model->access['buttons'])?:false,  [ 'checked' => isset($model->access['buttons'])?:false])?>
                        <i></i>Кнопки
                    </label>
                </div>
                <div class="col col-4">
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[ads]', isset($model->access['ads'])?:false,  [ 'checked' => isset($model->access['ads'])?:false])?>
                        <i></i>Объявления
                    </label>
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[advertising]', isset($model->access['advertising'])?:false,  [ 'checked' => isset($model->access['advertising'])?:false])?>
                        <i></i>Реклама
                    </label>
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[advertising_banner]', isset($model->access['advertising_banner'])?:false,  [ 'checked' => isset($model->access['advertising_banner'])?:false])?>
                        <i></i>Баннерная реклама
                    </label>
                </div>

                <div class="col col-4">
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[notice]', isset($model->access['notice'])?:false,  [ 'checked' => isset($model->access['notice'])?:false])?>
                        <i></i>Пуш-уведомления
                    </label>
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[settings]', isset($model->access['settings'])?:false,  [ 'checked' => isset($model->access['settings'])?:false])?>
                        <i></i>Настройки
                    </label>
                    <label class="checkbox">
		                <?= Html::Checkbox('AdminsAccess[help]', isset($model->access['help'])?:false,  [ 'checked' => isset($model->access['help'])?:false])?>
                        <i></i>Помощь
                    </label>
                </div>
            </div>
        </section>
    </fieldset>
    <div class="form-group"></div>
    <footer>
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Создать') : Yii::t('app', 'Сохранить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button type="button" class="btn btn-default" onclick="window.history.back();">
            Назад
        </button>
    </footer>
	<?php ActiveForm::end(); ?>
</div>

<?php
use app\models\Clients;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
	<?php $form = ActiveForm::begin(['id' => 'wizard-1', 'enableClientValidation' => true, 'options' => ['class' => 'smart-form', 'novalidate' => 'novalidate']]); ?>
    <fieldset>
		<? if ($model->isNewRecord): ?>
            <section><?= $form->field($model, 'account_name', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->textInput() ?></section>
            <section><?= $form->field($model, 'password', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->passwordInput() ?></section>
		<? endif; ?>
        <section><?= $form->field($model, 'phone', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->textInput() ?></section>
        <section><?= $form->field($model, 'email', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->textInput() ?></section>
        <section>
            <?= $form->field($model, 'block_publication', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->dropDownList(['Нет', 'Да']) ?>
        </section>
    	<? if (!$model->isNewRecord): ?>
            <section><?= $form->field($model, 'new_password', ['template' => '<label class="label">{label}</label><label class="input">{input} <div class="note">Оставить пустым если не нужно менять</div>{error}</label>'])->passwordInput() ?></section>
		<? endif; ?>
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

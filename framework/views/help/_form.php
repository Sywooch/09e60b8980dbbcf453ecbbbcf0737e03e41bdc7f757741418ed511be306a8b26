<?php
use app\models\Clients;
use yii\helpers\Html;
	use yii\web\View;
	use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */
/* @var $form yii\widgets\ActiveForm */
	$this->registerJsFile($this->theme->getUrl('js/plugin/ckeditor4/ckeditor.js'), ['position' => \yii\web\View::POS_END, 'depends' => 'yii\web\YiiAsset']);
	$js = <<<JS
		pageSetUp();
		var pagefunction = function () {
            CKEDITOR.replace('text',{ enterMode: CKEDITOR.ENTER_BR, shiftEnterMode: CKEDITOR.ENTER_BR, extraAllowedContent: 'script;span;ul;li;i;table;td;style;*[id];*(*);*{*}' });
		};
		pagefunction();
JS;
	$this->registerJs($js, View::POS_END);
?>

<div class="user-form">
	<?php $form = ActiveForm::begin(['id' => 'wizard-1','enableClientValidation'=>false, 'options' => ['class' => 'smart-form']]); ?>
    <fieldset>
        <section><?= $form->field($model, 'name', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->textInput() ?></section>
        <section><?= $form->field($model, 'text', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->textarea(
		        ['class' => 'CKEDITOR', 'rows' => 6, 'id'=> 'text']
            ) ?></section>
        <section><?= $form->field($model, 'link', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])->textInput() ?></section>
    </fieldset>
    <div class="form-group"></div>
    <footer>
		<?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' =>'btn btn-success']) ?>
    </footer>
	<?php ActiveForm::end(); ?>
</div>

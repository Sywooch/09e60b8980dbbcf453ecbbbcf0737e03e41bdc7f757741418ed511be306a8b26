<?php
	/********************************
	 * Created by GoldenEye.
	 * ICQ 285652 / email : slims.alex@gmail.com
	 * WEB: http://scriptsweb.ru
	 * copyright 2010 - 2016
	 ********************************/
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\modules\news\models\NewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-search">



	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

	<?= $form->field($model, 'id') ?>

	<?//= $form->field($model, 'country_name') ?>

	<div class="form-group">
		<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
		<?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>

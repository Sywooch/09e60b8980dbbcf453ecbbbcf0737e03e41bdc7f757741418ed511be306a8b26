<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\communication\models\communication;

/* @var $this yii\web\View */
/* @var $model app\modules\communication\models\communication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="communication-form">

    <?php $form = ActiveForm::begin(); 
 var_dump($form);die;
    ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'pin_main')->textInput() ?>

    <?= $form->field($model, 'pin_filter')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

<?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>

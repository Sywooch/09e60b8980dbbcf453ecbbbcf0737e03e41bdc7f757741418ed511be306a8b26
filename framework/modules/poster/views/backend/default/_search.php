<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\poster\models\PosterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="poster-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'telephone') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'url_video') ?>

    <?php // echo $form->field($model, 'url_descrition') ?>

    <?php // echo $form->field($model, 'pin_main') ?>

    <?php // echo $form->field($model, 'pin_poster') ?>

    <?php // echo $form->field($model, 'pin_filter') ?>

    <?php // echo $form->field($model, 'end_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('poster', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('poster', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

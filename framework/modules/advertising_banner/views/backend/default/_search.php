<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\advertising_banner\models\AdvertisingBannerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertising-banner-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'telephone') ?>

    <?= $form->field($model, 'organization_id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

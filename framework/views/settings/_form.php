<?php

use app\models\Clients;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $setting app\models\Settings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(['id' => 'wizard-1', 'enableClientValidation' => false, 'options' => ['class' => 'smart-form']]); ?>
    <fieldset>
        <?php
//            var_dump($model);die;
        foreach ($model as $index => $setting):
            ?>
            <section><?=
                        $form->field($setting, 'name', ['template' => '<label class="label">{label}</label><label class="input">{input}{error}</label>'])
                        ->label(Yii::t('settings', $setting->desc), ['class' => 'input'])
                        ->textInput(['name' => $setting->name, 'value' => $setting->value]);
                ?></section>
<? endforeach; ?>
    </fieldset>
    <div class="form-group"></div>
    <footer>
    <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </footer>
<?php ActiveForm::end(); ?>
</div>

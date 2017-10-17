<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\modules\ads\models\AdsSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="ads-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'id' => 'smart_form',
        'method' => 'get',
    ]); ?>
    Показать закрепленные
    <span class="onoffswitch">
       <?=Html::checkbox('AdsSearch[is_pin]', $model->is_pin, ['class' => 'onoffswitch-checkbox', 'id' => 'status_' . $model->id, 'onclick' => 'document.getElementById(\'smart_form\').submit()'])?>
        <label class="onoffswitch-label" for="status_<?=$model->id?>">
            <span class="onoffswitch-inner" data-swchon-text="Да" data-swchoff-text="Нет"></span>
            <span class="onoffswitch-switch"></span>
        </label>
    </span>
    <?php ActiveForm::end(); ?>
</div>

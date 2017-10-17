<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\advertising_banner\models\AdvertisingBanner */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Advertising Banner',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertising Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="advertising-banner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

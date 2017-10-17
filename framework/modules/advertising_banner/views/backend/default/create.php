<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\advertising_banner\models\AdvertisingBanner */

$this->title = Yii::t('app', 'Create Advertising Banner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertising Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-banner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

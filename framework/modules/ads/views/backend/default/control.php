<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\ads\models\Ads */
//
$this->title = 'SS Ads';
$this->params['breadcrumbs'][] = ['label' => 'Ads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_list_control', [
        'model' => $model,
    ]) ?>

</div>

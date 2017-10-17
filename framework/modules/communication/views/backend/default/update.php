<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\communication\models\communication */

$this->title = 'Update communication: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'communication', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="communication-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

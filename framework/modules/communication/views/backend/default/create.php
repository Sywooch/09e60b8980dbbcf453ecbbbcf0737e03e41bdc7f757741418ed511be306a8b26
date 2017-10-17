<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\communication\models\communication */

$this->title = 'Create communication';
$this->params['breadcrumbs'][] = ['label' => 'communication', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="communication-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

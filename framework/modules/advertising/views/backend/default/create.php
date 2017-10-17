<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\advertising\models\Advertising */

$this->title = Yii::t('app', 'Create Advertising');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertisings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

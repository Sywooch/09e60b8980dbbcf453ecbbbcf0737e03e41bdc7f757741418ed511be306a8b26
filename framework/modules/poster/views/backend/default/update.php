<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\poster\models\poster */

$this->title = Yii::t('poster', 'Редактирование афиши: {modelClass}: ', [
    'modelClass' => 'poster',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('poster', 'Афиши'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('poster', 'Редактирование афиши'), 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="poster-update">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-television"></i> Афиши <span>&gt; Редактирование афиши</span></h1>
        </div>
    </div>
    <section id="widget-grid">
        <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pencil-square-o"></i> </span>
                        <h2>Редактор</h2>
                    </header>
                    <div>
                        <div class="jarviswidget-editbox"></div>
                        <div class="widget-body no-padding">
    <?= $this->render('_form', [
        'model' => $model,
	    'placeholder' => $placeholder,
    ]) ?>
                        </div>
                    </div>
            </article>
        </div>
    </section>
</div>

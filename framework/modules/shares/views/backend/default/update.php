<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\shares\models\Shares */

$this->title = Yii::t('poster', 'Редактирование акции: {modelClass}: ', [
    'modelClass' => 'Shares',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('poster', 'Акции'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('poster', 'Редактирование акции'), 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $model->name;

?>
<div class="shares-update">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-percent"></i> Акции <span>&gt; Редактирование акции</span></h1>
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

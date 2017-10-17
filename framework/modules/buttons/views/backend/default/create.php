<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\buttons\models\Buttons */

$this->title = 'Добавить кнопку';
$this->params['breadcrumbs'][] = ['label' => 'Кнопки приложения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buttons-create">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-check-circle"></i> Кнопки <span>&gt; <?= Html::encode($this->title) ?></span></h1>
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

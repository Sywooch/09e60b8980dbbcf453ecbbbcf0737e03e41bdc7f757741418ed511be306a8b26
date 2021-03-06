<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\modules\filters\models\Filters */
/* @var string $placeholder */
$this->title = 'Добавить фильтр';
$this->params['breadcrumbs'][] = ['label' => 'Фильтры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-dedent"></i> Фильтры <span>&gt; <?= Html::encode($this->title) ?></span></h1>
        </div>
    </div>
    <div class="jarviswidget">
        <div>
            <div class="widget-body no-padding">
				<?=
					$this->render('_form', [
						'model' => $model,
						'placeholder' => $placeholder
					]) ?>
            </div>
        </div>
    </div>
</div>

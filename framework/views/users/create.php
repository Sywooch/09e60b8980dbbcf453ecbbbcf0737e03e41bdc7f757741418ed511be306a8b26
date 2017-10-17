<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Clients */

$this->title = $model->isNewRecord ? Yii::t('users', 'users.add') : Yii::t('users', 'users.edit', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('users', 'users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa fa-user"></i>
			<?= Html::encode(Yii::t('users', 'users')) ?>
            <span>&gt; <?=Html::encode($this->title)?></span>
		</h1>
	</div>
</div>
<div class="row">
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
			<header>
				<span class="widget-icon"> <i class="fa fa-table"></i> </span>
				<h2><?=$this->title?></h2>
			</header>
			<div class="jarviswidget-editbox"></div>
			<div class="widget-body no-padding no-margin">
				<?= $this->render('_form', [
					'model' => $model,
				]) ?>
			</div>
		</div>
	</article>
</div>


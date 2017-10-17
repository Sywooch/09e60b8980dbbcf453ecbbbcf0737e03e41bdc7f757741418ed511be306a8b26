<?php
/********************************
 * Created by GoldenEye.
 * email : golden@outsourcing.team
 * WEB: http://outsourcing.team
 * copyright 2016 - 2016
 ********************************/
/* @var $this \yii\web\View */
/* @var $model app\models\Clients */
use app\models\Clients;
use app\models\User;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
	use yii\widgets\DetailView;

	$this->title = $model->account_name;
	$this->params['breadcrumbs'][] = ['label' => Yii::t('users', 'users'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-lg fa-fw fa-users"></i>
			<?= Html::encode(Yii::t('users', 'users')) ?>
			<span>> <?= Html::encode($model->account_name) ?></span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-6">
        <div id="sparks">
			<?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
			<?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
				'class' => 'btn btn-danger',
				'data' => [
					'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
					'method' => 'post',
				],
			]) ?>
        </div>
    </div>
</div>


<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                <h2><?= Html::encode($this->title) ?></h2>
            </header>
            <div class="jarviswidget-editbox"></div>
            <div class="widget-body no-padding no-margin">
                <div class="table-responsive">
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							'account_name',
							'email:email',
							'phone',
							//'account_email:email',
						],
					]) ?>
                </div>
            </div>
        </div>
    </article>
</div>

<?php
	/********************************
	 * Created by GoldenEye.
	 * email : golden@outsourcing.team
	 * WEB: http://outsourcing.team
	 * copyright 2016 - 2016
	 ********************************/
	use app\models\Clients;
	use yii\grid\GridView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\View;

	$this->title = Yii::t('users', 'users');
	$this->params['breadcrumbs'][] = $this->title;

	/* @var $this \yii\web\View */
	$this->registerJs('pageSetUp();', View::POS_END)
?>

<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-lg fa-fw fa-users"></i>
			<?= Html::encode($this->title) ?>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
        <div id="sparks">
			<?= Html::a('<i class="fa-fw fa fa-plus-circle"></i>' . Yii::t('app', 'Добавить'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                <h2>Список клиентов</h2>
            </header>
            <div class="jarviswidget-editbox"></div>
            <div class="widget-body no-padding no-margin">
				<?= GridView::widget([
					'dataProvider' => $dataProvider,
					//'filterModel' => $searchModel,
					'layout' => "{items}\n<div class='widget-footer text-center'>{pager}</div>",
					'columns' => [
						[
							'attribute' => 'id',
							'filter' => Html::a('Сбосить', Url::toRoute('index'), ['class' => 'btn btn-default']),
							'value' => 'id',
						],
						[
							'attribute' => 'account_name',
						],

						'phone',
						'email',
						[
							'attribute' => 'status',
							'filter' => Html::activeDropDownList($searchModel, 'status', [Clients::STATUS_ACTIVE => 'Активный', Clients::STATUS_DELETED => 'Удалён', Clients::STATUS_BLOCK => 'Заблокирован'], ['class' => 'form-control', 'prompt' => 'Все']),
							'value' => function (Clients $model) {
								if ($model::STATUS_ACTIVE)
									return 'Активный';
								if ($model::STATUS_DELETED)
									return 'Удалён';
								if ($model::STATUS_BLOCK)
									return 'Заблокирован';
								return '';
							}

						],
						'created_at',
						[
							'class' => 'yii\grid\ActionColumn',
							'header' => 'Действия',
							'headerOptions' => ['width' => '145px'],
							'template' => '{view} {update} {delete}',
							'buttons' => array(
								'view' => function ($url, $model, $key) {
									return Html::a('<i class="fa fa-eye"></i>', Url::toRoute(['view','id' => $model->id]),['class' => 'btn btn-success','title' => 'Просмотр','aria-label' => 'Просмотр','data-pjax' => 0,]);
								},
								'update' => function ($url, $model, $key) {
									return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['update','id' => $model->id]),['class' => 'btn btn-warning','title' => 'Редактировать','aria-label' => 'Редактировать','data-pjax' => 0,]);
								},
								'delete' => function ($url, $model, $key) {
									return Html::a('<i class="fa fa-trash"></i>', Url::toRoute(['delete','id' => $model->id]),
										['class' => 'btn btn-danger','title' => 'Удалить','aria-label' => 'Удалить','data-confirm' => 'Вы уверены, что хотите удалить этот элемент?','data-method' => 'post','data-pjax' => 0]);
								}
							)
						],
					],
					'tableOptions' => ['class' => 'table table-bordered vcenter'],
					'options' => ['class' => 'table-responsive']
				]) ?>
            </div>
        </div>
    </article>
</div>


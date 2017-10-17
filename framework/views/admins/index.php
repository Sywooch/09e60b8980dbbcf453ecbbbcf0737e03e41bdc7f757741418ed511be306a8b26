<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admins', 'admins');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-user-secret"></i>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
        <div id="sparks">
            <?= Html::a( '<i class="fa-fw fa fa-plus-circle"></i>'.Yii::t('app', 'Добавить'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>


<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                <h2>Список администраторов</h2>
            </header>
            <div class="jarviswidget-editbox"></div>
            <div class="widget-body no-padding no-margin">
                <div class="table-responsive">
                    <?php //Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'layout' => "{items}\n{pager}",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'account_name',
                            'first_name',
                            'last_name',
                            [
								'attribute'=>'profile',
								'filter' => Html::activeDropDownList($searchModel, 'profile', User::profilesList(),['class'=>'form-control', 'prompt' => '']),
								'value'=> function($model){
									return User::profilesList($model->profile);
								},
							],
                            [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Действия',
                            'headerOptions' => ['width' => '145px'],
                            'template' => '{view} {update} {delete}',
                            'buttons' => array(
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-eye"></i>', Url::toRoute(['/admins/view','id' => $model->id]),['class' => 'btn btn-success','title' => 'Просмотр','aria-label' => 'Просмотр','data-pjax' => 0,]);
                                },
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['/admins/update','id' => $model->id]),['class' => 'btn btn-warning','title' => 'Редактировать','aria-label' => 'Редактировать','data-pjax' => 0,]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-trash"></i>', Url::toRoute(['/admins/delete','id' => $model->id]),
                                        ['class' => 'btn btn-danger','title' => 'Удалить','aria-label' => 'Удалить','data-confirm' => 'Вы уверены, что хотите удалить этот элемент?','data-method' => 'post','data-pjax' => 0]);
                                }
                            )
                        ],

                        ],
                        'tableOptions' => ['class' => 'table table-bordered']]); ?>
                 <?php //Pjax::end(); ?>
                </div>
            </div>
        </div>
    </article>
</div>

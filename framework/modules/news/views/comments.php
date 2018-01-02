<?php
/* * ******************************
 * Created by GoldenEye.
 * email : slims.alex@gmail.com
 * WEB: http://scriptsweb.ru
 * copyright 2016 - 2016
 * ****************************** */
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \app\modules\news\models\NewsSearch */
/* @var $type string */

use app\modules\news\models\Comments;
use app\modules\news\models\News;
use app\modules\news\Module;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
$js = <<<JS
        pageSetUp();
        function changeStatus(id, status){
            $.ajax({
              method: "GET",
              url: "/news/comments-update",
              data: { id: id, status: status }
            })
            .done(function( msg, other, xhr ) {  
                if(xhr.status === 200){
                    $.smallBox({
						title : "Успех!",
						content : msg,
						color : "#659265",
						iconSmall : "fa fa-check fa-2x fadeInRight animated",
						timeout : 4000
					});
                }else
                    {
                    $.smallBox({
						title : "Ошибка",
						content : msg,
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				
                    }
            });	
        }
JS;
$this->registerJs($js, View::POS_END)
?>
<section>
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-file-text"></i> Новости <span>&gt; Комментарии</span></h1>
        </div>
        <div class="col-xs-12">
            <div class="">
                <?= Html::a('Опубликованные', Url::toRoute('index'), ['class' => 'btn btn-default col-xs-12 col-sm-2' . ($type == 'published' ? ' disabled' : ''), 'onclick' => $type == 'published' ? 'return false;' : '']) ?>
                <?= Html::a('Скрытые', Url::toRoute('index/type/hidden'), ['class' => 'btn btn-default col-xs-12 col-sm-2' . ($type == 'hidden' ? ' disabled' : ''), 'onclick' => ($type == 'hidden' ? 'return false;' : '')]) ?>
                <?= Html::a('Входящие', Url::toRoute('index/type/new'), ['class' => 'btn btn-default col-xs-12 col-sm-2' . ($type == 'new' ? ' disabled' : ''), 'onclick' => $type == 'new' ? 'return false;' : '']) ?>
                <?= Html::a('Комментарии', Url::toRoute('comments'), ['class' => 'btn btn-default col-xs-12 col-sm-2']) ?>
                <?= Html::a('<i class="fa-fw fa fa-plus-circle"></i> Добавить', Url::toRoute('add'), ['class' => 'btn btn-primary col-xs-12 col-sm-2']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="jarviswidget jarviswidget-color-blueDark">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>Комментарии</h2>
                </header>
                <div>
                    <div class="widget-body" style="padding: 0;">
                        <div class="table-responsive">
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'layout' => "{items}",
                                'rowOptions' => function ($model, $key, $index, $grid) {
                                    $class = $index % 2 ? 'odd' : 'even';
                                    $class = $model->status === 0 ? $class . ' success' : '';
                                    return ['key' => $key, 'index' => $index, 'class' => $class];
                                },
                                'columns' => [
                                    ['attribute' => 'id', 'value' => 'id', 'headerOptions' => ['width' => '45']],
                                    [
                                        'attribute' => 'news',
                                        'headerOptions' => ['width' => '50'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'format' => 'raw',
                                        'value' => function($model) {
                                            //return Html::a($model->news->data['ru']['title'], ['update', 'id' => $model->news_id], ['target' => '_blank']);
                                            return Html::a('#' . $model->news_id, ['update', 'id' => $model->news_id], ['target' => '_blank']);
                                        }
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'headerOptions' => ['width' => '100'],
                                        'format' => ['date', 'php:d.m.Y']
                                    ],
                                    'author',
                                    'comment',
                                    [
                                        'attribute' => 'status',
                                        'format' => 'raw',
                                        'contentOptions' => ['class' => 'text-center'],
                                        'headerOptions' => ['width' => '50'],
                                        'value' => function($model) {
                                            return '<span class="onoffswitch">
                                                        ' . Html::checkbox('id', $model->status == 1 ? true : false, ['class' => 'onoffswitch-checkbox', 'value' => $model->status, 'id' => 'status_' . $model->id, 'onclick' => 'changeStatus(' . $model->id . ' ,this.checked);']) . '
                                                        <label class="onoffswitch-label" for="status_' . $model->id . '">
                                                            <span class="onoffswitch-inner" data-swchon-text="Да" data-swchoff-text="Нет"></span>
                                                            <span class="onoffswitch-switch"></span>
                                                        </label>
                                                    </span>';
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'Удалить',
                                        'headerOptions' => ['width' => '50', 'class' => 'text-center'],
                                        'template' => '{delete}',
                                        'buttons' => [
                                            'delete' => function ($url, $model, $key) {
                                                return Html::a('<i class="fa fa-trash"></i>', Url::to(['/news/comments-delete/' . $model->id]), [
                                                            'class' => 'btn btn-danger',
                                                            'title' => 'Удалить',
                                                            'rel' => 'tooltip',
                                                            'aria-label' => 'Удалить',
                                                            'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                                            'data-method' => 'get',
                                                ]);
                                            }
                                        ]
                                    ],
                                ],
                                'tableOptions' => ['class' => 'table table-bordered'],
                            ])
                            ?>


                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <?=
                LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'firstPageLabel' => '<i class="fa fa-chevron-left"></i><i class="fa fa-chevron-left"></i>',
                    'prevPageLabel' => '<i class="fa fa-chevron-left"></i>',
                    'nextPageLabel' => '<i class="fa fa-chevron-right"></i>',
                    'lastPageLabel' => '<i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>',
                    'maxButtonCount' => 5,
                ])
                ?>
            </div>
        </article>
    </div>
</section>


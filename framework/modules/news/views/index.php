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

use app\modules\news\models\News;
use app\modules\news\Module;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
$js = <<<JS
    pageSetUp();
    function changeStatus(id){
        $.ajax({
          method: "GET",
          url: "/news/view",
          data: { id: id }
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
            }else{
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
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-file-text"></i> Новости <span>&gt; <?= Module::t('index', 'list.' . $type) ?></span></h1>

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
                    <h2><?= Module::t('index', 'list') ?></h2>
                </header>
                <div>
                    <div class="widget-body">
                        <? $form = ActiveForm::begin(['action' => ['index', 'type' => $type], 'method' => 'get', 'options' => ['class' => 'd-block']]); ?>
                        <?=
                                $form->field($searchModel, 'title', ['template' => '<div class="input-group">{input}<div class="input-group-btn"><button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Поиск</button></div></div>'])
                                ->textInput(['placeholder' => 'Поиск по названию'])
                        ?>
                        <?php ActiveForm::end(); ?>
                        <div class="table-responsive">
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'layout' => "{items}",
                                'rowOptions' => function ($model, $key, $index, $grid) {
                                    $class = $index % 2 ? 'odd' : 'even';
                                    return ['key' => $key, 'index' => $index, 'class' => $class];
                                },
                                'columns' => [
                                    ['attribute' => 'id', 'value' => 'id', 'headerOptions' => ['width' => '45']],
                                    [
                                        'attribute' => 'title',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            $title = '';
                                            if (count($model['data']) > 1):
                                                foreach ($model['data'] as $id => $item):
                                                    if (trim($item['title']) != '' && in_array($item['language'], array_keys(Yii::$app->params['languages']))) {
                                                        $title .= "<img src='{$this->theme->getUrl('img/blank.gif')}' class='flag flag-{$item['language']}' style='vertical-align: initial;'> " . $item['title'];
                                                        if ($id != count($model['data']) - 1) {
                                                            $title .= '<br>';
                                                        }
                                                    }
                                                endforeach;
                                            else:
                                                if (isset($model['data']['ru']))
                                                    $title = "<img src='{$this->theme->getUrl('img/blank.gif')}' class='flag flag-{$model['data']['ru']['language']}' style='vertical-align: initial;'> " . $model['data']['ru']['title'];
                                                else
                                                    return 'Не указано';
                                            endif;
                                            return $title;
                                        }
                                    ],
                                    [
                                        'attribute' => 'category_id',
                                        'value' => function ($model) {
                                            return News::getNewsCategory($model->category_id);
                                        },
                                    ],
                                    'created_at',
                                    [
                                        'attribute' => 'type',
                                        'value' => function ($model) {
                                            return News::getNewsTypes($model->type);
                                        },
                                    ],
                                    [
                                        'attribute' => 'published',
                                        'format' => 'raw',
                                        'headerOptions' => ['width' => '50'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'value' => function ($model) {
                                            return '<span class="onoffswitch">
                                                    ' . Html::checkbox('id', $model->published == News::STATUS_ACTIVE ? true : false, ['class' => 'onoffswitch-checkbox', 'value' => $model->published == News::STATUS_ACTIVE ? true : false, 'id' => 'status_' . $model->id, 'onclick' => 'changeStatus('
                                                        . $model->id . ');']) . '
                                                    <label class="onoffswitch-label" for="status_' . $model->id . '">
                                                        <span class="onoffswitch-inner" data-swchon-text="Да" data-swchoff-text="Нет"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </span>';
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'Действия',
                                        'headerOptions' => ['width' => '100'],
                                        'template' => '{update} {delete}',
                                        'buttons' => [
                                            'view' => function ($url, $model, $key) {
                                                return Html::a('<i class="fa fa-eye"></i>', Url::to(['/news/view/' . $model->id]), [
                                                            'class' => 'btn btn-info',
                                                            'title' => 'Показать/Скрыть',
                                                            'rel' => 'tooltip',
                                                            'aria-label' => 'Показать/Скрыть',
                                                ]);
                                            },
                                            'delete' => function ($url, $model, $key) {
                                                return Html::a('<i class="fa fa-trash"></i>', Url::to(['/news/delete/' . $model->id]), [
                                                            'class' => 'btn btn-danger',
                                                            'title' => 'Удалить',
                                                            'rel' => 'tooltip',
                                                            'aria-label' => 'Удалить',
                                                            'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                                            'data-method' => 'get',
                                                ]);
                                            },
                                            'update' => function ($url, $model, $key) {
                                                return Html::a('<i class="fa fa-pencil"></i>', Url::to(['/news/update/' . $model->id]), [
                                                            'class' => 'btn btn-primary',
                                                            'title' => 'Редактировать',
                                                            'rel' => 'tooltip',
                                                            'aria-label' => 'Редактировать',
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


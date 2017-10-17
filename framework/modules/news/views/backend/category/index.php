<?php

use app\modules\organizations\models\Category;
use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\organizations\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Разделы';
$this->params['breadcrumbs'][] = $this->title;
$js = <<<JS
    function changeStatus(id){
        $.ajax({
          method: "GET",
          url: "/news/category/view",
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
<div class="category-index">
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-dedent"></i> Разделы</h1>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 text-align-right">
            <div class="page-title">
				<?= Html::a('<i class="fa-fw fa fa-plus-circle"></i> Добавить', Url::toRoute('create'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <section id="widget-grid">
        <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Список разделов </h2>
                    </header>
                    <div>
                        <div class="jarviswidget-editbox"></div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">
								<?= GridView::widget([
									'dataProvider' => $dataProvider,
									'tableOptions' => ['class' => 'table table-hover no-footer'],
									'options' => ['data' => ['sortable-widget' => 1, 'sortable-url' => Url::toRoute(['sorting'])]],
									'filterPosition' => \yii\grid\GridView::FILTER_POS_HEADER,
									'rowOptions' => function ($model, $key, $index, $grid) {
										return ['data-sortable-id' => $model->id];
									},
									'layout' => '
                                    
                                    {items}
                                    <div class="dt-toolbar-footer">
                                        <div class="col-xs-12 col-sm-6"><div class="dataTables_info">{summary}</div></div>
                                        <div class="col-xs-12 col-sm-6"><div class="dataTables_paginate">{pager}</div></div>
                                    </div>',
									'summary' => 'Показаны записи <span class="txt-color-darken">{begin}</span>-<span class="txt-color-darken">{end}</span> 
                                              из <span class="text-primary">{totalCount}</span>',
									'pager' => [
										'options' => ['class' => 'pagination pagination-sm'],
										'prevPageLabel' => 'Предыдущая',
										'nextPageLabel' => 'Следующая'
									],
									'filterModel' => $searchModel,
									'columns' => [
										['attribute' => 'id', 'headerOptions' => ['style' => 'width: 80px;']],
										'title',
										[
											'attribute' => 'published',
											'format' => 'raw',
											'filter' => [Category::STATUS_ACTIVE => 'Да', Category::STATUS_DISABLE => 'Нет'],
											'headerOptions' => ['width' => '70'],
											'contentOptions' => ['class' => 'text-center'],
											'value' => function ($model) {
												return '<span class="onoffswitch">
                                                ' . Html::checkbox('id', $model->published == Category::STATUS_ACTIVE ? true : false, [
														'class' => 'onoffswitch-checkbox',
														'value' => $model->published == Category::STATUS_ACTIVE ? true : false,
														'id' => 'status_' . $model->id,
														'onclick' => "changeStatus('{$model->id}');"
													]) . '
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
													return Html::a('<i class="fa fa-eye"></i>', Url::toRoute(['view/' . $model->id]), [
														'class' => 'btn btn-info',
														'title' => 'Показать/Скрыть',
														'rel' => 'tooltip',
														'aria-label' => 'Показать/Скрыть',
													]);
												},
												'delete' => function ($url, $model, $key) {
													return Html::a('<i class="fa fa-trash"></i>', Url::toRoute(['category/delete', 'id' => $model->id ]), [
														'class' => 'btn btn-danger',
														'title' => 'Удалить',
														'rel' => 'tooltip',
														'aria-label' => 'Удалить',
														'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
														'data-method' => 'post',

													]);
												},
												'update' => function ($url, $model, $key) {
													return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['category/update', 'id' => $model->id ]), [
														'class' => 'btn btn-primary',
														'title' => 'Редактировать',
														'rel' => 'tooltip',
														'aria-label' => 'Редактировать',

													]);
												}
											]
										],
									],
								]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>

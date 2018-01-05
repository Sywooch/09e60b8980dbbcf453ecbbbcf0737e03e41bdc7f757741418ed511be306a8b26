<?php

use app\modules\organizations\models\Category;
use kartik\tree\TreeView;
use kartik\tree\TreeViewInput;
use leandrogehlen\treegrid\TreeGrid;
use slatiusa\treetable\Treetable;
use voskobovich\tree\manager\widgets\nestable\Nestable;
use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\organizations\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
$js = <<<JS
    function changeStatus(id){
        $.ajax({
          method: "GET",
          url: "/organizations/category/view",
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
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-dedent"></i> Категории</h1>
        </div>
    </div>
    <section id="widget-grid">
        <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?
                echo TreeView::widget([
                    'query' => Category::find()->addOrderBy('root, lft'),
                    'headingOptions' => ['label' => 'Категории'],
                    'displayValue' => 1, // initial display value
                    'softDelete' => false, // normally not needed to change
                    'showInactive' => true, // normally not needed to change
                    'fontAwesome' => true,
                    'nodeView' => '@app/modules/organizations/views/backend/default/tree'
                ]);
                ?>
            </article>
        </div>
    </section>
</div>

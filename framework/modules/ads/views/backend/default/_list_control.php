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

/* @var $this yii\web\View */
/* @var $model app\modules\ads\models\Ads */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Объявления';
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
            <!--<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-file-text"></i> Новости <span>&gt; Комментарии</span></h1>-->
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 text-align-right">
            <div class="page-title">
                <?= Html::a('Опубликованные', Url::toRoute('index'), ['class' => 'btn btn-default']) ?>
                <?= Html::a('Скрытые', Url::toRoute(['index', 'type' => 'hidden']), ['class' => 'btn btn-default']) ?>
                <?= Html::a('Входящие', Url::toRoute(['index', 'type' => 'new']), ['class' => 'btn btn-default']) ?>
                <?= Html::a('Комментарии', Url::toRoute('comments'), ['class' => 'btn btn-default disabled', 'onclick' => 'return false;']) ?>
                <?= Html::a('<i class="fa-fw fa fa-plus-circle"></i> Добавить', Url::toRoute('add'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

</section>


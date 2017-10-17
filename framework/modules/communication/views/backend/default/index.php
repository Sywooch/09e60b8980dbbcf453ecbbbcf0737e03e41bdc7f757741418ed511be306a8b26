<?php
    use yii\helpers\Html;
	use yii\web\View;
	use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\communication\models\CommunicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Общение';
$this->params['breadcrumbs'][] = $this->title;
	$js = <<<JS
    function changeStatus(thi){
        var _this = $(thi);
        $.ajax({
          method: "POST",
          url: "/communication/view",
          data: { id: _this.data('id'), pin: _this.data('pin'), checked: _this.is(":checked") }
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
<div class="communication-index">
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-comment-o"></i> <?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
        'layout' => '{summary}
            <div class="row">
                <div class="col-sm-12">
                    <div class="well padding-10">
                        {items}
                  </div>
                </div>
            </div>
            {pager}',
        'summary' => '
             <div class="row">
                <div class="col-sm-6">'.$this->render('_search', ['model' => $searchModel]).'</div>
                <div class="col-sm-6 text-align-right">Показаны записи {begin}-{end} из {totalCount}</div>
            </div>'
    ]); ?>
</div>

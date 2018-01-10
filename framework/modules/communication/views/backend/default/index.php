<?php

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

/* @var $searchModel app\modules\communication\models\CommunicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$this->title = 'Общение';
$this->title = 'Общение/Объявления';
$this->params['breadcrumbs'][] = $this->title;
//echo'<pre>';
//var_dump($CgetList);
//die;
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
    function d_id( event ) {
         if (confirm("Вы подтверждаете удаление?")) {
//	        submit();
	    } else {
	        event.preventDefault();
	    }
        
      };
        
JS;
$this->registerJs($js, View::POS_END)
?>
<style>
    .d_id{
        color: red;
    }
</style>
<div class="communication-index">
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-comment-o"></i> <?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <div id ="Communication" class="col-xs-12 col-sm-4" style="border-right: 1px solid;">
        <h3>Общение</h3>
        <? foreach ($CgetList['item_list'] as $vol) { ?>
            <div>
                <?= render_list($vol, 'Communication', $users) ?>
            </div>
        <? } ?>
    </div>
    <div id ="Ads" class="col-xs-12 col-sm-4" style="border-right: 1px solid;">
        <h3>Объявления</h3>
        <? foreach ($AgetList['item_list'] as $vol) { ?>
            <div>
                <?= render_list($vol, 'Ads', $users) ?>
            </div>
        <? } ?>
    </div>
    <div id ="Comment" class="col-xs-12 col-sm-4" >
        <h3>Комментарии</h3>
        <? foreach ($CommentList['item_list'] as $vol) { ?>
            <div>
                <?= render_list($vol, 'Comment', $users) ?>
            </div>
        <? } ?>
    </div>
</div>
<?

function render_list($data, $action, $users) {
    $model = (object) $data;
    $class = null;
    if ($model->status == '2') {
        $class = 'd_id';
    }
    ob_start();
    ?>
    <div class="row" style="background-color: white;">
        <div class="col-md-12">
            <div class="row margin-bottom-10">
                <div class="col-sm-2">
                    <h5 class="<?= $class ?>">
                        <i class="fa fa-hashtag"></i>
                        <small><?= $model->id ?></small>
                    </h5>
                </div>
                <div class="col-sm-4">
                    <h5 >
                        <i class="fa fa-calendar"></i>
                        <small><?= $model->created_at ?></small>
                    </h5>
                </div>
                <div class="col-sm-6">
                    <h5>
                        <img src="<?= $users[$model->user_id]["photo_250"] ?>" style="border-radius: 50%;width: 32px;">
                        <span style="font-size: 13px;"><?= $users[$model->user_id]['name'] . ' ' . $users[$model->user_id]["f_name"] ?></span>
                    </h5>
                </div>
            </div>
            <p>
                <?= Html::encode($model->text); ?><br>
                <? if (!empty($model->img)) { ?>
                    <a href="<?= Html::encode($model->img) ?>" target="_blank"><img src="<?= Html::encode($model->img) ?>" width="100px"></a>     
                <? } ?>

            </p>
            <div class="row">
                <div class="col-xs-12" style="border-top: 1px solid #CFCFCF;">
                    <div class="smart-form" style="width: 200px;float: left;">
                        <div class="inline-group">
                            <label class="checkbox">
                                <?=
                                Html::a(' Одобрить', Url::toRoute(['approve/' . $model->id . '?action=' . $action]), [
                                    'class' => 'text-green',
                                    'title' => 'Одобрить',
                                    'rel' => 'tooltip',
                                    'aria-label' => 'Одобрить',
                                    'data-method' => 'post',
                                ])
                                ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4 text-align-right" style="float: right;">
                        <?=
                        Html::a('Удалить', Url::toRoute(['delete/' . $model->id . '?action=' . $action]), [
                            'class' => 'text-danger',
                            'title' => 'Удалить',
                            'rel' => 'tooltip',
                            'onclick' => 'd_id(event);',
                            'aria-label' => 'Удалить',
                            'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                            'data-method' => 'post',
                        ])
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <?
    $cont = ob_get_contents();
    ob_end_clean();
    return $cont;
}
?>
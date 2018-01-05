<?php

// _list_item.php
use yii\helpers\Html;
use yii\helpers\Url;

$class = null;
if ($model->status == '2') {
    $class = 'd_id';
}
?>
<style>
    .d_id{
        color: red;
    }
</style>
<div class="row" style="background-color: white;">
    <div class="col-md-12">
        <div class="row margin-bottom-10">
            <div class="col-sm-4">
                <h5 class="<?= $class ?>">
                    <i class="fa fa-hashtag"></i>
                    <small><?= $model->id ?></small>
                </h5>
            </div>
            <div class="col-sm-4">
                <h5 >
                    <i class="fa fa-calendar"></i>
                    <small><?= !is_null($model->created_at) ? Yii::$app->formatter->asDatetime($model->created_at) : '' ?></small>
                </h5>
            </div>
            <div class="col-sm-4">
                <h5>
                    <i class="fa fa-user"></i>
                    <!--<small><?= Html::a($model->user['first_name'] . ' ' . $model->user['last_name'], ['/users/update', 'id' => $model->user['id']]) ?></small>-->
                    на кон․
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
            <div class="col-xs-12" >
                <div class="smart-form" style="width: 200px;float: left;">
                    <div class="inline-group">
                        <label class="checkbox">
<?= Html::Checkbox('pin', $model->pin, ['data-id' => $model->id, 'data-pin' => 'main', 'onclick' => "changeStatus(this);"]) ?><i></i>Отправить на спам
                        </label>
                    </div>
                </div>
                <div class="col-sm-4 text-align-right" style="float: right;">
                    <h5>
                        <?=
                        Html::a('<i class="fa fa-remove"></i> Удалить', Url::toRoute(['delete/' . $model->id]), [
                            'class' => 'text-danger',
                            'title' => 'Удалить',
                            'rel' => 'tooltip',
                            'onclick'=>'d_id(event);',
                            'aria-label' => 'Удалить',
                            'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                            'data-method' => 'post',
                        ])
                        ?>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>


<?php
	// _list_item.php
	use yii\helpers\Html;
	use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-12">
        <div class="row margin-bottom-10">
            <div class="col-sm-4">
                <h5>
                    <i class="fa fa-hashtag"></i>
                    <small><?=$model->id?></small>
                </h5>
            </div>
            <div class="col-sm-4">
                <h5>
                    <i class="fa fa-calendar"></i>
                    <small><?=!is_null($model->created_at) ? Yii::$app->formatter->asDatetime($model->created_at):''?></small>
                </h5>
            </div>
            <div class="col-sm-4">
                <h5>
                    <i class="fa fa-user"></i>
                    <small><?=Html::a($model->user['account_name'], ['/users/update', 'id' => $model->user['id']])?></small>

                </h5>
            </div>
        </div>
        <p>
	        <?= Html::encode($model->text); ?>
        </p>
        <div class="row">
            <div class="col-sm-8">
                <div class="smart-form">
                    <div class="inline-group">
                        <label class="checkbox">
				            <?= Html::Checkbox('pin_main', $model->pin_main, ['data-id' => $model->id, 'data-pin'=> 'main','onclick' => "changeStatus(this);"])?><i></i>Закрепить на главной
                        </label>
                        <label class="checkbox">
				            <?= Html::Checkbox('pin_filter',$model->pin_filter, [ 'data-id' => $model->id, 'data-pin'=> 'filter','onclick' => "changeStatus(this);"])?><i></i>Закрепить в фильтре
                        </label>
                    </div>
                </div></div>
            <div class="col-sm-4 text-align-right">
                <h5>
                <?=Html::a('<i class="fa fa-remove"></i> Удалить', Url::toRoute(['delete/' . $model->id]), [
	                'class' => 'text-danger',
	                'title' => 'Удалить',
	                'rel' => 'tooltip',
	                'aria-label' => 'Удалить',
	                'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
	                'data-method' => 'post',
                ])?>
                </h5>
            </div>
        </div>
    </div>
</div>
<hr>


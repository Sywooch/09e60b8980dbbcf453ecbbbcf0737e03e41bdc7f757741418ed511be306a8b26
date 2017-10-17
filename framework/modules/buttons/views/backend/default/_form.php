<?php

	use app\modules\buttons\models\Buttons;
	use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\buttons\models\Buttons */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="buttons-form">

    <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['class' => 'smart-form']]); ?>
    <fieldset>
        <section>
		    <?= $form->field($model, 'title', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->textInput(['maxlength' => true]) ?>
        </section>
        <section>
		    <?= $form->field($model, 'url', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->textInput(['maxlength' => true]) ?>
        </section>
        <section>
		    <?= $form->field($model, 'telephone', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->textInput(['maxlength' => true]) ?>
        </section>
        <section>
		    <?= $form->field($model, 'published')->dropDownList([
			    Buttons::STATUS_ACTIVE => 'Да',
			    Buttons::STATUS_DISABLE => 'Нет',
		    ]) ?>
        </section>
        <section>
		    <?= $form->field($model, 'section')->dropDownList(Buttons::ListOfCategories()) ?>
        </section>
        <section>
		    <?= $form->field($model, 'section_id', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->textInput(['maxlength' => true]) ?>
        </section>
        <section class="col col-6">
            <? if ($model->isNewRecord || empty($model->image)):
                echo $form->field($model, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="' . $placeholder . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
            else:
                echo $form->field($model, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="' . \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot' . $model->image), 200, 200, 'outbound', 0,
                        Yii::getAlias('@webroot/uploads/cache/' . $model->image)) . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
            endif;
            ?>
        </section>
    </fieldset>
    <footer>
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </footer>
    <?php ActiveForm::end(); ?>

</div>

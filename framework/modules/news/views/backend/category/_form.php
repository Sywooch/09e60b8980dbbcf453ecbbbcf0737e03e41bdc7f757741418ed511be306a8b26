<?php

use app\modules\organizations\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\organizations\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$form = ActiveForm::begin([
            'id' => 'news-form',
            'method' => 'post',
            //'enableClientValidation' => true,
            'options' => [
                'class' => 'smart-form',
            //'validateOnSubmit' => true,
            //'validateOnType' => true,
            ],
        ]);
?>
<fieldset>
    <div class="row">
        <section class="col col-sm-12 col-lg-12">
            <header>Редактор</header>
            <section><?= $form->field($model, 'title', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->textInput(['maxlength' => true]) ?></section>
            <section><?=
                $form->field($model, 'published')->dropDownList([
                    Category::STATUS_ACTIVE => 'Да',
                    Category::STATUS_DISABLE => 'Нет',
                ])
?>
            </section>
            <section>
                <?
                if ($model->isNewRecord || (empty($model->image) || !file_exists(Yii::getAlias($model->image)))):
                    echo $form->field($model, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="' . $placeholder . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
                else:
                    echo $form->field($model, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="' . \Yii::$app->imageresize->getUrl(Yii::getAlias($model->image), 100, 100, 'outbound', 0, Yii::getAlias('uploads/cache/' . $model->image)) . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
                endif;
                ?>
            </section>
        </section>
    </div>
</fieldset>
<footer>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</footer>
<?php ActiveForm::end(); ?>
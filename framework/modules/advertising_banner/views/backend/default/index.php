<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\modules\advertising\models\Advertising */
/* @var $searchModel app\modules\advertising\models\AdvertisingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Баннерная реклама');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-index">
    <div class="advertising-form">
        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-bullhorn"></i> <?= Html::encode($this->title) ?></h1>
            </div>
        </div>
        <section id="widget-grid">
            <div class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-pencil-square-o"></i> </span>
                            <h2>Редактор баннерной рекламы</h2>
                        </header>
                        <div>
                            <div class="jarviswidget-editbox"></div>
                            <div class="widget-body no-padding">
                                        <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['class' => 'smart-form']]); ?>
                                <fieldset>
                                    <section>
<?= $form->field($model, 'telephone', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])
        ->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+9999-999-9999'])
?>
                                    </section>
                                    <section>
                                        <?= $form->field($model, 'organization_id', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])
                                                ->textInput(['maxlength' => true, 'placeholder' => ''])
                                        ?>
                                    </section>
                                    <section>
                                        <?= $form->field($model, 'category_id', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])
                                                ->textInput(['maxlength' => true, 'placeholder' => ''])
                                        ?>
                                    </section>
                                    <section>
                                        <?= $form->field($model, 'url', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->textInput(['maxlength' => true]) ?>
                                    </section>
                                    <section class="col col-6">
                                        <?
                                        if ($model->isNewRecord || empty($model->image)):
                                            echo $form->field($model, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="' . $placeholder . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
                                        else:
                                            echo $form->field($model, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="' . \Yii::$app->imageresize->getUrl(Yii::getAlias($model->image), 200, 200, 'outbound', 0, Yii::getAlias('@webroot/uploads/cache/' . $model->image)) . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
                                        endif;
                                        ?>
                                    </section>
                                </fieldset>
                                <footer>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                                </footer>
<?php ActiveForm::end(); ?>
                            </div>
                        </div>
                </article>
            </div>
        </section>
    </div>
</div>

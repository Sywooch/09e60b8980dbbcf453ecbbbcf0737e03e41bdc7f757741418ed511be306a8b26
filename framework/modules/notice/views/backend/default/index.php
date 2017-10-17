<?php
	use kartik\datetime\DateTimePicker;
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	/* @var $this yii\web\View */
	/* @var $model \app\modules\notice\models\Notice */
	/* @var $dataProvider yii\data\ActiveDataProvider */

	$this->title = Yii::t('app', 'Пуш-уведомление');
	$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-index">
    <div class="advertising-form">
        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-envelope-o"></i> <?= Html::encode($this->title) ?></h1>
            </div>
        </div>
        <section id="widget-grid">
            <div class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-pencil-square-o"></i> </span>
                            <h2>Последнее пуш-ведомление</h2>
                        </header>
                        <div>
                            <div class="jarviswidget-editbox"></div>
                            <div class="widget-body no-padding">
								<?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['class' => 'smart-form']]); ?>
                                <fieldset>
                                    <section>
		                                <?= $form->field($model, 'platform')->dropDownList([
			                                0 => 'Все',
			                                1 => 'iOS',
			                                2 => 'Android',
		                                ]) ?>
                                    </section>
                                    <!--<section>-->
		                             <!--   --><?//= $form->field($model, 'title', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])
			                         //       ->textInput(['maxlength' => true]) ?>
                                    <!--</section>-->
                                    <section>
		                                <?= $form->field($model, 'text', ['template' => '{label} <label class="textarea">{input}{error}{hint}</label>'])->textarea(['rows' => 6]) ?>
                                    </section>

                                    <section>
		                                <?= $form->field($model, 'section', ['template' => '{label} <label class="textarea">{input}{error}{hint}</label>'])
                                            ->dropDownList([
                                                    0 => 'Новости',
                                                    1 => 'Организации',
                                                    2 => 'Афиша',
                                                    3 => 'Акции',
                                            ]) ?>
                                    </section>
                                    <section>
		                                <?= $form->field($model, 'section_id', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])
			                                ->textInput(['maxlength' => true]) ?>
                                    </section>

                                    <section>
		                                <?= $form->field($model, 'send_at', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-clock-o"></i>{input}{error}{hint}</label>'])
			                                ->widget(DateTimePicker::className(), [
				                                'name' => 'datetime_10',
				                                'options' => ['placeholder' => 'Выберете дату и время'],
				                                'convertFormat' => true,
				                                'removeButton' => false,
				                                'pluginOptions' => [
					                                'autoclose' => true,
					                                'format' => 'yyyy-MM-dd H:i',
					                                'todayHighlight' => true
				                                ]
			                                ]);?>
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
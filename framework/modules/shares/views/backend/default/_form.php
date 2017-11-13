<?php
	use app\modules\filters\models\Filters;
	use app\modules\shares\models\Shares;
	use kartik\datetime\DateTimePicker;
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	/* @var $this yii\web\View */
	/* @var $model app\modules\shares\models\Shares */
	/* @var $form yii\widgets\ActiveForm */
?>
<div class="shares-form">
	<?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['class' => 'smart-form']]); ?>
    <fieldset>
        <section>
			<?= $form->field($model, 'name', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-percent"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Название акции']) ?>
        </section>
        <section>
			<?= $form->field($model, 'description', ['template' => '{label} <label class="textarea"><i class="icon-prepend fa fa-info"></i>{input}{error}{hint}</label>'])->textarea(['rows' => 6, 'placeholder' => 'Описание акции']) ?>
        </section>
        <section>
            <?= $form->field($model, 'category_id')->dropDownList(Filters::ListOfFilters(Filters::CATEGORY_SHARES)) ?>
        </section>
        <section>
			<?= $form->field($model, 'published')->dropDownList(Shares::PublishedStatus()) ?>
        </section>
        <section>
			<?= $form->field($model, 'url_video', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-video-camera"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Ссылка на видео']) ?>
        </section>
        <section>
            <?= $form->field($model, 'url_descrition', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-external-link"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true]) ?>
        </section>
        <section>
			<?= $form->field($model, 'price', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-money"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true]) ?>
        </section>
        <section>
		    <?= $form->field($model, 'start_at', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-clock-o"></i>{input}{error}{hint}</label>'])
			    ->widget(DateTimePicker::className(), [
				    'name' => 'datetime_10',
				    'options' => ['placeholder' => 'Выберете дату'],
				    'convertFormat' => true,
				    'removeButton' => false,
				    'pluginOptions' => [
					    'autoclose' => true,
					    'format' => 'yyyy-MM-dd H:i',
					    'todayHighlight' => true
				    ]
			    ]);?>
        </section>
        <section>
		    <?= $form->field($model, 'end_at', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-clock-o"></i>{input}{error}{hint}</label>'])
			    ->widget(DateTimePicker::className(), [
				    'name' => 'datetime_11',
				    'options' => ['placeholder' => 'Выберете дату'],
				    'removeButton' => false,
				    'convertFormat' => true,
				    'pluginOptions' => [
					    'autoclose' => true,
					    'format' => 'yyyy-MM-dd H:i',
					    'todayHighlight' => true
				    ]
			    ]); ?>
        </section>
    </fieldset>
    <header>Контакты и информация</header>
    <fieldset>
        <div class="row">
            <section class="col col-6">
                <section>
					<?= $form->field($model, 'address', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-home"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Адресс']) ?>
                </section>
                <section>
					<?= $form->field($model, 'url', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-link"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Сайт']) ?>
                </section>
                <section>
					<?= $form->field($model, 'telephone', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-phone"></i>{input}{error}{hint}</label>'])->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+9999-999-9999']) ?>
                </section>
            </section>
            <section class="col col-6 text-center">
				<? if ($model->isNewRecord || empty($model->image)):
					echo $form->field($model, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="' . $placeholder . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
				else:
					echo $form->field($model, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="' . \Yii::$app->imageresize->getUrl(Yii::getAlias($model->image), 200, 200, 'outbound', 0,
							Yii::getAlias('/uploads/cache/' . $model->image)) . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
				endif;
				?>
            </section>
        </div>
    </fieldset>
    <fieldset>
        <section>
            <label class="label">Закрепить</label>
            <div class="inline-group">
                <label class="checkbox">
					<?= Html::Checkbox('Shares[pin_main]', $model->pin_main,[ 'checked' => $model->pin_main])?>
                    <i></i>
                    На главной
                </label>
                <label class="checkbox">
					<?= Html::Checkbox('Shares[pin_poster]',$model->pin_poster)?>
                    <i></i>
                    В акциях на главной
                </label>
                <label class="checkbox">
					<?= Html::Checkbox('Shares[pin_filter]',$model->pin_filter)?>
                    <i></i>
                    В фильтре
                </label>
            </div>
        </section>
    </fieldset>
    <footer>
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </footer>
	<?php ActiveForm::end(); ?>
</div>

<?php
	/********************************
	 * Created by GoldenEye.
	 * email : slims.alex@gmail.com
	 * WEB: http://scriptsweb.ru
	 * copyright 2016 - 2016
	 ********************************/
	use app\modules\news\models\News;
	use app\modules\news\Module;
	use yii\web\View;
	use yii\widgets\ActiveForm;

	/* @var $this \yii\web\View */
	/* @var $placeholder string */
	/* @var $model News */
	/* @var $data \app\modules\news\models\Data */
	$this->title = 'Новости';
	$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $model->isNewRecord ? Module::t('index', 'add') : Module::t('index', 'editor.id', ['id' => $model->id]);
?>
    <style>
        #images .btn { padding: 6px 12px !important;margin: 5px !important; }
        #images .btn:not(:first-child) { margin-left: 0 !important; }
    </style>
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-file-text"></i> Новости <span>&gt; <?= ($model->isNewRecord) ? Module::t('index', 'add') : Module::t('index', 'editor.id', ['id' => $model->id]) ?></span></h1>
        </div>
    </div>
    <div class="jarviswidget">
        <div>
            <div class="widget-body no-padding">
				<? $form = ActiveForm::begin([
					'id' => 'news-form',
					'method' => 'post',
					'enableClientValidation' => true,
					'options' => [
						'class' => 'smart-form',
						'validateOnSubmit' => true,
						'validateOnType' => true,
						'enctype' => 'multipart/form-data',
						'afterValidate' => "js: function(form, data, hasError){SaveNews(form, data, hasError)}"
					],
				]) ?>
                <fieldset>
                    <div class="row">
                        <section class="col  col-sm-12 col-lg-8">
                            <header><?= ($model->isNewRecord) ? Module::t('index', 'creation') : Module::t('index', 'editor') ?></header>
                            <div id="tabs">
                                <ul>
									<? foreach (Yii::$app->params['languages'] as $id => $lang): ?>
                                        <li>
                                            <a href="#tabs-<?= $id ?>"> <img src="<?= $this->theme->getUrl('img/blank.gif') ?>" class="flag flag-<?= $id ?>"> <span><?= $lang ?></span></a>
                                        </li>
									<? endforeach; ?>
                                </ul>

								<? foreach (Yii::$app->params['languages'] as $id => $lang): ?>
									<? if ($model->isNewRecord): ?>
                                        <div id="tabs-<?= $id ?>">
                                            <section>
												<?= $form->field($data, 'title', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->textInput(['name' => "Data[{$id}][title]"]) ?>
                                            </section>
                                            <section>
												<?= $form->field($data, 'text')->textarea(['class' => 'CKEDITOR', 'rows' => 10, 'id' => $id, 'name' => "Data[{$id}][text]"]) ?>
                                            </section>
                                        </div>
									<? else: ?>
                                        <div id="tabs-<?= $id ?>">
                                            <section>
												<?= isset($model->data[$id]) ? $form->field($model->data[$id], "[$id]title", ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->textInput() : $form->field($data, "[$id]title")->textInput() ?>
                                            </section>
                                            <section>
												<?= isset($model->data[$id]) ? $form->field($model->data[$id], "[$id]text")->textarea(['class' => 'CKEDITOR', 'id' => $id])
													:
													$form->field($data, "[$id]text")->textarea(['class' => 'CKEDITOR', 'id' => $id]) ?>
                                            </section>
                                        </div>
									<? endif; ?>
								<? endforeach; ?>
                            </div>
                        </section>
                        <section class="col col-sm-12 col-lg-4">
                            <header><?= Module::t('index', 'edit.options') ?></header>
                            <fieldset>
                                <section><?= $form->field($model, 'published')->dropDownList($model::getNewsStatus()) ?></section>
                                <section><?= $form->field($model, 'category_id')->dropDownList($model::getNewsCategory()) ?></section>
                                <section><?= $form->field($model, 'type')->dropDownList($model::getNewsTypes()) ?></section>
                                <section><?= $form->field($model, 'source_url', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->textInput() ?></section>
                                <section><?= $form->field($model, 'video_url', ['template' => '{label} <label class="input">{input}{error}{hint}</label>'])->textInput() ?></section>
                            </fieldset>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col  col-sm-12 col-lg-12">
                            <header>Изображения</header>
                            <!--<fieldset>-->
                            <div class="table-responsive">
                                <table id="images" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td class="text-left">Изображение</td>
                                        <td class="text-right">Порядок сортировки</td>
                                        <td></td>
                                    </tr>
                                    </thead>
                                    <tbody>
									<? if (!$model->isNewRecord): ?>
										<?php $image_row = 0; ?>
										<?php foreach ($model->image as $image) { ?>
                                            <tr id="image-row<?= $image_row; ?>">
                                                <td class="text-left">
                                                    <a href="" id="thumb-image<?= $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                                        <img src="<?= \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot/' . $image['image']), 100, 100, 'outbound', 0, Yii::getAlias('@webroot/uploads/cache/' . $image['image'])); ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>"/></a>
                                                    <input type="hidden" name="news_image[<?= $image_row; ?>][image]" value="<?= $image['image']; ?>" id="input-image<?= $image_row; ?>"/>
                                                </td>
                                                <td class="text-right"><input type="text" name="image[<?= $image_row; ?>][sort_order]" value="<?= $image['sort_order']; ?>" placeholder="Порядок сортировки" class="form-control"/></td>
                                                <td class="text-left">
                                                    <button type="button" onclick="$('#image-row<?= $image_row; ?>').remove();" data-toggle="tooltip" title="Удалить" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                                </td>
                                            </tr>
											<?php $image_row++; ?>
										<?php } ?>
									<? endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="text-left">
                                            <button type="button" onclick="addImage();" data-toggle="tooltip" title="Добавить изображение" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!--</fieldset>-->
                        </section>
                    </div>
                </fieldset>
                <footer>
                    <button type="submit" class="btn btn-primary"><?= ($model->isNewRecord) ? Module::t('index', 'button.create') : Module::t('index', 'button.save') ?></button>
                </footer>
				<? ActiveForm::end() ?>
            </div>
        </div>
    </div>
<?php

	$image_row = isset($image_row) ? $image_row : 0;
	$this->registerJsFile($this->theme->getUrl('js/plugin/ckeditor4/ckeditor.js'), ['position' => \yii\web\View::POS_END, 'depends' => 'yii\web\YiiAsset']);
	$js = <<<JS

    var image_row = $image_row;
    function addImage() {
        html = '<tr id="image-row' + image_row + '">';
        html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="$placeholder" alt="" title="" data-placeholder="$placeholder" />' +
                '<input type="hidden" name="news_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></a></td>';
        html += '  <td class="text-right"><input type="text" name="news_image[' + image_row + '][sort_order]" value="" placeholder="Порядок сортировки" class="form-control" /></td>';
        html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row + '\').remove();" data-toggle="tooltip" title="Удалить" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';
        $('#images').find('tbody').append(html);
        image_row++;
    }
    
    pageSetUp();
    var pagefunction = function () {
        $("#tabs").tabs();
        $(".CKEDITOR").each(function (key, value) {
            CKEDITOR.replace($(value).attr("id"),{ enterMode: CKEDITOR.ENTER_BR, shiftEnterMode: CKEDITOR.ENTER_BR, extraAllowedContent: 'script;span;ul;li;i;table;td;style;*[id];*(*);*{*}' });
        });
    };
    pagefunction();
JS;
	$this->registerJs($js, View::POS_END);


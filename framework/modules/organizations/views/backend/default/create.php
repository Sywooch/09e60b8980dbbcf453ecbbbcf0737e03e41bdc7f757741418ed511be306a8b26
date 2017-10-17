<?php
/* @var $placeholder string */
/* @var $this yii\web\View */
/* @var $model app\modules\organizations\models\OrganizationsForm */
/* @var $form yii\widgets\ActiveForm */
use app\modules\organizations\models\Category;
use app\modules\organizations\models\Organizations;
	use kartik\tree\TreeViewInput;
	use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить организацию';
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organizations-create">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-dedent"></i> Организации <span>&gt; <?= Html::encode($this->title) ?></span></h1>
        </div>
    </div>
    <section id="widget-grid">
        <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pencil-square-o"></i> </span>
                        <h2>Редактор</h2>
                    </header>
                    <div>
                        <div class="jarviswidget-editbox"></div>
                        <div class="widget-body no-padding">
		                    <?php $form = ActiveForm::begin(['id' => 'organization-form', 'method' => 'post', 'options' => ['class' => 'smart-form']]); ?>
                            <header>
                                Основная информация
                            </header>
                            <fieldset>
                                <div class="row">
                                    <section class="col col-6">
                                        <section>
						                    <?= $form->field($model->organization, 'name', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-briefcase"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Название организации']) ?>
                                        </section>
                                        <section>
						                    <?= $form->field($model->organization, 'description', ['template' => '{label} <label class="textarea"><i class="icon-prepend fa fa-info"></i>{input}{error}{hint}</label>'])->textarea(['rows' => 6, 'placeholder' => 'Информация об организации']) ?>
                                        </section>
                                    </section>
                                    <section class="col col-6 text-align-center">
					                    <? if ($model->organization->isNewRecord || empty($model->organization->image)):
						                    echo $form->field($model->organization, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="' . $placeholder . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
					                    else:
						                    echo $form->field($model->organization, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="' . \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot' . $model->organization->image), 200, 200, 'outbound', 0,
								                    Yii::getAlias('@webroot/uploads/cache/' . $model->organization->image)) . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
					                    endif;
					                    ?>
                                    </section>
                                </div>

                                <div class="row">
                                    <section class="col col-6">
                                        <section>
                                            <div class="form-group">
							                    <?= $form->field($model->organization, 'category_id', ['template' => '<label class="input">{input}{error}{hint}</label>'])->widget(TreeViewInput::classname(),
								                    [
									                    'name' => 'category_list',
									                    'value' => 'true', // preselected values
									                    'query' => Category::find()->andWhere(['active' => true])->addOrderBy('root, lft'),
									                    'headingOptions' => ['label' => 'Категории'],
									                    'rootOptions' => ['label' => '<i class="fa fa-tree text-success"></i>'],
									                    'fontAwesome' => true,
									                    'asDropdown' => false,
									                    'multiple' => true,
									                    'options' => ['disabled' => false]
								                    ]); ?>
                                            </div>
                                        </section>

                                    </section>
                                    <section class="col col-6">


                                        <section>
						                    <?= $form->field($model->organization, 'url', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-link"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Сайт организации']) ?>
                                        </section>
                                        <section>
						                    <?= $form->field($model->organization, 'url_vk', ['template' => '<label class="input"><i class="icon-prepend fa fa-vk"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://vk.com']) ?>
                                        </section>
                                        <section>
						                    <?= $form->field($model->organization, 'url_ok', ['template' => '<label class="input"><i class="icon-prepend fa fa-odnoklassniki"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://ok.ru']) ?>
                                        </section>
                                        <section>
						                    <?= $form->field($model->organization, 'url_facebook', ['template' => '<label class="input"><i class="icon-prepend fa fa-facebook"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://facebook.com']) ?>
                                        </section>
                                        <section>
						                    <?= $form->field($model->organization, 'url_instagram', ['template' => '<label class="input"><i class="icon-prepend fa fa-instagram"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://instagram.com']) ?>
                                        </section>
                                        <section>
						                    <?= $form->field($model->organization, 'url_twitter', ['template' => '<label class="input"><i class="icon-prepend fa fa-twitter"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://twitter.com']) ?>
                                        </section>
                                    </section>
                                </div>
                            </fieldset>
                            <footer>
			                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                            </footer>
		                    <?php ActiveForm::end(); ?>
                        </div>

                        <!--<div class="widget-body no-padding">-->
							<?php //$form = ActiveForm::begin(['id' => 'news-form', 'method' => 'post', 'options' => ['class' => 'smart-form']]); ?>
                        <!--    <header>-->
                        <!--        Основная информация-->
                        <!--    </header>-->
                        <!---->
                        <!--    <fieldset>-->
                        <!--        <section>-->
							<!--		--><?//=$form->field($model->organization, 'name', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-briefcase"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Название организации']) ?>
                        <!--        </section>-->
                        <!--        <section>-->
							<!--		--><?//=$form->field($model->organization, 'description', ['template' => '{label} <label class="textarea"><i class="icon-prepend fa fa-info"></i>{input}{error}{hint}</label>'])->textarea(['rows' => 6, 'placeholder' => 'Информация об организации']) ?>
                        <!--        </section>-->
                        <!--        <div class="row">-->
                        <!--            <section class="col col-6">-->
                        <!--                <section>--><?//= $form->field($model->organization, 'category_id')->dropDownList(Category::ListOfCategories()) ?><!--</section>-->
                        <!--                <section>--><?//= $form->field($model->organization, 'published')->dropDownList(Organizations::PublishedStatus()) ?><!--</section>-->
                        <!--            </section>-->
                        <!--            <section class="col col-6 text-center">-->
							<!--			--><?// if($model->organization->isNewRecord || empty($model->organization->image)):
							//				echo $form->field($model->organization, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="'.$placeholder.'" alt="" title="" data-placeholder="'.$placeholder.'" />{input}{error}{hint}</label></a>'])->hiddenInput();
							//			else:
							//				echo $form->field($model->organization, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img src="'.\Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot' . $model->organization->image), 200, 200, 'outbound', 0,
							//						Yii::getAlias('@webroot/uploads/cache/' . $model->organization->image)) .'" alt="" title="" data-placeholder="'.$placeholder.'" />{input}{error}{hint}</label></a>'])->hiddenInput();
							//			endif;
							//			?>
                        <!--            </section>-->
                        <!--        </div>-->
                        <!--    </fieldset>-->
                        <!--    <header>Контактная информация</header>-->
                        <!--    <fieldset>-->
                        <!--        <div class="row">-->
                        <!--            <section class="col col-6">-->
                        <!--                <section class="col-xs-10 col-sm-10 col-lg-11">-->
							<!--				--><?//=$form->field($model->organization, 'address', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-home"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Адресс огранизации']) ?>
                        <!--                </section>-->
                        <!--                <section class="col-xs-10 col-sm-10 col-lg-11">-->
							<!--				--><?//=$form->field($model->organization, 'working_days', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-briefcase"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Понедельник-Пятница']) ?>
                        <!--                </section>-->
                        <!--                <section class="col-xs-10 col-sm-10 col-lg-11">-->
							<!--				--><?//=$form->field($model->organization, 'working_hours', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-clock-o"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => '9:00 - 21:00']) ?>
                        <!--                </section>-->
                        <!--                <section class="col-xs-10 col-sm-10 col-lg-11">-->
							<!--				--><?//=$form->field($model->organization, 'lunch_time', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-clock-o"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => '13:00 - 14:00']) ?>
                        <!--                </section>-->
                        <!--                <section class="col-xs-10 col-sm-10 col-lg-11">--><?//=$model->telephones->getAttributeLabel('number')?>
							<!--				--><?//=$form->field($model->telephones, 'numbers', ['template' => '<label class="input">{input}</label>'])->widget(MultipleInput::className(), [
							//						'min'               => 1,
							//						'allowEmptyList'    => false,
							//						'sortable'    => false,
							//						'enableGuessTitle'  => true,
							//						'columns' => [
							//							[
							//								'name'  => 'numbers',
							//								'type'  => \yii\widgets\MaskedInput::className(),
							//								'options' => [
							//									'mask' => '+9999-999-9999'
							//								],
							//								'headerOptions' => [
							//									'style' => 'background: none;'
							//								]
							//							],
							//						],
							//						'addButtonOptions'  => [
							//							'class' => 'btn btn-primary btn-sm',
							//							'label' => Html::tag('i', null, ['class' => 'fa fa-plus-circle'])
							//						],
							//						'removeButtonOptions'  => [
							//							'class' => 'btn btn-danger btn-sm',
							//							'label' => Html::tag('i', null, ['class' => 'fa fa-minus-circle'])
							//						],
							//						'addButtonPosition' => MultipleInput::POS_ROW // show add button in the header
							//					])->label(false);?>
                        <!--                </section>-->
                        <!--            </section>-->
                        <!--            <section class="col col-6">-->
                        <!--                <section>-->
							<!--				--><?//=$form->field($model->organization, 'url', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-link"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Сайт организации']) ?>
                        <!--                </section>-->
                        <!--                <section>-->
							<!--				--><?//=$form->field($model->organization, 'url_vk', ['template' => '<label class="input"><i class="icon-prepend fa fa-vk"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://vk.com']) ?>
                        <!--                </section>-->
                        <!--                <section>-->
							<!--				--><?//=$form->field($model->organization, 'url_ok', ['template' => '<label class="input"><i class="icon-prepend fa fa-odnoklassniki"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://ok.ru']) ?>
                        <!--                </section>-->
                        <!--                <section>-->
							<!--				--><?//=$form->field($model->organization, 'url_facebook', ['template' => '<label class="input"><i class="icon-prepend fa fa-facebook"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://facebook.com']) ?>
                        <!--                </section>-->
                        <!--                <section>-->
							<!--				--><?//=$form->field($model->organization, 'url_instagram', ['template' => '<label class="input"><i class="icon-prepend fa fa-instagram"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://instagram.com']) ?>
                        <!--                </section>-->
                        <!--                <section>-->
							<!--				--><?//=$form->field($model->organization, 'url_twitter', ['template' => '<label class="input"><i class="icon-prepend fa fa-twitter"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://twitter.com']) ?>
                        <!--                </section>-->
                        <!--            </section>-->
                        <!--        </div>-->
                        <!--    </fieldset>-->
                        <!--    <footer>-->
							<!--	--><?//= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                        <!--    </footer>-->
							<?php //ActiveForm::end(); ?>
                        <!--</div>-->
                    </div>
                </div>
            </article>
        </div>
    </section>

</div>

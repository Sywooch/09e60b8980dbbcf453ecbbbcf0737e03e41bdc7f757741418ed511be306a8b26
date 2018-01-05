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

$this->title = 'Редактирование организации: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактирование организации', 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="organizations-update">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-dedent"></i> Организации <span>&gt; Редактирование организации</span></h1>
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
                                            <?= $form->field($model, 'name', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-briefcase"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Название организации']) ?>
                                        </section>
                                        <section>
                                            <?= $form->field($model, 'description', ['template' => '{label} <label class="textarea"><i class="icon-prepend fa fa-info"></i>{input}{error}{hint}</label>'])->textarea(['rows' => 6, 'placeholder' => 'Информация об организации']) ?>
                                        </section>
                                    </section>
                                    <section class="col col-6 text-align-center">
                                        <?
                                        if ($model->isNewRecord || empty($model->image)):
                                            echo $form->field($model, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img style="width: 80%;"   src="' . $placeholder . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
                                        else:
                                            echo $form->field($model, 'image', ['template' => '{label} <label class="input" id="images"><a href="" id="thumb-image0" data-toggle="image"><img style="width: 80%;"   src="' . \Yii::$app->imageresize->getUrl(Yii::getAlias($model->image), 320, 180, 'outbound', 100, Yii::getAlias('/uploads/cache/' . $model->image)) . '" alt="" title="" data-placeholder="' . $placeholder . '" />{input}{error}{hint}</label></a>'])->hiddenInput();
                                        endif;
                                        ?>
                                    </section>
                                </div>

                                <div class="row">
                                    <section class="col col-6">
                                        <section>
                                            <div class="form-group">
                                                <?=
                                                $form->field($model, 'category_id', ['template' => '<label class="input">{input}{error}{hint}</label>'])->widget(TreeViewInput::classname(), [
                                                    'name' => 'category_list',
                                                    'value' => 'true', // preselected values
                                                    'query' => Category::find()->andWhere(['active' => true])->addOrderBy('root, lft'),
                                                    'headingOptions' => ['label' => 'Категории'],
                                                    'rootOptions' => ['label' => '<i class="fa fa-tree text-success"></i>'],
                                                    'fontAwesome' => true,
                                                    'asDropdown' => false,
                                                    'multiple' => true,
                                                    'options' => ['disabled' => false]
                                                ]);
                                                ?>
                                            </div>
                                        </section>

                                    </section>
                                    <section class="col col-6">


                                        <section>
<?= $form->field($model, 'url', ['template' => '{label} <label class="input"><i class="icon-prepend fa fa-link"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'Сайт организации']) ?>
                                        </section>
                                        <section>
<?= $form->field($model, 'url_vk', ['template' => '<label class="input"><i class="icon-prepend fa fa-vk"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://vk.com']) ?>
                                        </section>
                                        <section>
<?= $form->field($model, 'url_ok', ['template' => '<label class="input"><i class="icon-prepend fa fa-odnoklassniki"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://ok.ru']) ?>
                                        </section>
                                        <section>
<?= $form->field($model, 'url_facebook', ['template' => '<label class="input"><i class="icon-prepend fa fa-facebook"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://facebook.com']) ?>
                                        </section>
                                        <section>
<?= $form->field($model, 'url_instagram', ['template' => '<label class="input"><i class="icon-prepend fa fa-instagram"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://instagram.com']) ?>
                                        </section>
                                        <section>
<?= $form->field($model, 'url_twitter', ['template' => '<label class="input"><i class="icon-prepend fa fa-twitter"></i>{input}{error}{hint}</label>'])->textInput(['maxlength' => true, 'placeholder' => 'http://twitter.com']) ?>
                                        </section>

                                        <section class="col-xs-12 col-sm-12 col-lg-12">
                                            <?= $telephones->getAttributeLabel('number') ?>
                                            <?=
                                            $form->field($model, 'telephones', ['template' => '<label class="input">{input}</label>'])->widget(MultipleInput::className(), [
                                                'min' => 1,
                                                'allowEmptyList' => false,
                                                'sortable' => false,
                                                'enableGuessTitle' => true,
                                                'columns' => [
                                                    [
                                                        'name' => 'number',
                                                        'type' => \yii\widgets\MaskedInput::className(),
                                                        'options' => [
                                                            'mask' => '+9999-999-9999'
                                                        ],
                                                    ],
                                                ],
                                                'addButtonOptions' => [
                                                    'class' => 'btn btn-primary btn-sm',
                                                    'label' => Html::tag('i', null, ['class' => 'fa fa-plus-circle'])
                                                ],
                                                'removeButtonOptions' => [
                                                    'class' => 'btn btn-danger btn-sm',
                                                    'label' => Html::tag('i', null, ['class' => 'fa fa-minus-circle'])
                                                ],
                                                'addButtonPosition' => MultipleInput::POS_ROW // show add button in the header
                                            ])->label(false);
                                            ?>
                                        </section>

                                    </section>
                                </div>
                            </fieldset>
                            <header>Контактная информация</header>
                            <fieldset>
                                <section>
                                    <?=
                                    $form->field($model, 'addresses', ['template' => '<label class="input">{input}</label>'])->widget(MultipleInput::className(), [
                                        'min' => 1,
                                        'allowEmptyList' => false,
                                        'sortable' => false,
                                        'enableGuessTitle' => true,
                                        'columns' => [
                                            [
                                                'name' => 'address',
                                                'title' => 'Адресс',
                                                'options' => [
                                                    'placeholder' => 'Адресс огранизации'
                                                ],
                                            ],
                                            [
                                                'name' => 'working_days',
                                                'title' => 'Рабочие дни',
                                                'options' => [
                                                    'placeholder' => 'Пн-Пт'
                                                ],
                                            ],
                                            [
                                                'name' => 'weekend',
                                                'title' => 'Выходные дни',
                                                'options' => [
                                                    'placeholder' => 'Вс'
                                                ],
                                            ],
                                            [
                                                'name' => 'working_hours',
                                                'title' => 'Время работы',
                                                'options' => [
                                                    'placeholder' => '9:00 - 21:00'
                                                ],
                                            ],
                                            [
                                                'name' => 'lunch_time',
                                                'title' => 'Время обеда',
                                                'options' => [
                                                    'placeholder' => '13:00 - 14:00'
                                                ],
                                            ],
                                            [
                                                'name' => 'latitude',
                                                'title' => 'Долгота',
                                            ], [
                                                'name' => 'longitude',
                                                'title' => 'Широта',
                                            ],
                                        ],
                                        'addButtonOptions' => [
                                            'class' => 'btn btn-primary btn-sm',
                                            'label' => Html::tag('i', null, ['class' => 'fa fa-plus-circle'])
                                        ],
                                        'removeButtonOptions' => [
                                            'class' => 'btn btn-danger btn-sm',
                                            'label' => Html::tag('i', null, ['class' => 'fa fa-minus-circle'])
                                        ],
                                        'addButtonPosition' => MultipleInput::POS_ROW // show add button in the header
                                    ])->label(false);
                                    ?>
                                </section>
                            </fieldset>
                            <footer>
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                            </footer>
<?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>


</div>

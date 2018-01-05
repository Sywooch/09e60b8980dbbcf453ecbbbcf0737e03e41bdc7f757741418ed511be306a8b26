<?php
	/* @var $this \yii\web\View */
	/* @var $content string */
	use app\widgets\Alert;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\Breadcrumbs;

	# Start page
	$this->title = 'Города - Панель администратора';
	###############################
	#   CSS FILES
	###############################
	$this->registerCssFile($this->theme->getUrl('css/bootstrap.min.css'));
	$this->registerCssFile($this->theme->getUrl('css/font-awesome.min.css'));
	$this->registerCssFile($this->theme->getUrl('css/production-plugins.min.css'));
	$this->registerCssFile($this->theme->getUrl('css/production.min.css'));
	$this->registerCssFile($this->theme->getUrl('css/skins.min.css'));
	$this->registerCssFile($this->theme->getUrl('css/rtl.min.css'));
	# Custom admin styles
	$this->registerCssFile($this->theme->getUrl('css/your_style.css'));
	# Demo styles
	$this->registerCssFile($this->theme->getUrl('css/demo.min.css'));
	###############################
	#   JS PLUGINS FILES
	###############################
	$this->registerJsFile($this->theme->getUrl('js/libs/jquery-2.1.1.min.js'), ['position' => \yii\web\View::POS_END]);
	$this->registerJsFile($this->theme->getUrl('js/libs/jquery-ui-1.11.4.min.js'), ['position' => \yii\web\View::POS_END]);
	//$this->registerJsFile($this->theme->getUrl('js/libs/jquery.mobile-1.4.5.min.js'), ['position' => \yii\web\View::POS_END]);
	# IMPORTANT: APP CONFIG
	$this->registerJsFile($this->theme->getUrl('js/app.config.js'), ['position' => \yii\web\View::POS_END]);
	# JS TOUCH : include this plugin for mobile drag / drop touch events
	$this->registerJsFile($this->theme->getUrl('js/plugin/jquery-touch/jquery.ui.touch-punch.min.js'), ['position' => \yii\web\View::POS_END]);
	# BOOTSTRAP JS
	$this->registerJsFile($this->theme->getUrl('js/bootstrap/bootstrap.min.js'), ['position' => \yii\web\View::POS_END]);
	# CUSTOM NOTIFICATION
	$this->registerJsFile($this->theme->getUrl('js/notification/SmartNotification.min.js'), ['position' => \yii\web\View::POS_END]);
	# JARVIS WIDGETS
	$this->registerJsFile($this->theme->getUrl('js/smartwidgets/jarvis.widget.min.js'), ['position' => \yii\web\View::POS_END]);
	# EASY PIE CHARTS
	$this->registerJsFile($this->theme->getUrl('js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js'), ['position' => \yii\web\View::POS_END]);
	# SPARKLINES
	$this->registerJsFile($this->theme->getUrl('js/plugin/sparkline/jquery.sparkline.min.js'), ['position' => \yii\web\View::POS_END]);
	# JQUERY: VALIDATE
	$this->registerJsFile($this->theme->getUrl('js/plugin/jquery-validate/jquery.validate.min.js'), ['position' => \yii\web\View::POS_END]);
	# JQUERY: MASKED INPUT
	$this->registerJsFile($this->theme->getUrl('js/plugin/masked-input/jquery.maskedinput.min.js'), ['position' => \yii\web\View::POS_END]);
	# JQUERY: SELECT2 INPUT
	$this->registerJsFile($this->theme->getUrl('js/plugin/select2/select2.min.js'), ['position' => \yii\web\View::POS_END]);
	# JQUERY UI + Bootstrap Slider
	$this->registerJsFile($this->theme->getUrl('js/plugin/bootstrap-slider/bootstrap-slider.min.js'), ['position' => \yii\web\View::POS_END]);
	# Browser msie issue fix
	$this->registerJsFile($this->theme->getUrl('js/plugin/msie-fix/jquery.mb.browser.min.js'), ['position' => \yii\web\View::POS_END]);
	# FastClick: For mobile devices: you can disable this in app.js
	$this->registerJsFile($this->theme->getUrl('js/plugin/fastclick/fastclick.min.js'), ['position' => \yii\web\View::POS_END]);

	# MAIN APP JS FILE
	$this->registerJsFile($this->theme->getUrl('js/app.js'), ['position' => \yii\web\View::POS_END]);
	$this->registerJsFile($this->theme->getUrl('js/admin.js'), ['position' => \yii\web\View::POS_END]);
	$this->registerJsFile($this->theme->getUrl('js/demo.min.js'), ['position' => \yii\web\View::POS_END]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" id="">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="<?= $this->theme->getUrl('img/favicon/favicon.ico') ?>" type="image/x-icon">
    <link rel="icon" href="<?= $this->theme->getUrl('img/favicon/favicon.ico') ?>" type="image/x-icon">
    <!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
</head>
<body>
    <div id="preloader"></div>
    <?php $this->beginBody() ?>
    <header id="header">
        <div id="logo-group">
            <a href="/">
                <span id="logo"> <img src="<?= $this->theme->getUrl('img/logo.png') ?>" alt=""></span>
                Города
            </a>
        </div>
        <div class="pull-right">
            <div id="logout" class="btn-header transparent pull-right">
                <span> <a href="<?=Url::toRoute('/logout')?>" title="Выйти" data-action="userLogout" data-logout-msg="Вы уверены что хотите выйти из панели администрирования?"><i class="fa fa-sign-out"></i></a> </span>
            </div>
            <div id="hide-menu" class="btn-header pull-right">
                <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Скрыть/Показать меню"><i class="fa fa-reorder"></i></a> </span>
            </div>
            <div id="fullscreen" class="btn-header pull-right">
                <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Полноэкранный режим"><i class="fa fa-arrows-alt"></i></a> </span>
            </div>
            <div id="settings" class="btn-header transparent pull-right">
                <span> <a href="<?=Url::toRoute('/settings')?>" data-tooltip="Настройки"><i class="fa fa-cogs"></i></a> </span>
            </div>
            <ul class="header-dropdown-list hidden">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?= $this->theme->getUrl('img/blank.gif') ?>" class="flag flag-ru" alt="Russia"> <span> RU</span> <i class="fa fa-angle-down"></i> </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="#"><img src="<?= $this->theme->getUrl('img/blank.gif') ?>" class="flag flag-us" alt="United States"> English (US)</a>
                        </li>
                        <li class="active">
                            <a href="#"><img src="<?= $this->theme->getUrl('img/blank.gif') ?>" class="flag flag-ru" alt="Russia"> Русский язык</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>
    <aside id="left-panel">
        <!-- User info -->
        <div class="login-info">
            <span>
                <!-- User image size is adjusted inside CSS, it should stay as is -->
                <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                    <img src="<?= $this->theme->getUrl('img/avatars/male.png') ?>" alt="me" class="online">
                    <span><?=Yii::$app->user->identity->account_name?></span>
                </a>
            </span>
        </div>
        <!-- end user info -->
        <!-- NAVIGATION -->
        <nav>
            <ul>
                <li>
                    <a href="<?=Url::toRoute('/')?>" title="Главная"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Главная</span></a>
                </li>
                <li>
                    <a href="#" title="Новости"><i class="fa fa-lg fa-fw fa-file-text-o"></i>
                        <span class="menu-item-parent">Новости</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                    <ul>
                        <li><a href="<?=Url::toRoute('/news')?>"><i class="fa fa-list"></i> Все </a></li>
                        <li><a href="<?=Url::toRoute('/news/add')?>"><i class="fa fa-plus"></i> Добавить </a></li>
                        <li><a href="<?=Url::toRoute('/news/index/type/new')?>"><i class="fa fa-file-text"></i> Входящие </a></li>
                        <li><a href="<?=Url::toRoute('/news/category/index')?>"><i class="fa fa-dedent"></i> Разделы </a></li>
                    </ul>
                </li>
<!--                <li>
                    <a href="#" title="Пользователи"><i class="fa fa-lg fa-fw fa-users"></i>
                        <span class="menu-item-parent">Пользователи</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                    <ul>
                        <li><a href="<?=Url::toRoute('/users')?>"><i class="fa fa-list"></i> Все </a></li>
                        <li><a href="<?=Url::toRoute('/users/create')?>"><i class="fa fa-plus"></i> Добавить нового </a></li>
                    </ul>
                </li>-->
                <li>
                    <a href="#" title="Организации"><i class="fa fa-lg fa-fw fa-universal-access"></i>
                        <span class="menu-item-parent">Организации</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                    <ul>
                        <li><a href="<?=Url::toRoute('/organizations')?>"><i class="fa fa-list"></i> Организации </a></li>
                        <li><a href="<?=Url::toRoute('/organizations/create')?>"><i class="fa fa-plus"></i> Добавить новую </a></li>
                        <li><a href="<?=Url::toRoute('/organizations/category/index')?>"><i class="fa fa-dedent"></i> Категирии </a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/admins')?>" title="Администраторы"><i class="fa fa-lg fa-fw fa-user-secret"></i>
                        <span class="menu-item-parent">Администраторы</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/shares')?>" title="Акции"><i class="fa fa-lg fa-fw fa-percent"></i>
                        <span class="menu-item-parent">Акции</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/poster')?>" title="Афиши"><i class="fa fa-lg fa-fw fa-television"></i>
                        <span class="menu-item-parent">Афиши</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/filters')?>" title="Фильтры"><i class="fa fa-lg fa-fw fa-filter"></i>
                        <span class="menu-item-parent">Фильтры</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/communication')?>" title="Общение/Объявления"><i class="fa fa-lg fa-fw fa-comment-o"></i>
                        <span class="menu-item-parent">Общение/Объявления</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/buttons')?>" title="Кнопки"><i class="fa fa-lg fa-fw fa-check-circle"></i>
                        <span class="menu-item-parent">Кнопки</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/ads')?>" title="Объявления"><i class="fa fa-lg fa-fw fa-server"></i>
                        <span class="menu-item-parent">Объявления</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/advertising')?>" title="Реклама"><i class="fa fa-lg fa-fw fa-bullhorn"></i>
                        <span class="menu-item-parent">Реклама</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/advertising_banner')?>" title="Баннерная реклама"><i class="fa fa-lg fa-fw fa-bullhorn"></i>
                        <span class="menu-item-parent">Баннерная реклама</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/notice')?>" title="Пуш-уведомление"><i class="fa fa-lg fa-fw fa-envelope-o"></i>
                        <span class="menu-item-parent">Пуш-уведомление</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/settings')?>" title="Настройки"><i class="fa fa-lg fa-fw fa-cogs"></i>
                        <span class="menu-item-parent">Настройки</span><span class="badge pull-right inbox-badge margin-right-13 bg-color-yellow"></span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::toRoute('/help')?>" title="Помощь"><i class="fa fa-lg fa-fw fa-question-circle"></i> <span class="menu-item-parent">Помощь</span></a>
                </li>
            </ul>
        </nav>
        <span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>
    </aside>
    <div id="main" role="main">
        <!-- RIBBON -->
        <div id="ribbon">
            <!-- breadcrumb -->
            <?= Breadcrumbs::widget([
                'tag' => 'ol',
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <!-- end breadcrumb -->
        </div>
        <!-- END RIBBON -->
        <!-- MAIN CONTENT -->
        <div id="content">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
        <!-- END MAIN -->
    </div>
    <div class="page-footer">
        <div class="row">
            <div class="col-xs-12 col-sm-6"><span class="txt-color-white">Города <span class="hidden-xs"> - система управления API/Manager</span> © 2017 - 2018</span></div>
            <div class="col-xs-6 col-sm-6 text-right hidden-xs"></div>
        </div>
    </div>
    <?php $this->endBody() ?>
    <!--[if IE 8]>
        <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
    <![endif]-->
</body>
</html>
<?php $this->endPage() ?>





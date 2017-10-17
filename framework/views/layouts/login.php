<?php
	/* @var $this \yii\web\View */
	/* @var $content string */
	use app\assets\AppAsset;
	use app\widgets\Alert;
	use yii\helpers\Html;

	AppAsset::register($this);

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
	$this->registerJsFile($this->theme->getUrl('js/libs/jquery-ui-1.10.3.min.js'), ['position' => \yii\web\View::POS_END]);
	# IMPORTANT: APP CONFIG
	$this->registerJsFile($this->theme->getUrl('js/app.config.js'), ['position' => \yii\web\View::POS_END]);
	# BOOTSTRAP JS
	$this->registerJsFile($this->theme->getUrl('js/bootstrap/bootstrap.min.js'), ['position' => \yii\web\View::POS_END]);
	# CUSTOM NOTIFICATION
	$this->registerJsFile($this->theme->getUrl('js/notification/SmartNotification.min.js'), ['position' => \yii\web\View::POS_END]);
	# MAIN APP JS FILE
	$this->registerJsFile($this->theme->getUrl('js/app.js'), ['position' => \yii\web\View::POS_END]);
	$this->registerJsFile($this->theme->getUrl('js/admin.js'), ['position' => \yii\web\View::POS_END]);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" id="extr-page">
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
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
</head>
<body>
    <?php $this->beginBody() ?>
    <header id="header">
        <div id="logo-group">
            <a href="/">
                <span id="logo"> <img src="<?= $this->theme->getUrl('img/logo.png') ?>" alt=""></span>
                Города
            </a>
        </div>
    </header>

    <div id="main" role="main">
        <!-- #MAIN CONTENT -->
        <div id="content" class="container">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <?php $this->endBody() ?>
    <!--[if IE 8]>
    <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
    <![endif]-->
</body>
</html>
<?php $this->endPage() ?>





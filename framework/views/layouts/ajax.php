<?php
	/********************************
	 * Created by GoldenEye.
	 * email : slims.alex@gmail.com
	 * WEB: http://scriptsweb.ru
	 * copyright 2016 - 2016
	 ********************************/
	/* @var $this \yii\web\View */
	/* @var $content string */
	use yii\bootstrap\Alert;
	use yii\widgets\Breadcrumbs;

?>

<!-- RIBBON -->
<div id="ribbon">
		<span class="ribbon-button-alignment">
			<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh" rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true"
			      data-reset-msg="Would you like to RESET all your saved widgets and clear LocalStorage?"><i class="fa fa-refresh"></i></span>
		</span>
	<!-- breadcrumb -->
	<ol class="breadcrumb">
	</ol>
	<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]) ?>

	<!-- end breadcrumb -->
</div>
<!-- END RIBBON -->
<!-- #MAIN CONTENT -->
<div id="content" style="opacity: 1;">
	<?//= Alert::widget() ?>
	<?= $content ?>
</div>


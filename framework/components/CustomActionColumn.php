<?php
	/********************************
	 * Created by GoldenEye.
	 * ICQ 285652 / email : slims.alex@gmail.com
	 * WEB: http://scriptsweb.ru
	 * copyright 2010 - 2017
	 ********************************/

namespace app\components;

use yii\grid\ActionColumn;
use yii\helpers\Html;

class CustomActionColumn extends ActionColumn
{
	protected function renderFilterCellContent()
	{
		return Html::a('Сброс', ['index'], ['class' => 'btn btn-primary']);
	}
}


<?php
namespace app\modules\v1\controllers;

use app\modules\buttons\models\Buttons;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;


class ButtonsController extends Controller
{
	public function __construct($id, Module $module, array $config = [])
	{
		# Default status code and response
		\Yii::$app->response->setStatusCode(200);
		\Yii::$app->response->format = Response::FORMAT_JSON;
		parent::__construct($id, $module, $config);
	}

	public function actionIndex()
	{
		$query = Buttons::find()
			->select(['id','title','url','telephone','image','section','section_id'])
			->where(['published' => Buttons::STATUS_ACTIVE]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'order' => SORT_ASC,
				]
			]
		]);
		return $dataProvider;
	}
}

<?php
namespace app\modules\v1\controllers;

use app\modules\advertising\models\Advertising;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;


class AdvertisingController extends Controller
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
		$query = Advertising::find();
		//$query->andFilterWhere(['category_id' => Yii::$app->request->getBodyParam('category_id')] );
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		return $dataProvider;

	}
}

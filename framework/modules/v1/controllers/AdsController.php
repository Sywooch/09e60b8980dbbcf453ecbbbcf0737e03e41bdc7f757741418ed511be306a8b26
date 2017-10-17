<?php
namespace app\modules\v1\controllers;

use app\modules\ads\models\Ads;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;


class AdsController extends Controller
{
	public $layout = false;
	public $user = null;

	public function __construct($id, Module $module, array $config = [])
	{
		# Default status code and response
		\Yii::$app->response->setStatusCode(555);
		\Yii::$app->response->format = Response::FORMAT_JSON;
		parent::__construct($id, $module, $config);
	}

	public function actionIndex()
	{
		$query = Ads::find()->where(['status' => Ads::STATUS_ACTIVE]);
		$query->andFilterWhere(['category_id' => Yii::$app->request->getBodyParam('category_id')] );
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'pin_filter' => SORT_DESC,
					'pin_main' => SORT_DESC,
				]
			],
			'pagination' => [
				'pageSize' => 10,
				'page' => Yii::$app->request->getBodyParam('page', 1) -1
			]
		]);
		return $dataProvider;
	}
}
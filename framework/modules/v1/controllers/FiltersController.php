<?php
namespace app\modules\v1\controllers;

use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;
use app\modules\filters\models\Filters;

class FiltersController extends Controller
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
		$query = Filters::find()->where(['published' => Filters::STATUS_ACTIVE]);
		$query->andFilterWhere(['category_id' => Yii::$app->request->getBodyParam('category_id')] );
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'parent_id' => SORT_ASC,
				]
			],
			//'pagination' => [
			//	'pageSize' => 2,
			//	'page' => Yii::$app->request->getBodyParam('page', 1) -1
			//]
		]);
		return $dataProvider;
	}
}
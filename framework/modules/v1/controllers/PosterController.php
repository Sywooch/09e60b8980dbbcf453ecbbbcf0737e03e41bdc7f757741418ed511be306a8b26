<?php
namespace app\modules\v1\controllers;

use app\modules\poster\models\Poster;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;


class PosterController extends Controller
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
		$query = Poster::find()
			->where(['published' => Poster::STATUS_ACTIVE])
			->andWhere('end_at >= CURDATE()');
		$query->andFilterWhere(['category_id' => Yii::$app->request->getBodyParam('category_id')] );
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'pin_filter' => SORT_DESC,
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

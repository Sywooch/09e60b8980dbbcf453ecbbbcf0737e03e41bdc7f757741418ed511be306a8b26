<?php
namespace app\modules\v1\controllers;

use app\modules\shares\models\Shares;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\Response;


class SharesController extends Controller
{
	public $layout = false;
	public $user = null;

	public function __construct($id, Module $module, array $config = [])
	{
		# Default status code and response
		\Yii::$app->response->setStatusCode(200);
		\Yii::$app->response->format = Response::FORMAT_JSON;
		parent::__construct($id, $module, $config);
	}

	public function actionIndex()
	{
		$query = Shares::find()
			->where(['published' => Shares::STATUS_ACTIVE])
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

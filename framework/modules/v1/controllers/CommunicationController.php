<?php
namespace app\modules\v1\controllers;

use app\models\Clients;
use app\modules\communication\models\Comments;
use app\modules\communication\models\Communication;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\Response;


class CommunicationController extends Controller
{
	/**
	 * @var Clients
	 */
	public $user;

	public function __construct($id, Module $module, array $config = [])
	{
		# Default status code and response
		\Yii::$app->response->setStatusCode(555);
		\Yii::$app->response->format = Response::FORMAT_JSON;
		parent::__construct($id, $module, $config);
	}

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['index', 'view'],
						'allow' => true,
						'roles' => ['@'],
					],
					[
						'allow' => true,
						'matchCallback' => function () {
							return $this->user = Clients::isLogin();
						}
					],
				],
				'denyCallback' => function (/*$rule, $action*/) {
					\Yii::$app->response->setStatusCode(403);
					echo 'Вы должны быть авторизаированы!';
				}

			]
		];

	}


	public function actionIndex()
	{
		$query = Communication::find()->with('user','commentsCount')
		->where(['{{communication}}.status' => Communication::STATUS_ACTIVE])->asArray();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'pin' => SORT_DESC,
					'created_at' => SORT_DESC,
				]
			],
			'pagination' => [
				'pageSize' => 10,
				'page' => Yii::$app->request->getBodyParam('page', 1) -1
			]
		]);
		\Yii::$app->response->setStatusCode(200);
		return $dataProvider;
	}


	public function actionView($id)
	{
		$query = Communication::find()->with('comments')
			->where(['{{communication}}.status' => Communication::STATUS_ACTIVE])
		->andWhere(['id' => $id])->asArray();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'pin' => SORT_DESC,
					'created_at' => SORT_DESC,
				]
			]
		]);
		\Yii::$app->response->setStatusCode(200);
		return $dataProvider;
	}


	public function actionNew(){

		if ($this->user->block_publication)
			return 'Вам запрещено совершать публикации.';

		$model = new Communication();
		if ($model->load(['Communication' => Yii::$app->request->post()])) {
			$model->user_id = $this->user->id;
			$model->save();

			\Yii::$app->response->setStatusCode(200);
			return 'Отправлено на модерацию.';
		}else
			return implode(', ', $model->getFirstErrors());

	}

	public function actionUpdate($id){
		$model = Communication::findOne(['id' => Yii::$app->request->getBodyParam('comm_id'), 'user_id' => $this->user->id]);
		if (!is_null($model)) {
			$model->load(['Communication' => Yii::$app->request->post()]);
			$model->status = $model::STATUS_NEW;
			$model->update();
			\Yii::$app->response->setStatusCode(200);
			return 'Отправлено на модерацию.';
		}else
			return 'Пост не найден, или Вы не являетесь его владельцем.';

	}

	public function actionComment($id){

		if ($this->user->block_publication)
			return 'Вам запрещено добавлять комментарий.';

		$model = new Comments();
		if ($model->load(['Comments' => Yii::$app->request->post()])) {
			$model->user_id = $this->user->id;
			$model->comm_id = $id;
			if ($model->validate() && $model->save()) {
				\Yii::$app->response->setStatusCode(200);
				return 'Ваш комментарий отправлен на модерацию';
			}else
				return implode(', ', $model->getFirstErrors());
		}else
			return 'Ошибка получения данных!';
	}
}

<?php
namespace app\modules\v1\controllers;

use app\models\Clients;
use app\modules\organizations\models\Category;
use app\modules\organizations\models\Organizations;
use app\modules\organizations\models\OrganizationsImages;
use app\modules\organizations\models\OrganizationsTelephones;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\Response;


class OrganizationsController extends Controller
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
						'roles' => ['?'],
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
		$query = Organizations::find()->with(['addresses', 'telephones'])
			->where(['published' => Organizations::STATUS_ACTIVE])->asArray();

		if (Yii::$app->request->getBodyParam('category_id'))
			$query->andwhere('FIND_IN_SET( :category, category_id)')->addParams([':category' => Yii::$app->request->getBodyParam('category_id')]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'name' => SORT_ASC,
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
		$query = Organizations::find()->with(['addresses', 'telephones'])
			->where(['published' => Organizations::STATUS_ACTIVE, 'id' => (int) $id])->asArray();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'name' => SORT_ASC,
				]
			],
		]);
		\Yii::$app->response->setStatusCode(200);
		return $dataProvider;
	}


	public function actionCategory()
	{
		return Category::find()
			->where(['active' => Category::STATUS_ACTIVE])
			->andWhere('id !=1 and lvl=1')->asArray()->all();
	}

	public function actionNew()
	{
		$model = new Organizations;
		$model->scenario = 'add_org';
		if ($model->load(['Organizations' => Yii::$app->request->post()]) && $model->save()) {
			\Yii::$app->response->setStatusCode(200);
			return 'Ваша заявка принята.';
		}else
			return implode(', ', $model->getFirstErrors());
	}
}

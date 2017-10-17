<?php
namespace app\modules\v1\controllers;

use app\models\Clients;
use app\modules\news\models\Comments;
use app\modules\news\models\Data;
use app\modules\news\models\NewsImage;
use app\modules\v1\models\UploadFiles;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\Response;
use app\modules\news\models\News;
use yii\web\UploadedFile;

class NewsController extends Controller
{
	/**
	 * @var Clients
	 */
	private $user;

	public function __construct($id, Module $module, array $config = [])
	{
		# Default status code and response
		\Yii::$app->response->setStatusCode(200);
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
		$query = News::find()->with('data')
			->where(['published' => News::STATUS_ACTIVE])
			->andwhere(['category_id' => 0])->asArray();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'type' => SORT_DESC,
					'created_at' => SORT_DESC,
				]
			],
			'pagination' => [
				'pageSize' => 5,
				'page' => Yii::$app->request->getBodyParam('page', 1) -1
			]
		]);
		return $dataProvider;
	}

	public function actionView($id){

		$query = News::find()->with('data','comments')
			->where(['published' => News::STATUS_ACTIVE, 'id' => (int) $id])
			->andwhere(['category_id' => 0])
			->asArray();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'type' => SORT_DESC,
					'created_at' => SORT_DESC,
				]
			],
			'pagination' => [
				'pageSize' => 5,
				'page' => Yii::$app->request->getBodyParam('page', 1) -1
			]
		]);
		return $dataProvider;

	}

	public function actionComment(){

		if ($this->user->block_publication)
			return 'Вам запрещено добавлять комментарий.';

		$model = new Comments();
		if ($model->load(['Comments' => Yii::$app->request->post()])) {
			$model->author = $this->user->first_name;
			if ($model->validate() && $model->save()) {
				\Yii::$app->response->setStatusCode(200);
				return 'Ваш комментарий отправлен на модерацию';
			}else
				return implode(', ', $model->getFirstErrors());
		}else
			return 'Ошибка получения данных!';
	}


	public function actionNew(){

		if ($this->user->block_publication)
			return 'Вам запрещено публиковать новости.';

		$model = new News();
		if ($model->load(['News' => Yii::$app->request->post()])) {
			$model->created_author = $this->user->first_name.' '. $this->user->last_name;
			if ($model->validate() && $model->save() ) {
				# Upload news images
				$images = new UploadFiles();
				$images->image = UploadedFile::getInstancesByName('image');
				if ($images->image && $images->validate()) {
					$dir = 'uploads/news/';
					foreach ($images->image as $file) {
						$file_link = $dir . $model->id.'_'.$this->user->id.'_'.time(). '.' . $file->extension;
						$file->saveAs($file_link);
						# Save image to news
						$NewsImage = new NewsImage();
						$NewsImage->image = $file_link;
						$NewsImage->news_id = $model->id;
						$NewsImage->save();
					}
					# Save data
					foreach (Yii::$app->params['languages'] as $lang => $name) {
						$Data = new Data();
						$Data->load(['Data' => Yii::$app->request->post()]);
						$Data->nid = $model->id;
						$Data->language = $lang;
						$Data->save();
					}
					\Yii::$app->response->setStatusCode(200);
					return 'Ваша новость отправлена на модерацию.';
				}
				else
				{
					News::deleteAll(['id' => $model->id]);
					return implode(', ', $images->getFirstErrors());
				}
			}
		}
		return implode(', ', $model->getFirstErrors());
	}



}

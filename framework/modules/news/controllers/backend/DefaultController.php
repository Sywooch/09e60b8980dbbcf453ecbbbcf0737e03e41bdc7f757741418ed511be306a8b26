<?php
	/********************************
	 * Created by GoldenEye.
	 * ICQ 285652 / email : slims.alex@gmail.com
	 * WEB: http://scriptsweb.ru
	 * copyright 2010 - 2015
	 ********************************/
	namespace app\modules\news\controllers\backend;

	use app\models\User;
	use app\modules\news\models\Comments;
	use app\modules\news\models\CommentsSearch;
	use app\modules\news\models\Data;
	use app\modules\news\models\News;
	use app\modules\news\models\NewsImage;
	use app\modules\news\models\NewsSearch;
	use app\modules\news\Module;
	use Yii;
	use yii\filters\AccessControl;
	use yii\web\Controller;

	class DefaultController extends Controller
	{
		public function behaviors()
		{
			return [
				'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'allow' => true,
							'roles' => ['@'],
							'matchCallback' => function () {
								return User::checkAccess('news');
							}
						],
					],
				],
			];
		}

		public function actionIndex($type = 'published')
		{
			$searchModel = new NewsSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $type);
			return $this->render('/index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'type' => $type]);
		}


		public function actionAdd()
		{
			$model = new News();
			if ($model->load(Yii::$app->request->post(), 'News')) {
				$model->scenario = 'insert';
				if ($model->validate()) {
					if ($model->save()) {
						# Save Image
						if (Yii::$app->request->post('news_image')){
							foreach (Yii::$app->request->post('news_image') as $id => $image) {
								$NewsImage = new NewsImage();
								$NewsImage->load(Yii::$app->request->post('news_image'), $id);
								$NewsImage->news_id = $model->id;
								$NewsImage->save();
							}
						}
						# Save data
						foreach (Yii::$app->params['languages'] as $lang => $name) {
							$Data = new Data();
							$Data->load(Yii::$app->request->post('Data'), $lang);
							$Data->nid = $model->id;
							$Data->language = $lang;
							$Data->save();
						}
						Yii::$app->session->setFlash('success', 'Новость успешно создана');
						return $this->redirect(['update', 'id' => $model->id]);
					} else {
						Yii::$app->session->setFlash('error', 'Не удалось создать новость');
					}
				}
			}
			#Defaults
			$placeholder = \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot/uploads/no_image.png'), 140, 100, 'inset', 100, Yii::getAlias('@webroot/uploads/cache/thumb-no_image.png'));
			$data = new Data();
			$images = new NewsImage();
			return $this->render('/form', [
				'model' => $model,
				'data' => $data,
				'images' => $images,
				'placeholder' => $placeholder,
			]);
		}

		public function actionUpdate($id)
		{
			$model = News::find()->with('image')->where('id = :id', [':id' => $id])->one();
			if (Yii::$app->request->post()) {
				$model = News::findOne($id);
				$model->load(Yii::$app->request->post(), 'News');
				# Save Image
				if (Yii::$app->request->post('news_image')){
					NewsImage::deleteAll('news_id = :id',[':id' => $model->id]);
					foreach (Yii::$app->request->post('news_image') as $id => $image) {
						$NewsImage = new NewsImage();
						$NewsImage->load(Yii::$app->request->post('news_image'), $id);
						$NewsImage->news_id = $model->id;
						$NewsImage->save();
					}
				}


				foreach (Yii::$app->params['languages'] as $lang => $name) {
					if (isset($model->data[$lang]))
						if ($model->data[$lang]->load(Yii::$app->request->post('Data'), $lang))
							$model->data[$lang]->update();
						else {
							$data = new Data();
							if ($data->load(Yii::$app->request->post('Data'), $lang)) {
								$data->language = $lang;
								$model->link('data', $data);
							}

						}
				}
				if ($model->update())
					Yii::$app->session->setFlash('success', 'Новость сохранена');
			}

			$placeholder = \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot/uploads/no_image.png'), 140, 100, 'inset', 100, Yii::getAlias('@webroot/uploads/cache/thumb-no_image.png'));
			return $this->render('/form', ['placeholder' => $placeholder, 'model' => $model, 'data' => new Data()]);

		}

		public function actionView($id)
		{
			Yii::$app->response->statusCode = 201;
			$model = News::findOne($id);

			if(is_null($model))
				return 'Новость не найдена';

			if (!is_null($model)) {
				$published = ($model->published == News::STATUS_ACTIVE ? News::STATUS_HIDDEN : News::STATUS_ACTIVE);
				$model->setAttribute('published', $published);
				if ($model->save()) {
					Yii::$app->response->statusCode = 200;
					Yii::$app->session->setFlash('success', Module::t('index', 'status.changed', array('id' => $id, 'published' => $model->getPublished($published))));
				}
			}
			return $this->redirect(Yii::$app->request->referrer);
		}

		public function actionDelete($id)
		{
			$model = News::findOne($id);
			if (!is_null($model)) {
				if (!empty($model->pic_url) && file_exists(Yii::getAlias("@webroot" . $model->pic_url)))
					unlink(Yii::getAlias("@webroot" . $model->pic_url));
				Data::deleteAll(['nid' => $model->id]);
				if ($model->delete()) {
					Yii::$app->session->setFlash('success', Module::t('index', 'status.deleted'), ['id' => $id]);
				}
			}
			return $this->redirect(Yii::$app->request->referrer);
		}

		public function actionComments()
		{
			$searchModel = new CommentsSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			return $this->render('/comments', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
		}

		public function actionCommentsUpdate($id)
		{
			Yii::$app->response->statusCode = 201;
			$model = Comments::findOne($id);

			if(is_null($model))
				return 'Данный коментарий не найден!';

			if ($model->status == Comments::STATUS_HIDDEN || $model->status == Comments::STATUS_NEW)
				$model->status = Comments::STATUS_ACTIVE;
			else
				$model->status = Comments::STATUS_HIDDEN;

			if ($model->save(false)) {
				Yii::$app->response->statusCode = 200;
				return 'Статус публикации успешно изменён.';
			} else {

				return join(',', $model->getFirstErrors());
			}
		}

		public function actionCommentsDelete($id)
		{
			$model = Comments::findOne($id);
			if (!is_null($model)) {
				if ($model->delete()) {
					Yii::$app->session->setFlash('success', Module::t('index', 'comment.deleted',['id' => $id]));
				}
			}
			return $this->redirect(Yii::$app->request->referrer);

		}
	}

<?php
	/********************************
	 * Created by GoldenEye.
	 * email : slims.alex@gmail.com
	 * WEB: http://scriptsweb.ru
	 * copyright 2016 - 2016
	 ********************************/

	namespace app\controllers;

    use app\models\ClientsSearch;
    use app\models\Clients;
    use app\models\User;
    use Yii;
	use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;

    class UsersController extends Controller
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
								return User::checkAccess('clients');
							}
						],
					],
				],
			];
		}

		public function actionIndex()
		{
            $searchModel = new ClientsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
            	'searchModel' =>$searchModel,
            	'dataProvider' => $dataProvider
            ]);
		}

	    /**
	     * Creates a new Clients model.
	     * If creation is successful, the browser will be redirected to the 'view' page.
	     * @return mixed
	     */
	    public function actionCreate()
	    {
		    $model = new Clients();
		    $model->scenario = 'insert';
		    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			    $model->salt = Yii::$app->security->generateRandomString() . '.' . time();
			    $model->setPassword($model->password);
			    $model->save();
			    return $this->redirect(['view', 'id' => $model->id]);
		    } else {
			    return $this->render('create', [
				    'model' => $model,
			    ]);
		    }
	    }

		public function actionView($id)
		{
			$model = Clients::findOne($id);
			if (is_null($model)) {
				Yii::$app->session->setFlash('error', 'Пользователь не найден!');
				return $this->redirect('index');
			}

			if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
				Yii::$app->session->setFlash('success', 'Пользователь обновлён!');
			}
			return $this->render('view', ['model' => $model]);
		}

	    /**
	     * Updates an existing Clients model.
	     * If update is successful, the browser will be redirected to the 'view' page.
	     * @param integer $id
	     * @return mixed
	     */
	    public function actionUpdate($id)
	    {
		    $model = $this->findModel($id);
		    if ($model->load(Yii::$app->request->post())) {
			    if(!empty($model->new_password)){
				    $model->setPassword($model->new_password);
			    }
			    $model->save();
			    return $this->redirect(['view', 'id' => $model->id]);
		    } else {
			    return $this->render('update', [
				    'model' => $model,
			    ]);
		    }
	    }
	    
	    /**
	     * Deletes an existing Clients model.
	     * If deletion is successful, the browser will be redirected to the 'index' page.
	     * @param integer $id
	     * @return mixed
	     */
	    public function actionDelete($id)
	    {
		    $model = $this->findModel($id);
		    $model->delete();
		    return $this->redirect(['index']);
	    }

	    /**
	     * Finds the Clients model based on its primary key value.
	     * If the model is not found, a 404 HTTP exception will be thrown.
	     * @param integer $id
	     * @return Clients the loaded model
	     * @throws NotFoundHttpException if the model cannot be found
	     */
	    protected function findModel($id)
	    {
		    if (($model = Clients::findOne($id)) !== null) {
			    return $model;
		    } else {
			    throw new NotFoundHttpException('The requested page does not exist.');
		    }
	    }
	    
	}
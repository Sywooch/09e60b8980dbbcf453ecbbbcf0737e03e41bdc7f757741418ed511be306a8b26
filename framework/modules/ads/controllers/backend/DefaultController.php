<?php

namespace app\modules\ads\controllers\backend;

use app\models\User;
use Yii;
use app\modules\ads\models\Ads;
use app\modules\ads\models\AdsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Ads model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
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
					        return User::checkAccess('ads');
				        }
			        ],
		        ],
	        ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ads models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ads model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
	    Yii::$app->response->statusCode = 201;
    	$model = $this->findModel(Yii::$app->request->post('id'));
    	if(!is_null($model))
	    {
		    if(Yii::$app->request->post('pin') == 'main')
		        $model->pin_main = Yii::$app->request->post('checked') == 'true' ? $model::STATUS_ACTIVE : $model::STATUS_DISABLE;
		    else
			    $model->pin_filter = Yii::$app->request->post('checked') == 'true' ? $model::STATUS_ACTIVE : $model::STATUS_DISABLE;

		    if ($model->save()){
			    Yii::$app->response->statusCode = 200;
			    return 'Все прошло успешно!';
		    }
		    return 'Что-то пошло не так, повторите попытку позже!';
	    }
	    return 'Объявление не найдено!';
    }

    /**
     * Creates a new Ads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ads();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
	    $model->status = $model::STATUS_DISABLE;
	    $model->save(false);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Ads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ads::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

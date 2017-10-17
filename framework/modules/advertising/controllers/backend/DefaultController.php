<?php

namespace app\modules\advertising\controllers\backend;

use app\models\User;
use Yii;
use app\modules\advertising\models\Advertising;
use app\modules\advertising\models\AdvertisingSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Advertising model.
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
					        return User::checkAccess('advertising');
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
     * Lists all Advertising models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$model = Advertising::find()->one();
		if (is_null($model))
			$model = new Advertising();

	    if ($model->load(Yii::$app->request->post()) && $model->save())
		    return $this->redirect(['index']);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    //Backup
    //public function actionIndex()
    //{
    //    $searchModel = new AdvertisingSearch();
    //    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //
    //    return $this->render('index', [
    //        'searchModel' => $searchModel,
    //        'dataProvider' => $dataProvider,
    //    ]);
    //}

    /**
     * Displays a single Advertising model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Advertising model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Advertising();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Advertising model.
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
     * Deletes an existing Advertising model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Advertising model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Advertising the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advertising::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

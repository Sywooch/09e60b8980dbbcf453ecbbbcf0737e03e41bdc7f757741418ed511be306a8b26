<?php

namespace app\modules\advertising_banner\controllers\backend;

use app\models\User;
use Yii;
use app\modules\advertising_banner\models\AdvertisingBanner;
use app\modules\advertising_banner\models\AdvertisingBannerSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for AdvertisingBanner model.
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
					        return User::checkAccess('advertising_banner');
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
     * Lists all AdvertisingBanner models.
     * @return mixed
     */
    public function actionIndex()
    {
	    $model = AdvertisingBanner::find()->one();
	    if (is_null($model))
		    $model = new AdvertisingBanner();

	    if ($model->load(Yii::$app->request->post()) && $model->save())
		    return $this->redirect(['index']);

	    #Defaults
	    $placeholder = \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot/uploads/no_image.png'), 140, 100, 'inset', 100, Yii::getAlias('@webroot/uploads/cache/thumb-no_image.png'));
	    return $this->render('index', [
		    'model' => $model,
		    'placeholder' => $placeholder,
	    ]);

    }

    /**
     * Displays a single AdvertisingBanner model.
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
     * Creates a new AdvertisingBanner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdvertisingBanner();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AdvertisingBanner model.
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
     * Deletes an existing AdvertisingBanner model.
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
     * Finds the AdvertisingBanner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdvertisingBanner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdvertisingBanner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

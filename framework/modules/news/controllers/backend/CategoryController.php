<?php

namespace app\modules\news\controllers\backend;

use app\models\User;
use Yii;
use app\modules\news\models\Category;
use app\modules\news\models\CategorySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
					        return User::checkAccess('news');
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
	public function actionView($id)
	{
		Yii::$app->response->statusCode = 201;
		$model = $this->findModel($id);

		if(is_null($model))
			return 'Раздел не найден';

		if (!is_null($model) && $model->id !== 0) {
			$published = ($model->published == Category::STATUS_ACTIVE ? Category::STATUS_DISABLE : Category::STATUS_ACTIVE);
			$model->setAttribute('published', $published);
			if ($model->save()) {
				Yii::$app->response->statusCode = 200;
				Yii::$app->session->setFlash('success', 'Успешно обновлен статус раздела');
			}
		}
		else
			Yii::$app->session->setFlash('error', 'Раздел "Новости" скрыть нельзя!');

		return $this->redirect(Yii::$app->request->referrer);
	}

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
	        #Defaults
	        $placeholder = \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot/uploads/no_image.png'), 320, 180, 'inset', 100, Yii::getAlias('@webroot/uploads/cache/thumb-no_image.png'));
	        return $this->render('create', [
                'model' => $model,
	            'placeholder' => $placeholder
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	    if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
		    #Defaults
		    $placeholder = \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot/uploads/no_image.png'), 320, 180, 'inset', 100, Yii::getAlias('@webroot/uploads/cache/thumb-no_image.png'));
		    return $this->render('update', [
                'model' => $model,
	            'placeholder' => $placeholder
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
	        if($model->id === 0)
		        Yii::$app->session->setFlash('error', 'Раздел "Новости" удалить нельзя!');
            else
		        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace app\modules\filters\controllers\backend;

use app\models\User;
use Yii;
use app\modules\filters\models\Filters;
use app\modules\filters\models\FiltersSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FiltersController implements the CRUD actions for Filters model.
 */
class DefaultController extends Controller {

  /**
   * @inheritdoc
   */
  public function behaviors() {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function () {
                      return User::checkAccess('filters');
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
   * Lists all Filters models.
   * @return mixed
   */
  public function actionIndex() {
    $searchModel = new FiltersSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Filters model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id) {
    Yii::$app->response->statusCode = 201;
    $model = $this->findModel($id);

    if (is_null($model))
      return 'Фильтр не найдена';

    if (!is_null($model)) {
      $published = ($model->published == Filters::STATUS_ACTIVE ? Filters::STATUS_DISABLE : Filters::STATUS_ACTIVE);
      $model->setAttribute('published', $published);
      if ($model->save()) {
        Yii::$app->response->statusCode = 200;
        Yii::$app->session->setFlash('success', 'Успешно обновлен статус фильтра');
      }
    }
    return $this->redirect(Yii::$app->request->referrer);
  }

  /**
   * Creates a new Filters model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate() {
    $model = new Filters();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['index']);
    } else {
      #Defaults
      $placeholder = \Yii::$app->imageresize->getUrl('uploads/no_image.png', 320, 180, 'inset', 100, 'uploads/cache/thumb-no_image.png');
      return $this->render('create', [
                  'model' => $model,
                  'placeholder' => $placeholder
      ]);
    }
  }

  /**
   * Updates an existing Filters model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id) {
    $model = $this->findModel($id);

    //var_dump(Yii::$app->request->post());

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['update', 'id' => $model->id]);
    } else {
      #Defaults
      $placeholder = \Yii::$app->imageresize->getUrl('uploads/no_image.png', 320, 180, 'inset', 100, 'uploads/cache/thumb-no_image.png');
      return $this->render('update', [
                  'model' => $model,
                  'placeholder' => $placeholder
      ]);
    }
  }

  /**
   * Deletes an existing Filters model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id) {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the Filters model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Filters the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
    if (($model = Filters::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

}

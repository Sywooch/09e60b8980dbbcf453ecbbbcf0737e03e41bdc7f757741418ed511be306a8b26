<?php

namespace app\modules\shares\controllers\backend;

use app\models\User;
use Yii;
use app\modules\shares\models\Shares;
use app\modules\shares\models\SharesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Shares model.
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
                            return User::checkAccess('shares');
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Shares models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SharesSearch();
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
            return 'Афиша не найдена';
        if (!is_null($model)) {
            $published = ($model->published == Shares::STATUS_ACTIVE ? Shares::STATUS_DISABLE : Shares::STATUS_ACTIVE);
            $model->setAttribute('published', $published);
            if ($model->save()) {
                Yii::$app->response->statusCode = 200;
                Yii::$app->session->setFlash('success', 'Успешно обновлен статус афиши');
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Creates a new Shares model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Shares();

        if ($model->load(Yii::$app->request->post())) {
            $model->price = floatval($model->price);
            $model->save();
            return $this->redirect(['index']);
        } else {
            #Defaults
            $placeholder = \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot/uploads/no_image.png'), 320, 180, 'inset', 100, Yii::getAlias('@webroot/uploads/cache/thumb-no_image.png'));
            return $this->render('create', [
                        'model' => $model,
                        'placeholder' => $placeholder,
            ]);
        }
    }

    /**
     * Updates an existing Shares model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post('Shares');
            if (!isset($post['pin_main']))
                $model->pin_main = 0;
            if (!isset($post['pin_poster']))
                $model->pin_poster = 0;
            if (!isset($post['pin_filter']))
                $model->pin_filter = 0;
            $model->price = !is_null($model->price) ? $model->price : 0;
            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            #Defaults
            $placeholder = \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot/uploads/no_image.png'), 320, 180, 'inset', 100, Yii::getAlias('@webroot/uploads/cache/thumb-no_image.png'));
            $model->start_at = !is_null($model->start_at) ? Yii::$app->formatter->asDatetime($model->start_at) : '';
            $model->end_at = !is_null($model->end_at) ? Yii::$app->formatter->asDatetime($model->end_at) : '';
            return $this->render('update', [
                        'model' => $model,
                        'placeholder' => $placeholder,
            ]);
        }
    }

    /**
     * Deletes an existing Shares model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Shares model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shares the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Shares::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

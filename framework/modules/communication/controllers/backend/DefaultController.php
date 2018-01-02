<?php

namespace app\modules\communication\controllers\backend;

use app\models\User;
use Yii;
use app\modules\communication\models\Communication;
use app\modules\communication\models\CommunicationSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

require($_SERVER['DOCUMENT_ROOT'] . '/../api/load.php');

/**
 * DefaultController implements the CRUD actions for Communication model.
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
                            return User::checkAccess('communication');
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
     * Lists all Communication models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CommunicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $page = 1;
        $limit = 20 * $page;
        $CgetList = \Communication::items($limit, \Communication::$allw);
        $AgetList = \Ads::items($limit, \Ads::$allw);
        $users = [];
        $users_d = array_merge($CgetList['users'], $AgetList['users']);
        foreach ($users_d as $vol) {
            $users[$vol['id']] = $vol;
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'users' => $users,
                    'CgetList' => $CgetList,
                    'AgetList' => $AgetList
        ]);
    }

    public function actionAll() {
        $searchModel = new CommunicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $page = 1;
        $limit = 20 * $page;
        $CgetList = \Communication::items($limit, \Communication::$hide);
        $AgetList = \Ads::items($limit, \Ads::$hide);
        $users = [];
        $users_d = array_merge($CgetList['users'], $AgetList['users']);
        foreach ($users_d as $vol) {
            $users[$vol['id']] = $vol;
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'users' => $users,
                    'CgetList' => $CgetList,
                    'AgetList' => $AgetList
        ]);
    }

    /**
     * Displays a single Communication model.
     * @param integer $id
     * @return mixed
     */
    public function actionView() {
        Yii::$app->response->statusCode = 201;
        $model = $this->findModel(Yii::$app->request->post('id'));
        if (!is_null($model)) {
            if (Yii::$app->request->post('pin') == 'main')
                $model->pin = Yii::$app->request->post('checked') == 'true' ? $model::STATUS_ACTIVE : $model::STATUS_DISABLE;

            if ($model->save()) {
                Yii::$app->response->statusCode = 200;
                return 'Все прошло успешно!';
            }
            return 'Что-то пошло не так, повторите попытку позже!';
        }
        return 'Объявление не найдено!';
    }

    /**
     * Creates a new Communication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Communication();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Communication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
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
     * Deletes an existing Communication model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
//        $model = $this->findModel($id);
//        $model->delete();
        if (!empty($_GET['action'])) {
            if ($_GET['action'] == 'Communication') {
                \Communication::delete($id);
            } elseif ($_GET['action'] == 'Ads') {
                \Ads::delete($id);
            }
        }
        $this->redirect(['index']);
    }

    public function actionApprove($id) {
        if (!empty($_GET['action'])) {
            if ($_GET['action'] == 'Communication') {
                \Communication::Approve($id);
            } elseif ($_GET['action'] == 'Ads') {
                \Ads::Approve($id);
            }
        }
        $this->redirect(['index']);
    }

    /**
     * Finds the Communication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Communication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Communication::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

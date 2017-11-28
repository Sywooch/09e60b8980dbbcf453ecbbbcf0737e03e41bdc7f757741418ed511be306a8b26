<?php

namespace app\modules\buttons\controllers\backend;

use app\models\User;
use kotchuprik\sortable\actions\Sorting;
use Yii;
use app\modules\buttons\models\Buttons;
use app\modules\buttons\models\ButtonsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Buttons model.
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
                            return User::checkAccess('buttons');
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

    public function actions() {
        return [
            'sorting' => [
                'class' => Sorting::className(),
                'query' => Buttons::find(),
            ]
        ];
    }

    /**
     * Lists all Buttons models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ButtonsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Organizations model.
     * @param integer $id
     * @return mixed
     * @internal param string $name
     */
    public function actionView($id) {
        Yii::$app->response->statusCode = 201;
        $model = $this->findModel($id);

        if (is_null($model))
            return 'Кнопка не найдена';

        if (!is_null($model)) {
            $published = ($model->published == Buttons::STATUS_ACTIVE ? Buttons::STATUS_DISABLE : Buttons::STATUS_ACTIVE);
            $model->setAttribute('published', $published);
            if ($model->save()) {
                Yii::$app->response->statusCode = 200;
                Yii::$app->session->setFlash('success', 'Успешно обновлен статус кнопки');
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Creates a new Buttons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Buttons();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            #Defaults
            $placeholder = \Yii::$app->imageresize->getUrl(Yii::getAlias('uploads/no_image.png'), 140, 100, 'inset', 100, Yii::getAlias('@webroot/uploads/cache/thumb-no_image.png'));
            return $this->render('create', [
                        'model' => $model,
                        'placeholder' => $placeholder,
            ]);
        }
    }

    /**
     * Updates an existing Buttons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            #Defaults
            $placeholder = \Yii::$app->imageresize->getUrl(Yii::getAlias('uploads/no_image.png'), 140, 100, 'inset', 100, Yii::getAlias('@webroot/uploads/cache/thumb-no_image.png'));
            return $this->render('update', [
                        'model' => $model,
                        'placeholder' => $placeholder,
            ]);
        }
    }

    /**
     * Deletes an existing Buttons model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Buttons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Buttons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Buttons::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

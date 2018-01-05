<?php

namespace app\modules\organizations\controllers\backend;

use app\models\User;
use app\modules\organizations\models\OrganizationsAddress;
use app\modules\organizations\models\OrganizationsForm;
use app\modules\organizations\models\OrganizationsSites;
use app\modules\organizations\models\OrganizationsTelephones;
use kotchuprik\sortable\actions\Sorting;
use Yii;
use app\modules\organizations\models\Organizations;
use app\modules\organizations\models\OrganizationsSearch;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BackendController implements the CRUD actions for Organizations model.
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
                            return User::checkAccess('organizations');
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
                'query' => Organizations::find(),
            ]
        ];
    }

    /**
     * Lists all Organizations models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new OrganizationsSearch();
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
            return 'Организация не найдена';

        if (!is_null($model)) {
            $published = ($model->published == Organizations::STATUS_ACTIVE ? Organizations::STATUS_DISABLE : Organizations::STATUS_ACTIVE);
            $model->setAttribute('published', $published);
            if ($model->save()) {
                Yii::$app->response->statusCode = 200;
                Yii::$app->session->setFlash('success', 'Успешно обновлен статус публикации');
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Creates a new Organizations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new OrganizationsForm();
        $model->organization = new Organizations();
        $model->telephones = new OrganizationsTelephones();
        $model->addresses = new OrganizationsAddress();
        $model->sites = new OrganizationsSites();
        if ($model->organization->load(Yii::$app->request->post())) {
            if ($model->organization->save()) {
                # Load phone from post and save
                Yii::$app->session->setFlash('success', 'Организация успешно создана.<br> Теперь вы можете заполнить номера телефонов и контактную информацию');
                return $this->redirect(['update', 'id' => $model->organization->id]);
            }
        }
        #Defaults
        $placeholder = \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot/uploads/no_image.png'), 320, 180, 'inset', 100, Yii::getAlias('@webroot/uploads/cache/thumb-no_image.png'));
        return $this->render('create', [
                    'model' => $model,
                    'placeholder' => $placeholder,
        ]);
    }

    /**
     * Updates an existing Organizations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @internal param string $name
     */
    public function actionUpdate($id) {
        $model = Organizations::find()->with(['category', 'telephones', 'addresses'])->where(['id' => $id])->one();
        $telephones = new OrganizationsTelephones;
        if ($model->load(Yii::$app->request->post())) {
            //$model->category_id = join(',', $model->category_id);
            #Save data
            $model->update();
            #Save phone numbers
            OrganizationsTelephones::deleteAll('organization_id = :id', [':id' => $model->id]);
            $post = Yii::$app->request->post('Organizations');
            foreach ($post['telephones']['number'] as $id => $number) {
                $telephone = new OrganizationsTelephones();
                $telephone->organization_id = $model->id;
                $telephone->number = $number;
                $telephone->save();
            }
            #Save adress
            OrganizationsAddress::deleteAll('organization_id = :id', [':id' => $model->id]);
            foreach ($post['addresses'] as $id => $data) {
                $address = new OrganizationsAddress();
                $address->load($data);
                $address->organization_id = $model->id;
                $address->address = $data['address'];
                $address->working_days = $data['working_days'];
                $address->working_hours = $data['working_hours'];
                $address->lunch_time = $data['lunch_time'];
                $address->weekend = $data['weekend'];
                $address->latitude = ($data['latitude'] ? $data['latitude'] : 0);
                $address->longitude = ($data['longitude'] ? $data['longitude'] : 0);
                $address->save();
            }



            Yii::$app->session->setFlash('success', 'Организация успешно обновлена.');
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            #Defaults
            $placeholder = \Yii::$app->imageresize->getUrl(Yii::getAlias('@webroot/uploads/no_image.png'), 320, 180, 'inset', 100, Yii::getAlias('@webroot/uploads/cache/thumb-no_image.png'));
            return $this->render('update', [
                        'model' => $model,
                        'telephones' => $telephones,
                        'placeholder' => $placeholder,
            ]);
        }
    }

    /**
     * Deletes an existing Organizations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @internal param string $name
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Organizations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return array|\yii\db\ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     * @internal param string $name
     */
    protected function findModel($id) {
        if (($model = Organizations::find()->with('telephones')->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

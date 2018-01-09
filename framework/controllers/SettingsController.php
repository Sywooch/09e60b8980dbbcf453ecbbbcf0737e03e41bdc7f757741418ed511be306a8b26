<?php

namespace app\controllers;

use app\models\Settings;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SettingsController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return User::checkAccess('help');
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        if ($post = Yii::$app->request->post()) {
            unset($post['_csrf']);
            foreach ($post as $key => $value) {
                $model = Settings::find()->where('name = :name', [':name' => $key])->one();
                $model->value = $value;
                $model->update();
            }
            Yii::$app->session->setFlash('success', 'Все успешно обновлено!');
        }

        $model = Settings::find()->indexBy('name')->all();
        return $this->render('index', ['model' => $model]
        );
    }

}

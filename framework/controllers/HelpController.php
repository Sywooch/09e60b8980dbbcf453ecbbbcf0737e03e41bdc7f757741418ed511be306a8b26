<?php

namespace app\controllers;

use app\models\Help;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class HelpController extends Controller
{
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
							return User::checkAccess('help');
						}
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST','GET'],
				],
			],
		];
	}

    /**
     * @inheritdoc
     */
    public function actions()
    {
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
    public function actionIndex()
    {
	    $model = Help::find()->orderBy(['id' => SORT_DESC])->one();
		if(is_null($model))
			$model = new  Help();
	    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
		    //$result = $model->isNewRecord ?
			 //   $model->save() : $model->update();
		    if($model->save())
	    	    Yii::$app->session->setFlash('success', 'Все успешно обновлено!');
			else
		        Yii::$app->session->setFlash('error', 'При обновлении произошла ошибка, повторите попытку еще раз.');
	    }
	    return $this->render('index', [
		    'model' => $model,
	    ]);
    }
}

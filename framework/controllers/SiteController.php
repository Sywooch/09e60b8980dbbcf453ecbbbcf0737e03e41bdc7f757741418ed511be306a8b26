<?php

namespace app\controllers;

use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
	//public $layout = 'login';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
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
     * @return string
     */
    public function actionIndex()
    {
	    if (Yii::$app->user->isGuest) {
		    return $this->redirect('login');
	    }
	    $this->layout = 'main';
        return $this->render('index');
    }

    /**
     * Login action.
     * @return string
     */
	public function actionLogin()
	{
		if (!\Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$this->layout = 'login';
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			return $this->render('login', [
				'model' => $model,
			]);
		}
	}

    /**
     * Logout action.
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

	/**
	 * Requests password reset.
	 * @return mixed
	 */
	public function actionRestorePassword()
	{
		$model = new PasswordResetRequestForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail()) {
				Yii::$app->session->setFlash('success', Yii::t('messages', 'Проверьте свою электронную почту для получения дальнейших инструкций.'));
				$model = new PasswordResetRequestForm();
			} else {
				Yii::$app->session->setFlash('error', Yii::t('messages', 'К сожалению, в настоящее время мы не можем сбросить пароль для данной почты. Повторите попытку позже.'));
			}
		}

		$this->layout = 'login';
		return $this->render('requestPasswordResetToken', [
			'model' => $model,
		]);
	}

	/**
	 * Resets password.
	 *
	 * @param string $token
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetPassword($token)
	{
		try {
			$model = new ResetPasswordForm($token);
		} catch (InvalidParamException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->session->setFlash('success', Yii::t('messages', 'Новый пароль успешно установлен.'));
			return $this->goHome();
		}

		return $this->render('resetPassword', [
			'model' => $model,
		]);
	}


}

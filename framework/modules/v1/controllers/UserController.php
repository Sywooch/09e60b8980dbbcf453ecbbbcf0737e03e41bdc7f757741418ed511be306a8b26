<?php
namespace app\modules\v1\controllers;

use app\models\Clients;
use app\modules\v1\models\ChangePassword;
use app\modules\v1\models\UploadAvatar;
use app\modules\v1\models\Login;
use app\modules\v1\models\Register;
use app\modules\v1\models\RequestResetPassword;
use app\modules\v1\models\ResetPassword;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;


class UserController extends Controller
{
	/**
	 * @var Clients
	 */
	private $user;


	public function __construct($id, Module $module, array $config = [])
	{
		# Default status code and response
		\Yii::$app->response->setStatusCode(555);
		\Yii::$app->response->format = Response::FORMAT_JSON;
		parent::__construct($id, $module, $config);
	}

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['register', 'login', 'restore'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'matchCallback' => function () {
							return $this->user = Clients::isLogin();
						}
					],
				],
				'denyCallback' => function (/*$rule, $action*/) {
					\Yii::$app->response->setStatusCode(403);
					echo json_encode(['error' => 'Ключ авторизации не найден или пользователь уже вышел.']);
				}
			]
		];
	}


	public function actionIndex(){
		return $this->user;
	}

	public function actionLogin(){

		$model = new Login();
		if ($model->load(['Login' => Yii::$app->request->post()])) {
			if ($user = $model->login()) {
				\Yii::$app->response->setStatusCode(200);
				if (empty($user->auth_key)){
					$user->generateAuthKey();
					$user->update();
				}
				return $user->auth_key;
			}else
				return implode(', ', $model->getFirstErrors());
		}else
			return 'Ошибка получения данных!';
	}

	public function actionRegister(){

		$model = new Register();
		if ($model->load(['Register' => Yii::$app->request->post()])) {
			if ($user = $model->register()) {
				\Yii::$app->response->setStatusCode(200);
				return $user->auth_key;
			}else
				return implode(', ', $model->getFirstErrors());
		}else
			return 'Ошибка получения данных!';
	}

	public function actionLogout(){
		// Выход пользователя
		$this->user->auth_key = null;
		if ($this->user->update()){
			\Yii::$app->response->setStatusCode(200);
			return 'Вы успешно вышли с Вашей учетной записи';
		}
		// Не удалось выйти пользователем
		return 'Произошла неизвестная ошибка, обратитесь к администрации.';
	}

	public function actionAvatar()
	{
		if (Yii::$app->request->isPost) {
			$model = new UploadAvatar();
			$model->imageFile = UploadedFile::getInstanceByName('image');
			if ($model->validate()) {
				# Delete old avatar
				if(!empty($this->user->avatar) && file_exists(Yii::getAlias("@webroot/".$this->user->avatar)))
					unlink(Yii::getAlias("@webroot/".$this->user->avatar));
				# Upload new avatar
				$dir = 'uploads/users/';
				$model->imageFile->name = $this->user->id.'_'.time() . '.' . $model->imageFile->extension;
				if ($model->upload($dir)) {
					$this->user->avatar = $dir . $model->imageFile->baseName . '.' . $model->imageFile->extension;
					if ($this->user->save(false)) {
						\Yii::$app->response->setStatusCode(200);
						return 'Аватар успешно загружен.';
					} else
						return ['error' => implode(', ', $this->user->getFirstErrors())];
				}
				return ['error' => implode(', ', $model->getFirstErrors())];
			}
			return ['error' => implode(', ', $model->getFirstErrors())];
		}
		return [];
	}

	public function actionRestore(){



	}

	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 */
	public function actionResetPasswordRequest()
	{
		$model = new RequestResetPassword();

		if ($model->load(['RequestResetPassword' => Yii::$app->request->post()]) && $model->validate()) {
			if ($model->sendEmail()) {
				\Yii::$app->response->setStatusCode(200);
				return 'Проверьте свою электронную почту для получения дальнейших инструкций.';
			} else {
				return 'Извините, мы не можем сбросить пароль для указанного адреса электронной почты.';
			}
		}
		return implode(', ', $model->getFirstErrors());
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
			$model = new ResetPassword($token);
		} catch (InvalidParamException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}
		if ($model->load(['ResetPassword' => Yii::$app->request->post()]) && $model->validate() && $model->resetPassword()) {
			\Yii::$app->response->setStatusCode(200);
			return 'Новый пароль успешно установлен';
		}
		return 'Произошла неизвестная ошибка, обратитесь к администрации.';
	}

	/**
	 * Change password.
	 *
	 * @return mixed
	 */
	public function actionChangePassword(){
		$model = new ChangePassword();
		if ($model->load(['ChangePassword' => Yii::$app->request->post()]) && $model->validate() && $model->changePassword($this->user)) {
			return 'Новый пароль успешно установлен';
		}
		return implode(', ', $model->getFirstErrors());
	}
}

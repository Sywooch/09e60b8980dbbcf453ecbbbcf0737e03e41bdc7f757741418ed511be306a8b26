<?php

namespace app\models;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
	public $account_name;
	public $account_password;
	public $rememberMe;
	private $_user;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			[['account_name', 'account_password'], 'required'],
			['rememberMe', 'boolean'],
			['account_password', 'validatePassword'],
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'account_name'=> 'Ваше аккаунт',
			'account_password'=> 'Пароль от аккаунта',
			'rememberMe'=> 'Запомнить меня',
			'verifyCode'=> 'Код с картинки',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'validatePassword' validator as declared in rules().
	 */
	public function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if (!$user || !$user->validatePassword($this->account_password)) {
				$this->addError($attribute, 'Неверный аккаунт или пароль.');
			}
		}
	}


	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if ($this->validate()) {
			return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
		} else {
			return false;
		}
	}


	/**
	 * Finds user by [[username]]
	 *
	 * @return User|null
	 */
	protected function getUser()
	{
		if ($this->_user === null) {
			$this->_user = User::findByUsername($this->account_name);
		}
		return $this->_user;
	}

}

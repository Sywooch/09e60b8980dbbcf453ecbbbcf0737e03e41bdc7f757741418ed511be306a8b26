<?php
/********************************
 * Created by GoldenEye.
 * ICQ 285652 / email : slims.alex@gmail.com
 * WEB: http://scriptsweb.ru
 * copyright 2010 - 2017
 ********************************/

namespace app\modules\v1\models;
use app\models\Clients;
use yii\base\Model;
/**
 * LoginForm is the model behind the login form.
 *
 * @property Clients|null $user This property is read-only.
 *
 */
class Login extends Model
{
	public $email;
	public $password;
	public $rememberMe = true;
	private $_user = false;
	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			['email', 'trim'],
			['email', 'required'],
			['email', 'email'],
			['password', 'filter', 'filter' => 'trim'],
			['password', 'required'],
			['password', 'validatePassword'],
		];
	}
	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if (!$user || !$user->validatePassword($this->password)) {
				$this->addError($attribute, 'Неверно указан Email или пароль.');
			}
		}
	}
	/**
	 * Logs in a user using the provided username and password.
	 * @return Clients|bool whether the user is logged in successfully
	 */
	public function login()
	{
		if ($this->validate()) {
			return $this->_user;
		}
		return false;
	}
	/**
	 * Finds user by [[username]]
	 *
	 * @return Clients|null
	 */
	public function getUser()
	{
		if ($this->_user === false) {
			$this->_user = Clients::findByEmail($this->email);
		}
		return $this->_user;
	}
}
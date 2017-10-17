<?php
/********************************
 * Created by GoldenEye.
 * ICQ 285652 / email : slims.alex@gmail.com
 * WEB: http://scriptsweb.ru
 * copyright 2010 - 2017
 ********************************/

namespace app\modules\v1\models;

use app\models\Clients;
use Yii;
use yii\base\Model;
/**
 * Signup form
 */
class Register extends Model
{
	public $first_name;
	public $last_name;
	public $email;
	public $password;
	public $re_password;


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['first_name', 'required'],
			['last_name', 'required'],

			['email', 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => Clients::className(), 'message' => 'Пользователь с таким Email уже зарегистрирован!'],

			['password', 'filter', 'filter' => 'trim'],
			['password', 'required'],
			['password', 'string', 'min' => 6],

			//['re_password', 'required'],
			//['re_password', 'filter', 'filter' => 'trim'],
			//['re_password', 'compare', 'compareAttribute' => 'password', 'operator' => '=='],
		];
	}


	public function attributeLabels()
	{
		return [
			'first_name' => Yii::t('cabinet', 'Имя'),
			'last_name' => Yii::t('cabinet', 'Фамилия'),
			'email' => Yii::t('cabinet', 'Email'),
			'password' => Yii::t('cabinet', 'Пароль'),
			'repassword' => Yii::t('cabinet', 'Повторите пароль'),
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return Clients|null the saved model or null if saving fails
	 */
	public function register()
	{
		if (!$this->validate()) {
			return null;
		}

		$user = new Clients();
		$user->first_name = $this->first_name;
		$user->last_name = $this->last_name;
		$user->email = $this->email;
		$user->setPassword($this->password);
		$user->generateAuthKey();
		return $user->save() ? $user : null;
	}
}
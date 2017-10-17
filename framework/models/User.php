<?php

namespace app\models;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $first_name
 * @property string $phone
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $auth_service
 * @property string $last_name
 * @property string $middle_name
 */
class User extends ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 1;

	public $auth_key = 'lock';
	public $new_password = null;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%admins}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['status', 'default', 'value' => self::STATUS_ACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
			[['account_name','profile', 'new_password', 'password', 'salt', 'first_name', 'last_name', 'account_email', 'admin_name', 'admin_type', 'projects', 'servers'], 'safe'],

		];
	}

	public function attributeLabels()
	{
		return [
			'account_name' => 'Имя аккаунта',
			'password' => 'Пароль',
			'new_password' => 'Новый пароль',
			'first_name' => 'Имя',
			'last_name' => 'Фамилия',
			'profile' => 'Профиль',
			'account_email' => 'Почта',
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['account_name' => $username, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::findOne([
			'password_reset_token' => $token,
			'status' => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return boolean
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token)) {
			return false;
		}

		$timestamp = (int) substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time();
	}

	/**
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		$password = hash('sha512', $password . $this->salt);
		return ($this->password == $password);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password = hash('sha512', $password . $this->salt);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->password_reset_token = null;
	}

	public static function checkAccess($access)
	{
		return !is_null(AdminsAccess::findOne(['access' => strtolower($access), 'admin_id' => Yii::$app->getUser()->id])) ||
					Yii::$app->getUser()->identity->profile === 1
			? true : false;
	}

	public function getAccess(){

		return $this->hasMany(AdminsAccess::className(), ['admin_id' => 'id'])->indexBy('access');
    }

	public static function profilesList($profile=null)
	{
		$list = [
			1 => 'Главный Администратор',
			2 => 'Администратор',
			3 => 'Модератор'
		];
		return is_null($profile) ? $list : $list[$profile];
	}

}

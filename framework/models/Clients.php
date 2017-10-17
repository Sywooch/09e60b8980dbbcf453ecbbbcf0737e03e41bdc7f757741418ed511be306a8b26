<?php
	namespace app\models;
	use yii;
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
	 * @property string $last_name
	 * @property string $phone
	 * @property string $email
	 * @property string $auth_key
	 * @property integer $status
	 * @property integer $created_at
	 * @property integer $block_publication
	 * @property integer $updated_at
	 * @property string $password write-only password
	 * @property string $auth_service
	 */
	class Clients extends ActiveRecord implements IdentityInterface
	{
		const STATUS_DELETED = 0;
		const STATUS_ACTIVE = 1;
		const STATUS_BLOCK = 2;

		# Eauth params
		public $profile;
		public $password;
		public $new_password = null;

		/**
		 * @inheritdoc
		 */
		public static function tableName()
		{
			return '{{%users}}';
		}

		/**
		 * @inheritdoc
		 */
		public function behaviors()
		{
			return [
				'timestamp' => [
					'class' => TimestampBehavior::className(),
					'attributes' => [
						ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
						ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
					],
					'value' => new Expression('NOW()'),
				]
			];
		}

		public function attributeLabels()
		{
			return [
				'id' => '##',
				'fio' => 'ФИО',
				'account_name' => 'Логин',
				'password' => 'Пароль',
				'new_password' => 'Новый пароль',
				'phone' => 'Телефон',
				'status' => 'Статус',
				'email' => 'Почта ( email )',
				'auth_service' => 'Тип авторизации',
				'created_at' => 'Дата регистрации',
				'block_publication' => 'Запретить публикации',
			];
		}


		/**
		 * @inheritdoc
		 */
		public function rules()
		{
			return [
				[['account_name', 'password'], 'required', 'on' => 'insert'],
				['status', 'default', 'value' => self::STATUS_ACTIVE],
				['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_BLOCK]],
				['email', 'email'],
				[['phone', 'email'], 'safe']
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
			return static::findOne(['auth_key' => $token]);
		}

		/**
		 * Finds user by username
		 *
		 * @param string $username
		 * @return static|null
		 */
		public static function findByUsername($username)
		{
			return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
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
			return Yii::$app->security->validatePassword($password, $this->password_hash);
		}

		/**
		 * Generates password hash from password and sets it to the model
		 *
		 * @param string $password
		 */
		public function setPassword($password)
		{
			$this->password_hash = Yii::$app->security->generatePasswordHash($password);
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
		/**
		 * Finds user by username
		 *
		 * @param string $email
		 * @return static|null
		 */
		public static function findByEmail($email)
		{
			return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
		}

		/**
		 * Finds user by username
		 *
		 * @param string $phone
		 * @return static|null
		 */
		public static function findByPhone($phone)
		{
			return static::findOne(['phone' => $phone, 'status' => self::STATUS_ACTIVE]);
		}

		public static function isLogin(){
			return self::find()
				->where('auth_key = :access_token and status = :status', [
					':access_token' => Yii::$app->request->headers->get('access_token'),
					':status' => self::STATUS_ACTIVE])
				->one();
		}
	}

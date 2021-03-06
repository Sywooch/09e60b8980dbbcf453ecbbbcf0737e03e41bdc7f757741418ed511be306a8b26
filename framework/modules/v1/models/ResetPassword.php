<?php
	namespace app\modules\v1\models;
	use yii\base\Model;
	use yii\base\InvalidParamException;
	use app\models\Clients;
	/**
	 * Password reset form
	 */
	class ResetPassword extends Model
	{
		public $password;
		/**
		 * @var \app\models\Clients
		 */
		private $_client;
		/**
		 * Creates a form model given a token.
		 *
		 * @param string $token
		 * @param array $config name-value pairs that will be used to initialize the object properties
		 * @throws \yii\base\InvalidParamException if token is empty or not valid
		 */
		public function __construct($token, $config = [])
		{
			if (empty($token) || !is_string($token)) {
				throw new InvalidParamException('Password reset token cannot be blank.');
			}
			$this->_client = Clients::findByPasswordResetToken($token);
			if (!$this->_client) {
				throw new InvalidParamException('Wrong password reset token.');
			}
			parent::__construct($config);
		}
		/**
		 * @inheritdoc
		 */
		public function rules()
		{
			return [
				['password', 'required'],
				['password', 'string', 'min' => 6],
			];
		}
		/**
		 * Resets password.
		 *
		 * @return bool if password was reset.
		 */
		public function resetPassword()
		{
			$client = $this->_client;
			$client->setPassword($this->password);
			$client->removePasswordResetToken();
			return $client->save(false);
		}
	}
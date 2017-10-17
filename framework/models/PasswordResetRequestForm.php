<?php
	namespace app\models;

	use Yii;
	use yii\base\Model;

	/**
	 * Password reset request form
	 */
	class PasswordResetRequestForm extends Model
	{
		public $account_email;
		public $captcha;


		/**
		 * @inheritdoc
		 */
		public function rules()
		{
			return [
				['account_email', 'filter', 'filter' => 'trim'],
				['account_email', 'required'],
				['account_email', 'email'],
				['account_email', 'exist',
					'targetClass' => '\app\models\User',
					'filter' => ['status' => User::STATUS_ACTIVE],
					'message' => 'Пользователь с такой почтой не найден!'
				],
				//['captcha', 'captcha']
//				[['captcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()]
			];
		}

		public function attributeLabels()
		{
			return [
				'account_email' => Yii::t('cabinet', 'Ваша почта'),
				'captcha' => Yii::t('cabinet', 'Проверочный код'),
			];
		}


		/**
		 * Sends an email with a link, for resetting the password.
		 *
		 * @return boolean whether the email was send
		 */
		public function sendEmail()
		{
			/* @var $user User */
			$user = User::findOne([
				'status' => User::STATUS_ACTIVE,
				'account_email' => $this->account_email,
			]);

			if (!$user) {
				return false;
			}

			if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
				$user->generatePasswordResetToken();
			}

			if (!$user->save()) {
				return false;
			}

			$send_mail = Yii::$app
				->mailer
				->compose(
					['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
					['user' => $user]
				)
				->setCharset('utf-8')
				->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ''])
				->setTo($this->account_email)
				->setSubject(Yii::t('cabinet', 'Восстановление пароля'))
				->send();

			return $send_mail;
		}
	}

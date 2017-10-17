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
 * Password reset request form
 */
class RequestResetPassword extends Model
{
	public $email;
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['email', 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'exist',
				'targetClass' => '\app\models\Clients',
				'filter' => ['status' => Clients::STATUS_ACTIVE],
				'message' => 'Êëèåíòîâ ñ ıòèì àäğåñîì ıëåêòğîííîé ïî÷òû íåò.'
			],
		];
	}
	/**
	 * Sends an email with a link, for resetting the password.
	 *
	 * @return bool whether the email was send
	 */
	public function sendEmail()
	{
		/* @var $client Clients */
		$client = Clients::findOne([
			'status' => Clients::STATUS_ACTIVE,
			'email' => $this->email,
		]);
		if (!$client) {
			return false;
		}

		if (!Clients::isPasswordResetTokenValid($client->password_reset_token)) {
			$client->generatePasswordResetToken();
			if (!$client->save()) {
				return false;
			}
		}
		return Yii::$app
			->mailer
			->compose(
				['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
				['client' => $client]
			)
			->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
			->setTo($this->email)
			->setSubject('Password reset for ' . Yii::$app->name)
			->send();
	}
}
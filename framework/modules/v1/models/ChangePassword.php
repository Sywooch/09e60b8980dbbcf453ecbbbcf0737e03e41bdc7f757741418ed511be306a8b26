<?php
namespace app\modules\v1\models;
use Yii;
use yii\base\Model;
use app\models\Clients;

/**
 * Password reset form
 */
class ChangePassword extends Model
{
	public $password;
	public $re_password;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['re_password','password'], 'required'],
			['password', 'string', 'min' => 6],
			['re_password', 'string', 'min' => 6],
			['re_password', 'compare', 'compareAttribute' => 'password', 'operator' => '=='],
		];
	}

	public function attributeLabels()
	{
		return [
			'password' => Yii::t('cabinet', 'New password'),
			're_password' => Yii::t('cabinet', 'Repeat new password'),
		];
	}

	/**
	 * Resets password.
	 *
	 * @param $user Clients
	 * @return bool if password was reset.
	 */
	public function changePassword($user)
	{
		$user->setPassword($this->password);
		$user->save(false);
		return \Yii::$app
			->mailer
			->compose(
				['html' => 'ChangePassword-html', 'text' => 'ChangePassword_text'],
				['user' => $user, 'password' => $this->password]
			)
			->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
			->setTo($user->email)
			->setSubject('Password reset for ' . \Yii::$app->name)
			->send();
	}
}


<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $repassword;

    /**
     * @var \app\models\User
     */
    private $_user;


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
            throw new InvalidParamException('Токен сброса пароля не может быть пустым.');
        }

        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Неверный токен сброса пароля.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	        [['password','repassword'], 'required'],

	        ['password', 'filter', 'filter' => 'trim'],
	        ['password', 'string', 'min' => 6],

	        ['repassword', 'filter', 'filter' => 'trim'],
	        ['repassword', 'compare', 'compareAttribute' => 'password', 'operator' => '=='],

        ];
    }

	public function attributeLabels()
	{
		return [
			'password' => Yii::t('cabinet', 'Новый пароль *'),
			'repassword' => Yii::t('cabinet', 'Повторите новый пароль *'),
		];
	}

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}

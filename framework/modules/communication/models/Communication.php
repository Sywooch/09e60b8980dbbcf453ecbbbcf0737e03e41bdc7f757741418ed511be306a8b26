<?php

namespace app\modules\communication\models;

use app\models\Clients;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%communication}}".
 *
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $pin
 * @property int $status
 * @property int $is_pin
 * @property string $created_at
 * @property string $updated_at
 */
class Communication extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 2;
	const STATUS_NEW = 0;

	public $is_pin;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%communication}}';
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
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				'value' => new Expression('NOW()'),
			]
		];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['status'], 'default', 'value' => self::STATUS_NEW],
            [['user_id'], 'required'],
            [['user_id', 'pin', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Текст'),
            'user_id' => Yii::t('app', 'Автор'),
            'pin' => Yii::t('app', 'Pin Main'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];
    }

    public function getUser(){
	    return 1;
    }

    public function getComments(){
	    return $this->hasMany(Comments::className(), ['comm_id' => 'id']);
    }

	public function getCommentsCount()
	{
		return $this->hasOne(Comments::className(), ['comm_id' => 'id'])->select('count(id) as count,comm_id');
	}

}

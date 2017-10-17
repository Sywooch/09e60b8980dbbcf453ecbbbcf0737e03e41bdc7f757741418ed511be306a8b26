<?php

namespace app\modules\ads\models;

use app\models\Clients;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%ads}}".
 *
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $pin_main
 * @property int $pin_filter
 * @property int $status
 * @property int $is_pin
 * @property string $created_at
 * @property string $updated_at
 */
class Ads extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;
	public $is_pin;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ads}}';
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
            [['user_id'], 'required'],
            [['user_id', 'pin_main', 'pin_filter', 'status'], 'integer'],
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
            'pin_main' => Yii::t('app', 'Pin Main'),
            'pin_filter' => Yii::t('app', 'Pin Filter'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];
    }

    public function getUser(){
	    return $this->hasOne(Clients::className(), ['id' => 'user_id']);
    }
}

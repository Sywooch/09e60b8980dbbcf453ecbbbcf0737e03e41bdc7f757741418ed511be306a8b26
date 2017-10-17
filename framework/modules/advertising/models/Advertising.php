<?php

namespace app\modules\advertising\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%advertising}}".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 */
class Advertising extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertising}}';
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
            [['title', 'text', 'url'], 'required'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Название'),
            'text' => Yii::t('app', 'Текст'),
            'url' => Yii::t('app', 'Ссылка на видео'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}

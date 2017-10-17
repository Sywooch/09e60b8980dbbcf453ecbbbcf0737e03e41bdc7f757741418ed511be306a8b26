<?php

namespace app\modules\notice\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%notice}}".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $section
 * @property int $section_id
 * @property string $created_at
 * @property string $updated_at
 */
class Notice extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notice}}';
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
            [['text', 'section', 'section_id'], 'required'],
            [['text'], 'string'],
            [['section', 'section_id','platform'], 'integer'],
            [['title','created_at', 'updated_at','send_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Заголовок'),
            'platform' => Yii::t('app', 'Платформа'),
            'send_at' => Yii::t('app', 'Дата и вермя отправки'),
            'text' => Yii::t('app', 'Текст'),
            'section' => Yii::t('app', 'Раздел'),
            'section_id' => Yii::t('app', 'ID (новости, организации, афиши, акции)'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}

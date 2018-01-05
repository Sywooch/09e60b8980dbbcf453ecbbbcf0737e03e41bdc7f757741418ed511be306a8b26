<?php

namespace app\modules\advertising_banner\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%advertising_banner}}".
 *
 * @property int $id
 * @property string $url
 * @property string $telephone
 * @property int $organization_id
 * @property int $category_id
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 */
class AdvertisingBanner extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertising_banner}}';
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
            [['image', 'category_id'], 'safe'],
            [['url', 'telephone', 'organization_id'], 'safe'],
            [['organization_id', 'category_id'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
            [['url', 'image'], 'string', 'max' => 255],
            [['telephone'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Ссылка'),
            'telephone' => Yii::t('app', 'Телефон'),
            'organization_id' => Yii::t('app', 'ID организации'),
            'category_id' => Yii::t('app', 'ID категории'),
            'image' => Yii::t('app', 'Изображение'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}

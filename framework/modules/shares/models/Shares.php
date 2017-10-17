<?php

namespace app\modules\shares\models;

use app\modules\filters\models\Filters;
use app\modules\organizations\models\Category;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%shares}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $address
 * @property string $image
 * @property string $price
 * @property string $telephone
 * @property int $published
 * @property string $url
 * @property string $url_video
 * @property string $url_descrition
 * @property int $category_id
 * @property int $pin_main
 * @property int $pin_poster
 * @property int $pin_filter
 * @property string $end_at
 * @property string $created_at
 * @property string $updated_at
 */
class Shares extends ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shares}}';
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
            [['name'], 'required'],
            [['description', 'image'], 'string'],
            [['price'], 'number'],
            [['category_id', 'published', 'pin_main', 'pin_poster', 'pin_filter'], 'integer'],
            [['start_at', 'end_at', 'created_at', 'updated_at'], 'safe'],
            [['name', 'address', 'telephone', 'url', 'url_video', 'url_descrition'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
	        'id' => Yii::t('shares', 'ИД'),
	        'name' => Yii::t('shares', 'Название'),
	        'description' => Yii::t('shares', 'Описание'),
	        'address' => Yii::t('shares', 'Адрес'),
	        'price' => Yii::t('shares', 'Цена'),
	        'image' => Yii::t('shares', 'Изображение'),
	        'telephone' => Yii::t('shares', 'Телефон'),
	        'published' => Yii::t('shares', 'Опубликовать'),
	        'url' => Yii::t('shares', 'Сайт'),
	        'url_video' => Yii::t('shares', 'Ссылка на видео'),
	        'url_descrition' => Yii::t('shares', 'Ссылка описания'),
	        'pin_main' => Yii::t('shares', 'Фильтр'),
	        'pin_poster' => Yii::t('shares', 'Pin Poster'),
	        'pin_filter' => Yii::t('shares', 'Pin Filter'),
	        'start_at' => Yii::t('shares', 'Дата начала'),
	        'end_at' => Yii::t('shares', 'Дата заверщения'),
	        'created_at' => Yii::t('shares', 'Created At'),
	        'updated_at' => Yii::t('shares', 'Updated At'),
	        'category_id' => Yii::t('shares', 'Фильтр'),
        ];
    }

    /**
     * @inheritdoc
     * @return SharesQuery
     */
    public static function find()
    {
        return new SharesQuery(get_called_class());
    }

	public static function PublishedStatus(){
		return [
			self::STATUS_ACTIVE => 'Да',
			self::STATUS_DISABLE => 'Нет',
		];
	}

	public function getCategory(){
		return $this->hasOne(Filters::className(), ['id' => 'category_id']);
	}
}

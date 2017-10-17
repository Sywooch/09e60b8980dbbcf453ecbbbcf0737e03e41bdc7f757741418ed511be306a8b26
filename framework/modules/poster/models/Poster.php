<?php

namespace app\modules\poster\models;

use app\modules\filters\models\Filters;
use app\modules\organizations\models\Category;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%poster}}".
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
 * @property int $pin_main
 * @property int $pin_poster
 * @property int $pin_filter
 * @property string $start_at
 * @property string $end_at
 * @property string $created_at
 * @property string $category_id
 * @property string $updated_at
 */
class Poster extends ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%poster}}';
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
	        'id' => Yii::t('poster', 'ИД'),
	        'name' => Yii::t('poster', 'Название'),
	        'description' => Yii::t('poster', 'Описание'),
	        'address' => Yii::t('poster', 'Адрес'),
	        'price' => Yii::t('poster', 'Цена'),
	        'image' => Yii::t('poster', 'Изображение'),
	        'telephone' => Yii::t('poster', 'Телефон'),
	        'published' => Yii::t('poster', 'Опубликовать'),
	        'url' => Yii::t('poster', 'Сайт'),
	        'url_video' => Yii::t('poster', 'Ссылка на видео'),
	        'url_descrition' => Yii::t('poster', 'Ссылка описания'),
	        'pin_main' => Yii::t('poster', 'Фильтр'),
	        'pin_poster' => Yii::t('poster', 'Pin Poster'),
	        'pin_filter' => Yii::t('poster', 'Pin Filter'),
	        'start_at' => Yii::t('shares', 'Дата начала'),
	        'end_at' => Yii::t('poster', 'Дата заверщения'),
	        'created_at' => Yii::t('poster', 'Created At'),
	        'updated_at' => Yii::t('poster', 'Updated At'),
	        'category_id' => Yii::t('shares', 'Фильтр'),
        ];
    }

    /**
     * @inheritdoc
     * @return PosterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PosterQuery(get_called_class());
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

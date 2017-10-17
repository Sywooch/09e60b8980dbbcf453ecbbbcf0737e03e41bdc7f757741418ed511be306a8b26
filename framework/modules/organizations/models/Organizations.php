<?php

namespace app\modules\organizations\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%organizations}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $category_id
 * @property string $image
 * @property int $published
 * @property int $order
 * @property string $url
 * @property string $url_facebook
 * @property string $url_vk
 * @property string $url_ok
 * @property string $url_instagram
 * @property string $url_twitter
 * @property string $address
 * @property string $working_days
 * @property string $working_hours
 * @property string $lunch_time
 * @property string $weekend
 */
class Organizations extends ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 2;
	const STATUS_NEW = 0;

	public $telephone;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organizations}}';
    }
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'sortable' => [
				'class' => \kotchuprik\sortable\behaviors\Sortable::className(),
				'query' => self::find(),
			],
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
			[['name', 'category_id'], 'required', 'on' => self::SCENARIO_DEFAULT],
			[['description','category_id'], 'string'],
			[[ 'published', 'order'], 'integer'],
			[['name', 'image', 'url', 'url_facebook', 'url_vk', 'url_ok', 'url_instagram', 'url_twitter'], 'string', 'max' => 255],
			[['telephone_list'], 'safe'],

			[['name', 'user_name', 'user_email', 'user_telephone'], 'required', 'on' => 'add_org'],
		];
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('organizations', 'ID'),
            'name' => Yii::t('organizations', 'Название организации'),
            'description' => Yii::t('organizations', 'Информация'),
            'category_id' => Yii::t('organizations', 'Категория'),
            'image' => Yii::t('organizations', 'Изображение'),
            'published' => Yii::t('organizations', 'Опубликовать'),
            'order' => Yii::t('organizations', 'Позиция'),
	        'url' => Yii::t('organizations', 'Ссылки на сайт и социальные сети'),
	        'url_facebook' => Yii::t('organizations', 'Url Facebook'),
	        'url_vk' => Yii::t('organizations', 'Url Vk'),
	        'url_ok' => Yii::t('organizations', 'Url Ok'),
	        'url_instagram' => Yii::t('organizations', 'Url Instagram'),
	        'url_twitter' => Yii::t('organizations', 'Url Twitter'),
	        'working_days' => Yii::t('organizations', 'Рабочие дни'),
	        'working_hours' => Yii::t('organizations', 'Время работы'),
	        'lunch_time' => Yii::t('organizations', 'Время обеда'),
	        'weekend' => Yii::t('organizations', 'Выходные'),

	        'user_name' => Yii::t('organizations', 'Имя'),
	        'user_email' => Yii::t('organizations', 'Email'),
	        'user_telephone' => Yii::t('organizations', 'Телефон'),
        ];
    }

    public static function PublishedStatus(){
	    return [
		    self::STATUS_ACTIVE => 'Да',
		    self::STATUS_DISABLE => 'Нет',
	    ];
	}

    public function getCategory(){
	        return $this->hasMany(Category::className(), ['id' => 'category_id']);
    }

    public function getTelephones(){
    	return $this->hasMany(OrganizationsTelephones::className(), ['organization_id' => 'id']);
    }

    public function getAddresses(){
    	return $this->hasMany(OrganizationsAddress::className(), ['organization_id' => 'id']);
    }

    public function getStatus(){
    	return $this->published;
    }
}

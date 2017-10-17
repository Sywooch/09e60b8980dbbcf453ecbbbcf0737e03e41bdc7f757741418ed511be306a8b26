<?php

namespace app\modules\filters\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property int $published
 * @property int $category_id
 * @property string $image
 */
class Filters extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;

	const CATEGORY_SHARES = 0;
	const CATEGORY_POSTER = 1;
	const CATEGORY_ADS = 2;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%filters}}';
    }

	/**
	 * @inheritdoc
	 */
//	public function behaviors()
//	{
//		return [
//			'timestamp' => [
//				'class' => TimestampBehavior::className(),
//				'attributes' => [
//					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
//					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
//				],
//				'value' => new Expression('NOW()'),
//			]
//		];
//	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['published','parent_id'], 'integer'],
            [['title','category_id'], 'required'],
            [['title', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('filters', 'ID'),
            'parent_id' => Yii::t('filters', 'Родительский фильтр'),
            'title' => Yii::t('filters', 'Название'),
            'published' => Yii::t('filters', 'Опубликовано'),
            'image' => Yii::t('filters', 'Иконка'),
            'category_id' => Yii::t('filters', 'Раздел'),
        ];
    }

	public function getParent(){
		return $this->hasOne(self::className(), ['id' => 'parent_id']);
	}

	public static function ListOfCategories($category_id = null)
	{
		$types = [
			self::CATEGORY_SHARES => 'Акции',
			self::CATEGORY_POSTER => 'Афиша',
			self::CATEGORY_ADS => 'Объявления',
		];
		if (is_null($category_id))
			return $types;
		else
			return $types[$category_id];
	}

	public static function ListOfFilters($category_id, $filter_id = null)
	{
		$parents = self::find()->with('parent')
			->where('published = :published', [':published' => self::STATUS_ACTIVE])
			->andWhere('category_id = :category_id', [':category_id' => $category_id])
			->distinct(true)
			->all();

		return ArrayHelper::map($parents, 'id', 'title');
	}
}

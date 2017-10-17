<?php

namespace app\modules\organizations\models;

use kartik\tree\models\TreeTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property int $root
 * @property string $name
 * @property int $published
 * @property string $image
 */
class Category extends \yii\db\ActiveRecord
{
	use TreeTrait;


	public $activeOrig;
	public $nodeRemovalErrors;
	public $nodeActivationErrors;


	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organizations_category}}';
    }

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['root', 'lft', 'rgt', 'lvl', 'icon_type', 'active', 'selected', 'disabled', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all'], 'integer'],
			[['name'], 'required'],
			[['name'], 'string', 'max' => 60],
			[['icon'], 'string', 'max' => 255],
		];
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('organizations', 'ID'),
            'root' => Yii::t('organizations', 'Родительская категория'),
            'name' => Yii::t('organizations', 'Название'),
            'published' => Yii::t('organizations', 'Опубликовано'),
            'icon' => Yii::t('organizations', 'Иконка'),
            'active' => Yii::t('organizations', 'Опубликовать'),
        ];
    }

	public function getParent(){
		return $this->hasOne(Category::className(), ['id' => 'root']);
	}

	public static function ListOfCategories()
	{
		$parents = self::find()->with('parent')
			//->where('published = :published', [':published' => Category::STATUS_ACTIVE])
			->distinct(true)
			->all();

		return ArrayHelper::map($parents, 'id', 'name', function($item) {
			return isset($item->parent['name']) ?  $item->parent['name']:'';
		});
	}
}

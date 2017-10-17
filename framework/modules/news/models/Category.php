<?php

namespace app\modules\news\models;

use Yii;

/**
 * This is the model class for table "{{%news_category}}".
 *
 * @property int $id
 * @property string $title
 * @property int $published
 */
class Category extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['published'], 'integer'],
            [['image'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('news', 'ИД'),
            'title' => Yii::t('news', 'Название'),
            'published' => Yii::t('news', 'Опубликовать'),
            'image' => Yii::t('news', 'Изображение'),
        ];
    }
}

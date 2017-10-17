<?php

namespace app\modules\news\models;

use Yii;

/**
 * This is the model class for table "news_image".
 *
 * @property int $id
 * @property int $news_id
 * @property string $image
 * @property int $sort_order
 */
class NewsImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id', 'image'], 'required'],
            ['sort_order', 'safe'],
            [['news_id', 'sort_order'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
            'image' => 'Image',
            'sort_order' => 'Sort Order',
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "help".
 *
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string $link
 */
class Help extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'help';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['name', 'text'], 'required'],
            [['name', 'text', 'link'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'text' => 'Текст',
            'link' => 'Ссылка на видео',
        ];
    }
}

<?php

namespace app\modules\buttons\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%buttons}}".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $telephone
 * @property string $image
 * @property int $section
 * @property int $order
 * @property int $section_id
 * @property int $published
 * @property int $platform
 * @property string $created_at
 * @property string $updated_at
 */
class Buttons extends ActiveRecord {

  const STATUS_ACTIVE = 1;
  const STATUS_DISABLE = 0;

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return '{{%buttons}}';
  }

  /**
   * @inheritdoc
   */
  public function behaviors() {
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
  public function rules() {
    return [
        [['title'], 'required'],
        [['section', 'section_id', 'published', 'order', 'platform'], 'integer'],
        [['created_at', 'updated_at'], 'safe'],
        [['title', 'url', 'telephone', 'image'], 'string', 'max' => 255],
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels() {
    return [
        'id' => 'ID',
        'title' => 'Название',
        'platform' => 'Платформа',
        'url' => 'Ссылка',
        'telephone' => 'Телефон',
        'published' => 'Опубликовать',
        'image' => 'Изображение',
        'order' => 'Позиция',
        'section' => 'Категория',
        'section_id' => 'ID в категории',
        'created_at' => 'Create At',
        'updated_at' => 'Updated At',
    ];
  }

  public static function ListOfCategories() {
    return \MTD::getName();
  }

}

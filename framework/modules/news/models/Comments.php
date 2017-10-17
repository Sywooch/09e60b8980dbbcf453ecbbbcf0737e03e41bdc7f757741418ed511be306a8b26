<?php

namespace app\modules\news\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "comments".
 *
 * @property string $id
 * @property int $news_id
 * @property string $author
 * @property string $comment
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Comments extends \yii\db\ActiveRecord
{
	const STATUS_NEW = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_HIDDEN = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
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
            [['news_id', 'author', 'comment'], 'required'],
            [['news_id'], 'integer'],
            [['status'], 'default', 'value'=> self::STATUS_NEW],
            [['author', 'comment'], 'string'],
            [['created_at', 'updated_at', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '##',
            'news_id' => 'ID Новости',
            'author' => 'Имя',
            'comment' => 'Комментарий',
            'status' => 'Опубликовано',
            'news' => 'Новость',
            'created_at' => 'Дата',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getNews(){
		return $this->hasOne(News::className(), ['id' => 'news_id'])->with('data');
    }
}

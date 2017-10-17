<?php

namespace app\modules\communication\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "comments".
 *
 * @property string $id
 * @property int $comm_id
 * @property int $user_id
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
		return '{{%communication_comments}}';
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
			[['comm_id', 'user_id','text'], 'required'],
			[['comm_id', 'user_id', 'status'], 'integer'],
			[['text'], 'string'],
			[['created_at', 'updated_at'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'comm_id' => 'Comm ID',
			'user_id' => 'User ID',
			'text' => 'Text',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		];
	}

}

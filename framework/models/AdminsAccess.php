<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%admins_access}}".
 *
 * @property int $admin_id
 * @property string $access
 * @property int $value
 */
class AdminsAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admins_access}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id', 'access', 'value'], 'required'],
            [['admin_id', 'value'], 'integer'],
            [['access'], 'string', 'max' => 255],
            [['admin_id', 'access', 'value'], 'unique', 'targetAttribute' => ['admin_id', 'access', 'value']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => 'Admin ID',
            'access' => 'Access',
            'value' => 'Value',
        ];
    }
}

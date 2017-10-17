<?php

namespace app\modules\organizations\models;

use Yii;

/**
 * This is the model class for table "organizations_address".
 *
 * @property int $organization_id
 * @property string $address
 * @property string $working_days
 * @property string $weekend
 * @property string $working hours
working hours
working hours
working_hours
 * @property string $lunch_time
 */
class OrganizationsAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organizations_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id'], 'required'],
            [['organization_id'], 'integer'],
            [['address'], 'string'],
            [['working_days', 'working_hours', 'lunch_time', 'weekend', 'lunch_time'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'organization_id' => Yii::t('organizations', 'Organization ID'),
            'address' => Yii::t('organizations', 'Address'),
            'working_days' => Yii::t('organizations', 'Working Days'),
            'weekend' => Yii::t('organizations', 'Weekend'),
            'working_hours' => Yii::t('organizations', 'Working Hours'),
            'lunch_time' => Yii::t('organizations', 'Lunch Time'),
        ];
    }
}
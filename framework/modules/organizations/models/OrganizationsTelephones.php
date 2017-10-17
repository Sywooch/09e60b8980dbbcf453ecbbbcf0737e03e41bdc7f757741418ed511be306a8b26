<?php

namespace app\modules\organizations\models;

use Yii;

/**
 * This is the model class for table "organizations_telephones".
 *
 * @property int $organization_id
 * @property string $number
 */
class OrganizationsTelephones extends \yii\db\ActiveRecord
{
	public $numbers;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organizations_telephones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'number', 'numbers'], 'safe'],
            [['organization_id'], 'integer'],
            [['number'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'organization_id' => Yii::t('organizations', 'Organization ID'),
            'number' => Yii::t('organizations', 'Номер телефона(ов)'),
            'numbers' => Yii::t('organizations', 'Номер телефона(ов)'),
        ];
    }
}

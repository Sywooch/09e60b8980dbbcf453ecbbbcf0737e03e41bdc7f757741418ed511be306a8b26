<?php

namespace app\modules\organizations\models;

use Yii;

/**
 * This is the model class for table "organizations_images".
 *
 * @property int $organization_id
 * @property string $image
 * @property int $sort_order
 */
class OrganizationsImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organizations_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'image'], 'required'],
            [['organization_id', 'sort_order'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'organization_id' => Yii::t('organizations', 'Organization ID'),
            'image' => Yii::t('organizations', 'Image'),
            'sort_order' => Yii::t('organizations', 'Sort Order'),
        ];
    }
}

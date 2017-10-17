<?php

namespace app\modules\organizations\models;

use Yii;

/**
 * This is the model class for table "organizations_sites".
 *
 * @property int $organization_id
 * @property string $tag
 * @property string $url
 */
class OrganizationsSites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organizations_sites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'tag', 'url'], 'required'],
            [['organization_id'], 'integer'],
            [['tag'], 'string', 'max' => 16],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'organization_id' => Yii::t('organizations', 'Organization ID'),
            'tag' => Yii::t('organizations', 'Tag'),
            'url' => Yii::t('organizations', 'Url'),
        ];
    }
}

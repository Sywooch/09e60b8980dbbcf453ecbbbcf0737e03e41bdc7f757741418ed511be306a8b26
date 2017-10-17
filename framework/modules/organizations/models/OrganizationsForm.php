<?php

namespace app\modules\organizations\models;

use Yii;
use yii\base\Model;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%organizations}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $category_id
 * @property string $image
 * @property int $published
 * @property OrganizationsTelephones $telephones
 * @property Organizations $organization
 */
class OrganizationsForm extends Model
{
	public $organization;
	public $telephones;
	public $addresses;
	public $sites;

}

<?php
/********************************
 * Created by GoldenEye.
 * ICQ 285652 / email : slims.alex@gmail.com
 * WEB: http://scriptsweb.ru
 * copyright 2010 - 2017
 ********************************/

namespace app\modules\v1\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadAvatar extends Model
{
	/**
	 * @var UploadedFile
	 */
	public $imageFile;

	public function rules()
	{
		return [
			[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'
			],
		];
	}

	public function upload($dir)
	{
		if($this->imageFile->saveAs($dir . $this->imageFile->baseName . '.' . $this->imageFile->extension))
			return true;
		else
			return false;
	}
}
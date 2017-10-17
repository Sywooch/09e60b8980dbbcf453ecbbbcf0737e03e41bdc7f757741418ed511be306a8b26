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

class UploadFiles extends Model
{
	/**
	 * @var UploadedFile
	 */
	public $image;

	public function rules()
	{
		return [
			['image', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, ico, jpg', 'maxFiles' => 10],
			//['image', 'file', 'skipOnEmpty' => true, 'extensions' => 'png', 'maxFiles' => 10],
		];
	}
}
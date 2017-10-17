<?php
	/********************************
	 * Created by GoldenEye.
	 * ICQ 285652 / email : slims.alex@gmail.com
	 * WEB: http://scriptsweb.ru
	 * copyright 2010 - 2017
	 ********************************/

	namespace app\models;

	use yii\base\Model;
	use yii\web\UploadedFile;

	class UploadForm extends Model
	{
		/**
		 * @var UploadedFile[]
		 */
		public $imageFile;

		public function rules()
		{
			return [
				[['imageFile'], 'file', 'skipOnEmpty' => false , 'extensions' => 'jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF'],
			];
		}

		public function upload($dir)
		{
			if ($this->validate()) {
				if($this->imageFile->saveAs($dir . $this->imageFile->baseName . '.' . $this->imageFile->extension))
					return true;
				else
					return false;
			} else {
				return false;
			}
		}
	}
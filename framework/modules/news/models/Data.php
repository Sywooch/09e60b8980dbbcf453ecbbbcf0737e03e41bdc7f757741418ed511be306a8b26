<?php
/********************************
 * Created by GoldenEye.
 * ICQ 285652 / email : slims.alex@gmail.com
 * WEB: http://scriptsweb.ru
 * copyright 2010 - 2015
 ********************************/
namespace app\modules\news\models;
use app\modules\news\Module;
use yii\db\ActiveRecord;
	
class Data extends ActiveRecord {

	public static function tableName()
	{
		return '{{%news_data}}';
	}

    function rules()
    {
        return [
            [['title','text', 'seo_title', 'seo_description', 'seo_keywords'], 'safe']
        ];
    }

	function attributeLabels()
	{
		return array(
			'language' => Module::t('index', 'language'),
			'title' => Module::t('index', 'title'),
			'text' => Module::t('index', 'text'),
			'description' => Module::t('index', 'description'),
			'seo_title' => Module::t('index', 'seo.title'),
			'seo_keywords' => Module::t('index', 'seo.keywords'),
			'seo_description' => Module::t('index', 'seo.description'),
		);
	}
}

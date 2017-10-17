<?php
/********************************
 * Created by GoldenEye.
 * ICQ 285652 / email : slims.alex@gmail.com
 * WEB: http://scriptsweb.ru
 * copyright 2010 - 2015
 ********************************/

namespace app\modules\news;

use yii;

class Module extends yii\base\Module
{
    public function init()
    {
        parent::init();
        // инициализация модуля с помощью конфигурации, загруженной из config.php
        Yii::configure($this, require(__DIR__ . '/config.php'));
        // Register translation
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/news/*'] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'basePath'       => '@app/modules/news/messages',
            'fileMap'        => [
                'modules/news/index' => 'index.php',
                'modules/news/menu' => 'menu.php',
                'modules/news/types' => 'types.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/news/' . $category, $message, $params, $language);
    }
}

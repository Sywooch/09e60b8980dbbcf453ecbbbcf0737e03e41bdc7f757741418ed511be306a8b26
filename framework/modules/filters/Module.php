<?php
/********************************
 * Created by GoldenEye.
 * ICQ 285652 / email : slims.alex@gmail.com
 * WEB: http://scriptsweb.ru
 * copyright 2010 - 2015
 ********************************/

namespace app\modules\filters;

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
        Yii::$app->i18n->translations['modules/filters/*'] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'basePath'       => '@app/modules/filters/messages',
            'fileMap'        => [
                'modules/filters/index' => 'index.php',
                'modules/filters/menu' => 'menu.php',
                'modules/filters/types' => 'types.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/filters/' . $category, $message, $params, $language);
    }
}

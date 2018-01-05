<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'Goroda',
    'name' => 'OOO Города',
    'language' => 'ru',
    'charset' => 'UTF-8',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'news' => ['class' => 'app\modules\news\Module'],
        'organizations' => ['class' => 'app\modules\organizations\Module'],
        'shares' => ['class' => 'app\modules\shares\Module'],
        'poster' => ['class' => 'app\modules\poster\Module'],
        'filters' => ['class' => 'app\modules\filters\Module'],
        'ads' => ['class' => 'app\modules\ads\Module'],
        'advertising' => ['class' => 'app\modules\advertising\Module'],
        'advertising_banner' => ['class' => 'app\modules\advertising_banner\Module'],
        'notice' => ['class' => 'app\modules\notice\Module'],
        'communication' => ['class' => 'app\modules\communication\Module'],
        'buttons' => ['class' => 'app\modules\buttons\Module'],
        'treemanager' => ['class' => '\kartik\tree\Module'],
        'v1' => ['class' => 'app\modules\v1\Module']
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '14bv0TyorHnGmHp6uZS-q4XQkZaFRDS0',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'sd-100081.dunpal.com',
                'username' => 'no-reply@api.ooogoroda.mobi',
                'password' => 'vaZLKmpNFL',
                'port' => '587',
                'encryption' => 'tls',
                'streamOptions' => [
                    'ssl' => [
                        'verify_peer' => false,
                        'allow_self_signed' => true
                    ],
                ],
            ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                # Defaults
                '' => 'site/index',
                'login' => 'site/login',
                'restore' => 'site/restore-password',
                'reset-password' => 'site/reset-password',
                'site/captcha' => 'site/captcha',
                'logout' => 'site/logout',
                # Category tree manager
                'treemanager/<controller:\w+>/<action:[\w_-]+>' => 'treemanager/<controller>/<action>',
                'treemanager/<controller:\w+>' => 'treemanager/<controller>/index',
                #File manager
                'filemanager/<action:\w+>' => 'upload/<action>',
                /*
                 * Api
                 */
                'api/v1/user/reset_password_request' => 'v1/user/reset-password-request',
                'api/v1/user/reset_password' => 'v1/user/reset-password',
                'api/v1/user/change_password' => 'v1/user/change-password',
                'api/v1/filters/<type:[\d]+>' => 'v1/filters/index',
                'api/v1/<controller:[\w_-]+>/<action:[\w_-]+>/<id:[\d]+>' => 'v1/<controller>/<action>',
                'api/v1/<controller:[\w_-]+>/<action:[\w_-]+>/type/<type:\w+>/page/<page:\w+>' => 'v1/<controller>/<action>',
                'api/v1/<controller:[\w_-]+>/<action:[\w_-]+>' => 'v1/<controller>/<action>',
                'api/v1/<controller:[\w_-]+>' => 'v1/<controller>/index',
                # Static controllers
                '<controller:(admins|users|help|settings)>/<action:\w+>' => '<controller>/<action>',
                '<controller:(admins|users|help|settings)>/<id:\d+>/<action:\w+>' => '<controller>/<action>',
                '<controller:(admins|users|help|settings)>/<id:\d+>' => '<controller>/view',
                '<controller:(admins|users|help|settings)>' => '<controller>/index',
                # Backend route modules
                '<module:\w+>/<action:[\w_-]+>/<id:[\d]+>' => '<module>/backend/default/<action>',
                '<module:\w+>/<action:[\w_-]+>/type/<type:\w+>' => '<module>/backend/default/<action>',
                '<module:\w+>/<action:[\w_-]+>' => '<module>/backend/default/<action>',
                '<module:\w+>/<controller:\w+>/<action:[\w_-]+>' => '<module>/backend/<controller>/<action>',
                '<module:\w+>/<controller:\w+>' => '<module>/backend/<controller>/index',
                '<module:\w+>' => '<module>/backend/default/index',
            ],
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/views',
                'baseUrl' => '/themes/admin'
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource'
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'imageresize' => [
            'class' => 'noam148\imageresize\ImageResize',
            //path relative web folder
            'cachePath' => 'uploads/cache',
            //use filename (seo friendly) for resized images else use a hash
            'useFilename' => false,
            //show full url (for example in case of a API)
            'absoluteUrl' => true,
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i',
            'timeFormat' => 'php:H:i:s',
            'defaultTimeZone' => 'CET'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '46.162.203.50'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '46.162.203.50'],
    ];
}

return $config;

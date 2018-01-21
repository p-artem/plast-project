<?php
$config = [
    'name'=>'Plast-project',
    'vendorPath'=>dirname(dirname(__DIR__)).'/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage'=>'en',
    'language'=>'ru-RU',
//    'locale'=>'ru-RU',
    'bootstrap' => ['log'],
    'timezone' => 'Europe/Kiev',
    'components' => [

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%rbac_auth_item}}',
            'itemChildTable' => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable' => '{{%rbac_auth_rule}}'
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
            'defaultDuration' => 99999
        ],
        'frontendCache' => require(Yii::getAlias('@frontend/config/_cache.php')),

        'commandBus' => [
            'class' => 'trntv\bus\CommandBus',
            'middlewares' => [
                [
                    'class' => '\trntv\bus\middlewares\BackgroundCommandMiddleware',
                    'backgroundHandlerPath' => '@console/yii',
                    'backgroundHandlerRoute' => 'command-bus/handle',
                ]
            ]
        ],

        'formatter'=>[
            'class'=>'yii\i18n\Formatter',
            'dateFormat' => 'long',
//            'locale' => 'ru-RU',
            'currencyCode' => 'UAH',
            'decimalSeparator' => '.',
            'thousandSeparator' => '&nbsp;',
//            'numberFormatterTextOptions' => [
//                NumberFormatter::CURRENCY_SYMBOL => Yii::t('site', 'UAH')
//            ],
            'numberFormatterOptions' => [
//                NumberFormatter::MAX_FRACTION_DIGITS => 0,
                NumberFormatter::FRACTION_DIGITS => 0,
            ],
            'nullDisplay' => '',
        ],

        'glide' => [
            'class' => 'trntv\glide\components\Glide',
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/cache',
            'urlManager' => 'urlManagerStorage',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey' => env('GLIDE_SIGN_KEY')
        ],

        'db'=>[
            'class'=>'yii\db\Connection',
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => 'utf8',
            'enableSchemaCache' => true, //YII_ENV_PROD
//            'enableQueryCache' => true,
        ],
        'db_all'=>[
            'class'=>'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=3306;',
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => 'utf8',
//            'enableSchemaCache' => true, //YII_ENV_PROD
//            'enableQueryCache' => true,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'db'=>[
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'except'=>['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix'=>function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars'=>[],
                    'logTable'=>'{{%system_log}}'
                ]
            ],
        ],
        'i18n' => [
            'translations' => [
                'app'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                ],
                'common'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                ],
                'backend'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                ],
                'frontend'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                ],
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'db' => 'db',
                    'sourceLanguage' => 'en', // Developer language
                    'sourceMessageTable' => '{{%language_source}}',
                    'messageTable' => '{{%language_translate}}',
                    'cachingDuration' => 86400,
                    'enableCaching' => true,
                    'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
                ],
//                 // Uncomment this code to use DbMessageSource
//                 '*'=> [
//                    'class' => 'yii\i18n\DbMessageSource',
//                    'sourceMessageTable'=>'{{%i18n_source_message}}',
//                    'messageTable'=>'{{%i18n_message}}',
//                    'enableCaching' => YII_ENV_DEV,
//                    'cachingDuration' => 3600,
//                    'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
//                 ],
              ],
        ],

        'fileStorage' => [
            'class' => '\trntv\filekit\Storage',
            'baseUrl' => '@storageUrl/source',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@storage/web/source'
            ],
            'as log' => [
                'class' => 'common\behaviors\FileStorageLogBehavior',
                'component' => 'fileStorage'
            ]
        ],

        'keyStorage' => [
            'class' => 'common\components\keyStorage\KeyStorage'
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
//            'useFileTransport' => true,
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('ROBOT_HOST'),
                'username' => env('ROBOT_EMAIL'),
                'password' => env('ROBOT_PASS'),
                'port' => env('ROBOT_PORT'),
                'encryption' => env('ROBOT_ENCRYPTION'),
            ],
//            'messageConfig' => [
//                'charset' => 'UTF-8',
//                'from' => env('ADMIN_EMAIL')
//            ]
        ],
        'appSettings' => [
            'class' => \common\components\AppSettings::className(),
            'modelClass' => \common\models\Setting::className(),
            'settingsKey' => 1
        ],

        'urlManagerBackend' => \yii\helpers\ArrayHelper::merge(
            [
                'baseUrl' => Yii::getAlias('@backendUrl')
            ],
            require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
            [
                'baseUrl' => Yii::getAlias('@frontendUrl'),
//                'hostInfo'=> Yii::getAlias('@frontendUrl')
  ],
            require(Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage' => \yii\helpers\ArrayHelper::merge(
            [
                'baseUrl'=>Yii::getAlias('@storageUrl')
            ],
            require(Yii::getAlias('@storage/config/_urlManager.php'))
        )
    ],
    'params' => [
        'adminEmail' => env('ADMIN_EMAIL'),
        'robotEmail' => env('ROBOT_EMAIL'),
        'developerEmail' => env('DEVELOPER_EMAIL'),
        'availableLocales'=>[
            'ru-RU'=>'Русский (РФ)',
//            'en-US'=>'English (US)',
//            'uk-UA'=>'Українська (Україна)',
//            'es' => 'Español',
//            'zh-CN' => '简体中文',
        ],
    ],
];

if (YII_ENV_PROD) {
    $config['components']['log']['targets']['email'] = [
        'class' => 'yii\log\EmailTarget',
        'except' => ['yii\web\HttpException:*'],
        'levels' => ['error'/*, 'warning'*/],
        'message' => ['from' => env('ROBOT_EMAIL'), 'to' => env('DEVELOPER_EMAIL')]
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'=>'yii\gii\Module'
    ];

    $config['components']['cache'] = [
        'class' => 'yii\caching\DummyCache'
    ];
//    $config['components']['mailer']['transport'] = [
//        'class' => 'Swift_SmtpTransport',
//        'host' => env('SMTP_HOST'),
//        'port' => env('SMTP_PORT'),
//    ];
}

return $config;
<?php
$config = [
    'homeUrl'=>Yii::getAlias('@backendUrl'),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute'=>'timeline-event/index',
    'controllerMap'=>[
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'],
            'roots' => [
                [
                    'baseUrl'=> '@imagesUrl',
                    'basePath'=> '@images',
                    'path'   => '/',
                    'name' => 'Images'
//                    'access' => ['read' => '@', 'write' => '@']
                ],
            ],
        ]
    ],
    'components'=>[
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'enableCsrfValidation' => false,
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            'baseUrl' => '/admin'
        ],
        'user' => [
            'class'=>'yii\web\User',
            'identityClass' => 'common\models\User',
            'loginUrl'=>['sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => 'common\behaviors\LoginTimestampBehavior'
        ],
//        'webshell' => [
//            'class' => 'samdark\webshell\Module',
//            // 'yiiScript' => Yii::getAlias('@root'). '/yii', // adjust path to point to your ./yii script
//            'allowedIPs' => ['127.0.0.1', '::1', '195.39.233.2'],
//            'checkAccessCallback' => function (\yii\base\Action $action) {
//                // return true if access is granted or false otherwise
//                return true;
//            }
//        ],
    ],
    'modules'=>[
        'translatemanager' => [
            'class' => 'lajax\translatemanager\Module',
            'root' => ['@common','@frontend','@backend'],
            'layout' => '/common',
            'allowedIPs' => ['*'],
            'ignoredCategories' => ['yii','app','common','backend','frontend','galleryManager/main'],
        ],
//        'i18n' => [
//            'class' => 'backend\modules\i18n\Module',
//            'defaultRoute'=>'i18n-message/index'
//        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
    ],
    'as globalAccess'=>[
        'class'=>'\common\behaviors\GlobalAccessBehavior',
        'rules'=>[
            [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['login']
            ],
            [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['logout']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions'=>['error']
            ],
            [
                'controllers'=>['debug/default'],
                'allow' => true,
                'roles' => ['administrator'],
            ],
            [
                'controllers'=>['user', 'log'],
                'allow' => true,
                'roles' => ['administrator'],
            ],
            [
                'controllers'=>['user', 'log'],
                'allow' => false,
            ],
            [
                'allow' => true,
                'roles' => ['manager'],
            ]
        ]
    ]
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class'=>'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class'=>'yii\gii\generators\crud\Generator',
                'templates'=>[
                    'yii2-starter-kit' => Yii::getAlias('@backend/views/_gii/templates')
                ],
                'template' => 'yii2-starter-kit',
                'messageCategory' => 'backend'
            ]
        ]
    ];
}

return $config;

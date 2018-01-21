<?php
$config = [
    'homeUrl'=>Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\Module',
            //'shouldBeActivated' => true
        ],
//        'api' => [
//            'class' => 'frontend\modules\api\Module',
//            'modules' => [
//                'v1' => 'frontend\modules\api\v1\Module'
//            ]
//        ]
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'jquery.min.js',
                    ],
                    'jsOptions' => [
                        'defer' => true,
                    ],
                ],
                'yii\web\YiiAsset' => [
                    'jsOptions' => [
                        'defer' => true,
                    ],
                ],
            ],
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'frontend\widgets\ReCaptcha',
            'siteKey' => env('RECAPTCHA_KEY'),
            'secret' => env('RECAPTCHA_SECRET'),
        ],
        // @todo add sitekey


        // Отключение стандартных библиотек
        'assetManager' => [
            'bundles' => [
//                'yii\web\JqueryAsset' => false,
                'yii\bootstrap\BootstrapPluginAsset' => false,
                'yii\bootstrap\BootstrapAsset' => false,
            ],
        ],
        // Отключение стандартных библиотек END

        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                    'clientId' => env('GITHUB_CLIENT_ID'),
                    'clientSecret' => env('GITHUB_CLIENT_SECRET')
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => env('FACEBOOK_CLIENT_ID'),
                    'clientSecret' => env('FACEBOOK_CLIENT_SECRET'),
                    'scope' => 'email,public_profile',
                    'attributeNames' => [
                        'name',
                        'email',
                        'first_name',
                        'last_name',
                    ]
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'page/error'
        ],
        'maintenance' => [
            'class' => 'common\components\maintenance\Maintenance',
            'enabled' => function ($app) {
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY'),
            'baseUrl' => '',
        ],
        'user' => [
            'class'=>'yii\web\User',
            'identityClass' => 'common\models\User',
            'loginUrl'=>['/user/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => 'common\behaviors\LoginTimestampBehavior'
        ]
    ]
];

 if (YII_ENV_DEV) {
     $config['modules']['gii'] = [
         'class'=>'yii\gii\Module',
         'generators'=>[
             'crud'=>[
                 'class'=>'yii\gii\generators\crud\Generator',
                 'messageCategory'=>'frontend'
             ]
         ]
     ];
 }

return $config;

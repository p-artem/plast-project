<?php
$config = [
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'linkAssets' => env('LINK_ASSETS'),
            'appendTimestamp' => true,
        ]
    ],
    'as locale' => [
        'class' => 'common\behaviors\LocaleBehavior',
        'enablePreferredLanguage' => true
    ],
    'modules' => [
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => '@storage/web/source',
            'uploadUrl' => '@storage/web/source',
            'imageAllowExtensions'=>['jpg','png','gif']
        ],
//        'yii2images' => [
//            'class' => 'rico\yii2images\Module',
//            'defaultRoute'=>'admin/images/images',
//            //be sure, that permissions ok
//            //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
//            'imagesStorePath' => Yii::getAlias('@images'), //path to origin images
//            'imagesCachePath' => Yii::getAlias('@images/cache'), //path to resized copies
//            'graphicsLibrary' => 'imagick', //but really its better to use 'Imagick'
////            'placeHolderPath' => Yii::getAlias('@storage').'/web/source/images/placeHolder.png', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
//        ],
    ],
];

 if (YII_DEBUG) {
      $config['bootstrap'][] = 'debug';
      $config['modules']['debug'] = [
          'class' => 'yii\debug\Module',
          'allowedIPs' => ['127.0.0.1', '::1', '195.39.233.2', '85.90.214.153'],
      ];
 }

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'allowedIPs' => ['127.0.0.1', '::1', '195.39.233.2', '85.90.214.153'],
    ];
}


return $config;

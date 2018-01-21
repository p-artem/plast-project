<?php
return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'components' => [
        'urlManager' => require(__DIR__.'/_urlManager.php'),
//        'frontendCache' => require(Yii::getAlias('@frontend/config/_cache.php')),
       /* 'i18n' => [
            'translations' => [
                '*'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                    'fileMap'=>[
                        'common'=>'common.php',
                        'backend'=>'backend.php',
                        'frontend'=>'frontend.php',
                    ],
                    'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
                ],
            ],
        ],*/
    ],
];

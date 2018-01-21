<?php
return [
    'id' => 'frontend',
    'basePath' => dirname(__DIR__),
    'components' => [
        'urlManager' => require(__DIR__.'/_urlManager.php'),
        'cache' => require(__DIR__.'/_cache.php'),
		'view' => [
            'class' => '\rmrevin\yii\minify\View',
            'enableMinify' => YII_ENV_PROD,
            'concatCss' => false, // concatenate css
            'minifyCss' => false, // minificate css
            'concatJs' => false, // concatenate js
            'minifyJs' => true, // minificate js
            'minifyOutput' => true, // minificate result html page
            'webPath' => '@web', // path alias to web base
            'basePath' => '@webroot', // path alias to web base
            'minifyPath' => '@webroot/minify', // path alias to save minify result
            'jsPosition' => [ \yii\web\View::POS_END ], // positions of js files to be minified
            'jsOptions' => [ 'defer' => true ],
            'forceCharset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expandImports' => true, // whether to change @import on content
            'compressOptions' => ['extra' => true], // options for compress
            'excludeFiles' => [
            ],
            'excludeBundles' => [
            ],
        ],
    ],
];

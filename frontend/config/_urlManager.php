<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        ['pattern'=>'off', 'route'=>'off/index'],
        // Product
        ['pattern' => '<controller:(catalog)>/<categoryslug>/<slug>', 'route' => 'product/view'],
        ['pattern'=>'<controller:(catalog)>/<categoryslug>', 'route'=>'product/index', 'defaults' => ['categoryslug' => '']],

        // Article

        ['pattern' => '<controller:(news)>/<rubric>/<slug>', 'route' => 'article/view'],
        ['pattern'=>'<controller:(news)>/<rubric>', 'route'=>'article/index', 'defaults' => ['rubric' => '']],

        // Pages

        ['pattern'=>'', 'route'=>'page/home'],
        ['pattern'=>'template', 'route'=>'page/html-template'],
        ['pattern'=>'contacts', 'route'=>'page/contacts'],
        ['pattern'=>'<slug>', 'route'=>'page/view'],
    ]
];

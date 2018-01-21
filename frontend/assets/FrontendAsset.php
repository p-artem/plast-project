<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/animate.css',
        'css/owl.carousel.css',
        'css/owl.theme.css',
        'libs/cusel-min-2.5/sel-style.css',
        'css/pulse-style.css',
        'css/style.css',
    ];

    public $js = [
//        'js/jquery-2.1.3.min.js',
        'js/bootstrap.min.js',
        'js/owl.carousel.js',
        'js/jquery.hoverdir.js',
        'libs/cusel-min-2.5/cusel-min-2.5.js',
//        'libs/owl-carousel.2.4/owl.carousel.min.js',
        'js/app.js',
    ];

    public $jsOptions = [
        'defer' => true,
    ];

    public $depends = [
        'yii\web\YiiAsset',
//         'yii\bootstrap\BootstrapAsset',
        'common\assets\Html5shiv',
    ];


}

<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 7/3/14
 * Time: 3:14 PM
 */

namespace backend\assets;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/style.css',
        'css/cust-style.css'
    ];
    public $js = [
        'js/app.js'
    ];

    public $depends = [
        'backend\assets\BonsaiAsset',
        'yii\web\YiiAsset',
        'common\assets\AdminLte',
        'common\assets\Html5shiv'
    ];
}

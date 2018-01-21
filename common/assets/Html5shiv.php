<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 7/3/14
 * Time: 8:16 PM
 */

namespace common\assets;

use yii\web\AssetBundle;

class Html5shiv extends AssetBundle
{
    public $sourcePath = '@bower/html5shiv';
    public $js = [
        'dist/html5shiv.min.js'
    ];

    public $jsOptions = [
   	    'defer' => true,
        'condition'=>'lt IE 9'
    ];
}

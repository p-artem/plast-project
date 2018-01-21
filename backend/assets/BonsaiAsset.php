<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 7/3/14
 * Time: 3:14 PM
 */

namespace backend\assets;

use yii\web\AssetBundle;

class BonsaiAsset extends AssetBundle
{
    public $sourcePath = '@bower';

    public $css = [
        'jquery-bonsai/jquery.bonsai.css',
        'jquery-bonsai/assets/svg-icons.css'
    ];
    public $js = [
        'jquery-qubit/jquery.qubit.js',
        'jquery-bonsai/jquery.bonsai.js'
    ];

    public $depends = [
        'yii\web\YiiAsset'
    ];
}

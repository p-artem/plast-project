<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 04.04.17
 * Time: 17:15
 */

namespace backend\helpers;


use yii\helpers\Inflector as BaseInflector;

class Inflector extends BaseInflector
{
    public static function langId2underscore($words){
        return '_' . strtolower(preg_replace('/-| /', '_', $words));
    }

}
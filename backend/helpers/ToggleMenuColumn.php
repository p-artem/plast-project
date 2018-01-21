<?php

namespace backend\helpers;

use pheme\grid\ToggleColumn;


/**
 * Class ToggleMenuColumn
 * @package backend\helpers
 */
class ToggleMenuColumn extends ToggleColumn
{
    /**
     * Toggle action that will be used as the toggle action in your controller
     * @var string
     */
    public $action = 'toggle-menu';
}
<?php

namespace frontend\widgets;

use common\models\Slider;
use Yii;
use yii\base\Widget;
use common\models\Banner;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class BannerWidget
 * @package frontend\widgets
 */
class SliderWidget extends Widget
{
    public $itemTemplate = '';
    public $items = [];
    public $blocks = 1;
    public $partsLayout = '';

    /**
     * @return string
     */
    public function run()
    {
        if($this->itemTemplate){
            return $this->renderItems();
        }
        return '';
    }

    /**
     * @return string
     */
    protected function renderItems()
    {
        $output = '';


        if($this->blocks > 1 && $this->partsLayout){
            $partsOutput = '';
            $cnt = 1;
            $count = count($this->items);
            foreach ($this->items as $key => $item){
                $partsOutput .= $this->renderItem($item, $key);
                if($cnt%$this->blocks == 0 || $count == $cnt){
                    $output .= strtr($this->partsLayout,[
                        '{items}' => $partsOutput
                    ]);
                    $partsOutput = '';
                }
                $cnt++;
            }
        } else {
            foreach ($this->items as $key => $item){
                $output .= $this->renderItem($item, $key);
            }
        }
        return $output;
    }

    /**
     * @param $model Slider
     * @param int $key
     * @return string
     */
    protected function renderItem($model, $key)
    {
        $content = '';
        if (is_string($this->itemTemplate)) {
            $content = $this->getView()->render($this->itemTemplate, [
                'model' => $model,
                'key' => $key,
                'widget' => $this,
            ]);
        }
        return $content;
    }
}
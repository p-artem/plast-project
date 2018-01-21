<?php
namespace frontend\widgets;

use yii;
use yii\helpers\Html;

/**
 * Class SocialWidget
 * @package frontend\widgets
 */
class SocialWidget extends yii\base\Widget
{
    /**
     * @var
     */
    public $items;

    /**
     * @var string
     */
    public $layout = '<ul>{items}</ul>';

    /**
     * @var string
     */
    public $itemTemplate = '<li>{item}</li>';

    /**
     * @var array
     */
    public $linkOptions = [];

    /**
     * @var array
     */
    public $imageOptions = [];

    /**
     * @return string
     */
    public function run()
    {
        if(empty($this->items)){
            return '';
        }
        $items = $this->renderItems();
        echo strtr($this->layout,['{items}' => implode(PHP_EOL,$items)]);
    }

    /**
     * @return array
     */
    protected function renderItems()
    {
        $tag = yii\helpers\ArrayHelper::remove($this->imageOptions,'tag','img');

        $result = [];
        foreach ($this->items as $item){
            if($tag == 'img'){
                $options = array_merge(['src'=>$item->imageUrl],$this->imageOptions);
            }else{
                $options = array_merge(['style' => 'background-image:url('.$item->imageUrl . ');'],$this->imageOptions);
            }

            $result[] = strtr($this->itemTemplate,
                ['{item}' => Html::a(
                    Html::tag($tag,'',$options),
                    $item->link,
                    $this->linkOptions
                )]);
        }
        return $result;
    }
}
<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Url;
use yii\bootstrap\Html;

/**
 * Class SocialShareWidget
 * @package frontend\widgets
 */
class SocialShareWidget extends Widget
{
    /**
     * @var string
     */
    public $layout = '<ul>{items}</ul>';
    /**
     * @var string
     */
    public $itemTemplate = '<li><a href="#">{item}</a></li>';
    /**
     * @var string
     */
    public $url;
    /**
     * @var array
     */
    public $activeItems = [];
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $img;
    /**
     * @var string
     */
    public $desc;
    /**
     * @var array
     */
    public $socInfo;
    /**
     * @var string
     */
    public $socImgPath;
    /**
     * @var array
     */
    public $templates = [];
    /**
     * @var array
     */
    protected $_templates = [
        'twitter' => '<a onclick=\'Share.twitter("{url}","{title}")\' class="soc-btn">{imgTag}</a>',
        'fb'      => '<a onclick=\'Share.facebook("{url}","{title}","{img}","{desc}")\' class="soc-btn">{imgTag}</a>',
        'pint'    => '<a onclick=\'Share.pinterest("{url}","{img}")\' class="soc-btn">{imgTag}</a>',
        'gplus'   => '<a onclick=\'Share.google("{url}")\' class="soc-btn">{imgTag}</a>',
    ];

    protected $images = [];

    /**
     * @return mixed
     */
    public function run()
    {
        $this->title = preg_replace('/[^\p{L}0-9 ]/iu',"", $this->title);
        $this->desc  = preg_replace('/[^\p{L}0-9 ]/iu',"", $this->desc);

        $this->url = $this->url ?: Url::canonical();

        foreach ($this->socInfo as $itemInfo){
            $this->images[$itemInfo] = $this->socImgPath . '/' . $itemInfo . '.svg';
        }

        $this->templates = array_merge($this->_templates, $this->templates);
        $this->templates = empty($this->activeItems) ? $this->templates :
            array_intersect_key($this->templates, array_flip($this->activeItems));

        $items = $this->renderItems();

        return strtr($this->layout, ['{items}'=>implode(PHP_EOL, $items)]);
    }

    /**
     * @var $item
     * @return mixed
     */
    public function renderItems()
    {
        $items = [];
        foreach ($this->templates as $key => $template){
            if($imgTag = $this->renderImgTag($key)){
                $items[] = strtr(
                    $this->itemTemplate,
                    [
                        '{item}' => strtr($template, [
                            '{url}'=>$this->url,
                            '{title}'=>$this->title,
                            '{img}'=>$this->img,
                            '{desc}'=>$this->desc,
                            '{imgTag}'=>$imgTag
                        ]),

                    ]
                );
            }
        }

        return $items;
    }

    private function renderImgTag($key){
        return (!empty($this->images[$key])) ? Html::tag('img','',['src' => $this->images[$key]]) : '';
    }
}
<?php

namespace frontend\widgets;

use common\models\Page;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class TopMenuWidget extends SiteMenuWidget
{
    /**
     * @var array
     */
    public $options = ['class' => 'nav navbar-nav navbar-right text-uppercase'];
    /**
     * @var string
     */
    public $linkTemplate = '<a href="{url}" class="{class}"><span>{label}</span></a>';
    /**
     * @var array
     */
    public $itemOptions = ['class' => 'title-mnu-itm'];
    /**
     * @var string
     */
    public $itemClass = 'title-mnu-itm';
    /**
     * @var string
     */
    public $markedItemClass = 'title-mnu-nav accent';
    /**
     * @var array
     */
    public $subItemOptions = [];
    /**
     * @var string
     */
    public $submenuTemplate;
    /**
     * @var string
     */
    public $parentLinkTemplate;
    /**
     * @var string
     */
    public $subLinkTemplate;
    /**
     * @var string
     */
    public $subLabelTemplate;

    /**
     * @param $items
     * @return array
     */
    protected function prepare($items)
    {
        $list = [];
        foreach ($items as $key=>$item) {
            $list[$key] = [
                'label' => $item['name'],
                'url' => [$this->route, $this->slugAttribute => $item['slug']],
                'brief' => (isset($item['brief'])) ? $item['brief'] : '',
            ];
            if (!empty($item['items'])) {
                $list[$key]['items'] = $this->prepare($item['items']);
            }
        }
        return $list;
    }

    /**
     * @param array $items
     * @param int $dept
     * @param bool $sub
     * @return string
     */
    protected function renderItems($items, $dept = 1, $sub = false)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item)
        {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));

            if ($dept < $this->maxDept && !empty($item['items'])) {
                $menu = strtr(ArrayHelper::getValue($item, 'template', $this->parentLinkTemplate), [
                    '{label}'   => $item['label'],
                    '{class}'   => ''
                ]);

                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items'], $dept + 1, true),
                ]);
            } else {
                if ($sub) {
                    $options = $this->subItemOptions;
                    $menu = $this->renderSubItem($item);
                } else {
                    $menu = $this->renderItem($item);
                }
            }

            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }

            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

    /**
     * @param $item
     * @return string
     */
    protected function renderSubItem($item)
    {
        $replace_pairs = ['{label}' => $item['label']];
        $replace_pairs['{brief}'] = $item['brief'] ? "<span class='sub-link-descr'>".$item['brief']."</span>" : '';

        if (isset($item['url'])) {
            $template = $this->subLinkTemplate;
            $replace_pairs['{url}'] = urldecode(Url::to($item['url']));
        } else {
            $template = $this->subLabelTemplate;
        }

        return strtr(ArrayHelper::getValue($item, 'template', $template), $replace_pairs);
    }

    /**
     * @param array $item
     * @return string
     */
    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
            $url = urldecode(Url::to($item['url']));
            $replace_pairs = [
                '{url}' => strrpos($url, 'home') ? '/': $url,
                '{label}' => $item['label'],
            ];
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);
            $replace_pairs = ['{label}' => $item['label']];
        }

        $replace_pairs['{class}'] = $this->itemClass;
        return strtr($template, $replace_pairs);
    }
}
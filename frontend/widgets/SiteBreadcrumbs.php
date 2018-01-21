<?php

namespace frontend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/**
 * Class MyBreadcrumbs
 * @package frontend\widgets
 */
class SiteBreadcrumbs extends Breadcrumbs
{
    /**
     * @var string
     */
    public $itemTemplate = "\n<li itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/WebPage\">{link}<meta itemprop=\"position\" content=\"{pos}\" /></li>\n";

    /**
     * @var string
     */
    public $activeItemTemplate = "<li class=\"active\" itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/WebPage\"><span>{link}</span><meta itemprop=\"position\" content=\"{pos}\" /></li>\n";

    /**
     * @var array
     */
    public $options = [
        'itemscope' => '',
        'itemtype'  => "http://schema.org/BreadcrumbList"
    ];

    /**
     * @var
     */
    public $position = 1;

    /**
     * Renders the widget.
     */
    public function run()
    {
        if (empty($this->links)) return;

        $this->addSchemaToLinks($this->links);
        $this->homeLink = [
            'url'       => Url::to('/', true),
            'label'     => Yii::t('yii', 'Home'),
            'title'     => Yii::t('yii', 'Home'),
            'itemprop'  => "url"
        ];

        $links = [];
        $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
//        dd($this->links);
        foreach ($this->links as $link) {
            if (!is_array($link)) $link = ['label' => $link];
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo '<div class="breadcrumbs hidden-xs hidden-sm">'.Html::tag($this->tag, implode('', $links), $this->options).'</div>';
    }

    /**
     * Renders a single breadcrumb item.
     * @param array $link the link to be rendered. It must contain the "label" element. The "url" element is optional.
     * @param string $template the template to be used to rendered the link. The token "{link}" will be replaced by the link.
     * @return string the rendering result
     * @throws InvalidConfigException if `$link` does not have "label" element.
     */
    protected function renderItem($link, $template)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);
        if (array_key_exists('label', $link)) {
//            echo '---';
//            dump($link);
//            echo '---';
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
        if (isset($link['template'])) {
            $template = $link['template'];
        }
        if (isset($link['url'])) {
            $options = $link;
            unset($options['template'], $options['label'], $options['url']);
            $link = Html::a("<span itemprop=\"name\">$label</span>", $link['url'], $options);
        } else {
//            $url = $link['breadUrl'];
//            $link = "<span itemprop=\"name\">$label</span><meta itemprop=\"url\" content=\"$url\" />";
            $link = $label;
        }
        $result = strtr($template, ['{link}' => $link, '{pos}' => $this->position]);
        $this->position++;
        return $result;
    }

    /**
     * @param $links
     * @return array
     */
    private function addSchemaToLinks($links)
    {
        $this->links = [];
        foreach ($links as $link) {
            if (isset($link['url'])) {
                $link['itemprop'] = 'url';
            }
            $this->links[] = $link;
        }
        return $this->links;
    }
}
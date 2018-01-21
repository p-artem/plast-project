<?php

namespace frontend\widgets;

use Yii;
use Closure;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Menu;

/**
 * Class SiteMenuWidget
 * @package frontend\widgets
 */
class SiteMenuWidget extends Menu
{
    /**
     * @var string the template used to render the body of a menu which is NOT a link.
     * In this template, the token `{label}` will be replaced with the label of the menu item.
     * This property will be overridden by the `template` option set in individual menu items via [[items]].
     */
    public $labelTemplate = '<span>{label}</span>';
    /**
     * @var bool whether to activate parent menu items when one of the corresponding child menu items is active.
     * The activated parent menu items will also have its CSS classes appended with [[activeCssClass]].
     */
    public $activateParents = true;
    /**
     * @var string the route used to determine if a menu item is active or not.
     * If not set, it will use the route of the current request.
     * @see params
     * @see isItemActive()
     */
    public $route;
    public $routeHome;
    /**
     * @var array the parameters used to determine if a menu item is active or not.
     * If not set, it will use `$_GET`.
     * @see route
     * @see isItemActive()
     */
    public $params;
    /**
     * @param int $maxDept the menu lvl to be rendered recursively
     */
    public $maxDept = 10;

    /**
     * @var string
     */
    public $slugAttribute = 'slug';
    /**
     * @var string
     */
    public $subActive;

    /**
     * Renders the menu.
     */
    public function run()
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
        $items = $this->prepare($this->items);
        $items = $this->normalizeItems($items, $hasActiveChild);
        if (!empty($items)) {
            $options = $this->options;
            $tag = ArrayHelper::remove($options, 'tag', 'ul');

            echo Html::tag($tag, $this->renderItems($items), $options);
        }
    }

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
                'url' => $this->routeHome && $item['slug'] == 'home' ?
                    [$this->routeHome] : [$this->route, $this->slugAttribute => $item['slug']]

            ];
            if (!empty($item['items'])) {
                $list[$key]['items'] = $this->prepare($item['items']);
            }
        }
        return $list;
    }

    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @param int $dept the menu lvl to be rendered recursively
     * @return string the rendering result
     */
    protected function renderItems($items, $dept = 1)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
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

            $menu = $this->renderItem($item);
            if ($dept < $this->maxDept && !empty($item['items'])) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items'], $dept + 1),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

    /**
     * Normalizes the [[items]] property to remove invisible items and activate certain items.
     * @param array $items the items to be normalized.
     * @param bool $active whether there is an active child menu item.
     * @return array the normalized menu items
     */
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild) {
                    $active = $items[$i]['active'] = true;
                } elseif ($this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                    unset($items[$i]['url']);
                } elseif ($this->subActive && isset($item['url'][$this->slugAttribute])
                    && $this->subActive == $item['url'][$this->slugAttribute]) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active'] instanceof Closure) {
                $active = $items[$i]['active'] = call_user_func($item['active'], $item, $hasActiveChild, $this->isItemActive($item), $this);
            } elseif ($item['active']) {
                $active = true;
            }
        }
        return array_values($items);
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return bool whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (!(isset($item['url']) && is_array($item['url']) && isset($item['url'][0]))) {
            return false;
        }

        $route = Yii::getAlias($item['url'][0]);
        if ($route[0] !== '/' && Yii::$app->controller) {
            $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
        }
        if (ltrim($route, '/') !== ltrim($this->route,'/')
            && (!isset($this->params['route'])
                || ltrim($this->params['route'],'/') !== ltrim($route, '/'))
        ) {
            return false;
        }
        unset($item['url']['#']);
        if (count($item['url']) > 1) {
            $params = $item['url'];
            unset($params[0]);
            foreach ($params as $name => $value) {
                if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                    return false;
                }
            }
        }
        return true;
    }
}
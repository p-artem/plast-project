<?php

namespace frontend\widgets;

use Yii;
use yii\widgets\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Class LangMenuWidget
 * @package frontend\widgets
 */
class LangMenuWidget extends Menu
{

    /**
     * @var array
     */
    private static $_labels;

    /**
     * @var bool
     */
    private $_isError;

    /**
     *
     */
    public function init()
    {
        $route = Yii::$app->controller->route;
        $appLanguage = Yii::$app->language;
        $params = $_GET;
        $this->_isError = $route === Yii::$app->errorHandler->errorAction;

        array_unshift($params, '/' . $route);

        foreach (Yii::$app->urlManager->languages as $language) {
            $isWildcard = substr($language, -2) === '-*';
            if (
                $language === $appLanguage ||
                // Also check for wildcard language
                $isWildcard && substr($appLanguage, 0, 2) === substr($language, 0, 2)
            ) {
                $active['active'] = true;
                //continue;   // Exclude the current language
            } else {
                $active = [];
            }

            if ($isWildcard) {
                $language = substr($language, 0, 2);
            }
            $params['language'] = $language;
            $this->items[] = array_merge([
                'label' => self::label($language),
                'url' => $params,
            ], $active);
        }
    }

    public static function label($code)
    {
        if (self::$_labels === null) {
            self::$_labels = [
                'en-US' => 'English',
                'ru-RU' => 'Русский',
            ];
        }

        return isset(self::$_labels[$code]) ? self::$_labels[$code] : null;
    }

    /**
     * Renders the content of a menu item.
     * Note that the container and the sub-menus are not rendered here.
     * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
     * @return string the rendering result
     */
    protected function renderItem($item)
    {
        if (isset($item['url']) && empty($item['active'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
            ]);
        } else {
            $template = $this->labelTemplate;
            return strtr($template, [
                '{label}' => $item['label'],
            ]);
        }
    }
}
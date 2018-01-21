<?php
/**
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

/**
 * The ListView widget is used to display data from data
 * provider. Each data model is rendered using the view
 * specified.
 */
class SiteListView extends ListView
{
    public $layout = '<div class="row">{items}</div>{pager}';
    public $itemOptions = ['tag'=>false];
    public $emptyTextOptions = ['tag'=>'p'];


//    function __toString()
//    {
//        self::widget();
//        // TODO: Implement __toString() method.
//    }

    /**
     * Renders the pager.
     * @return string the rendering result
     */
    public function renderPager()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }
        /* @var $class SiteLinkPager */
        $pager = $this->pager;
        $class = ArrayHelper::remove($pager, 'class', SiteLinkPager::className());
        $pager['pagination'] = $pagination;
        $pager['view'] = $this->getView();

        return $class::widget($pager);
    }
}

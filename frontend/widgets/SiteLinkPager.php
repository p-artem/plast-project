<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/**
 * LinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * LinkPager works with a [[Pagination]] object which specifies the total number
 * of pages and the current page number.
 *
 * Note that LinkPager only generates the necessary HTML markups. In order for it
 * to look like a real pager, you should provide some CSS styles for it.
 * With the default configuration, LinkPager should look good using Twitter Bootstrap CSS framework.
 */
class SiteLinkPager extends LinkPager
{
    /**
     * @var array HTML attributes for the pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'listPagination'];
    /**
     * @var integer maximum number of page buttons that can be displayed. Defaults to 10.
     */
    public $maxButtonCount = 5;
    /**
     * @var integer maximum number of page buttons that can be displayed for small resolution. Defaults to 1.
     */
    public $maxButtonCountForSmallResolution = 1;
    /**
     * @var string the text class for the invisible elements can be displayed for high resolution.
     */
    public $hiddenSmClass = ' hidden-xs';
    /**
     * @var string the text class for the invisible elements can be displayed for small resolution.
     */
    public $hiddenLgClass = ' hidden-sm';
    /**
     * @var string|boolean the label for the "next" page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "next" page button will not be displayed.
     */
    public $nextPageLabel = '&nbsp;';
    /**
     * @var string|boolean the text label for the previous page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "previous" page button will not be displayed.
     */
    public $prevPageLabel = '&nbsp;';
    /**
     * @var string|boolean the text label for the "first" page button. Note that this will NOT be HTML-encoded.
     * If it's specified as true, page number will be used as label.
     * Default is false that means the "first" page button will not be displayed.
     */
    public $firstPageLabel = '&nbsp;';
    /**
     * @var string|boolean the text label for the "last" page button. Note that this will NOT be HTML-encoded.
     * If it's specified as true, page number will be used as label.
     * Default is false that means the "last" page button will not be displayed.
     */
    public $lastPageLabel = '&nbsp;';

    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        $buttonsPages = [];
        // first page with number
        if ($pageCount > 1) {
            $buttonsPages[] = $this->renderPageButton(1, 0, 'pag_first', $currentPage <= 0, $currentPage == 0);
        }
        if ($currentPage > (int)($this->maxButtonCountForSmallResolution / 2) + 1) {
            $hiddenClass = ($currentPage <= (1 + (int)($this->maxButtonCount / 2))) ? $this->hiddenLgClass : '';
            $buttonsPages[] = Html::tag('li', Html::tag('span', '...'), ['class'=>'pag_div '.$hiddenClass]);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $hiddenClass = abs($currentPage - $i) > (int)($this->maxButtonCountForSmallResolution / 2) ? ' '.$this->hiddenSmClass : '';
            $buttonsPages[] = $this->renderPageButton($i + 1, $i, $hiddenClass, $i == $currentPage, $i == $currentPage);
        }

        if ($currentPage < ($pageCount - (int)($this->maxButtonCountForSmallResolution / 2) - 2)) {
            $hiddenClass = $currentPage >= ($pageCount - (int)($this->maxButtonCount / 2) - 2) ? $this->hiddenLgClass : '';
            $buttonsPages[] = Html::tag('li', Html::tag('span', '...'), ['class'=>'pag_div '.$hiddenClass]);
        }

        // last page with number
        if ($pageCount > 1) {
            $buttonsPages[] = $this->renderPageButton($pageCount, $pageCount - 1, 'pag_last', $currentPage >= $pageCount - 1, $currentPage == $pageCount - 1);
        }
        $buttons[] = Html::tag('li', Html::tag('ul', implode("\n", $buttonsPages)), ['class' => 'pages']);

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        return Html::tag('ul', implode("\n", $buttons), $this->options);
    }

    /**
     * Renders a page button.
     * You may override this method to customize the generation of page buttons.
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button.
     * @param boolean $disabled whether this page button is disabled
     * @param boolean $active whether this page button is active
     * @return string the rendering result
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => empty($class) ? $this->pageCssClass : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }

    /**
     * @return array the begin and end pages that need to be displayed.
     */
    protected function getPageRange()
    {
        $currentPage = $this->pagination->getPage();
        $pageCount = $this->pagination->getPageCount();

        $beginPage = max(1, $currentPage - (int) ($this->maxButtonCount / 2));
        if (($endPage = $beginPage + $this->maxButtonCount - 1) >= $pageCount-1) {
            $endPage = $pageCount - 2;
            $beginPage = max(1, $endPage - $this->maxButtonCount + 1);
        }

        return [$beginPage, $endPage];
    }
}

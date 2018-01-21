<?php
namespace backend\helpers;

/**
 * Class CheckboxTreeBuilder
 *
 * @package backend\helpers
 */
class CheckboxTreeBuilder
{
    /**
     * @var
     */
    protected $_id;

    /**
     * @var array
     */
    protected $_items;

    /**
     * @var
     */
    protected $_fields;

    /**
     * @var
     */
    protected $_modelName;

    /**
     * @param string $name
     * @param array $data
     * @param array $items
     * @param array $fields
     * @return string
     */
    public function __invoke($name, $data = [], $items = array(), $fields = ['id' => 'id', 'name' => 'name', 'items' => 'items'])
    {
        $this->_fields = $fields;
        $this->_items = $items;

        $tree = '<ol class="auto-checkbox-tree" data-name="'.$name.'">';
        $tree .= $this->recursive($data);
        $tree .= '</ol>';

        return $tree;
    }

    /**
     * @param array $rowset
     *
     * @return string
     */
    protected function recursive(array $rowset = array())
    {
        $list = '';
        if (!empty($rowset)) {
            foreach ($rowset as $item) {
                $checked = in_array($item[$this->_fields['id']], $this->_items) ? '  data-checked="1"' : '';
                $list .= '<li data-value="' . $item[$this->_fields['id']] . '"' . $checked . '>' . $item[$this->_fields['name']];
                if (!empty($item[$this->_fields['items']])) {
                    $list .= '<ol>';
                    $list .= $this->recursive($item[$this->_fields['items']]);
                    $list .= '</ol>';
                }
                $list .= '</li>';
            }
        }
        return $list;
    }
}
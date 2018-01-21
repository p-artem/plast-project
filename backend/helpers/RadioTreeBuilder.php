<?php
namespace backend\helpers;

use Yii;

/**
 * Class RadioTreeBuilder
 *
 * @package backend\helpers
 */
class RadioTreeBuilder
{
    /**
     * @var
     */
    protected $_id;

    /**
     * @var
     */
    protected $_pid;

    /**
     * @var
     */
    protected $_fields;

    /**
     * @param string $name
     * @param array $data
     * @param int $id
     * @param int $pid
     * @param array $fields
     * @return string
     */
    public function __invoke($name, $data = [], $id = 0, $pid = 0, $fields = ['id' => 'id', 'pid' => 'parent_id', 'items' => 'items'])
    {
        $this->_id = $id;
        $this->_pid = $pid;
        $this->_fields = $fields;

        $tree = '<ol class="auto-radio-tree" data-name="' . $name . '[' . $this->_fields['pid'] . ']">' .
            '<li data-value=""' . ($this->_pid ? '' : ' data-checked="1"') . '>' . Yii::t('backend', 'Without parent') . '<ol>';
        $tree .= $this->recursive($data);
        $tree .= '</ol></li></ol>';

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
                if ($this->_id != $item[$this->_fields['id']]) {
                    $checked = $this->_pid == $item[$this->_fields['id']] ? ' data-checked="1"' : '';
                    $list .= '<li data-value="' . $item[$this->_fields['id']] . '"' . $checked . '>' . $item['name'];
                    if (!empty($item[$this->_fields['items']])) {
                        $list .= '<ol>';
                        $list .= $this->recursive($item[$this->_fields['items']]);
                        $list .= '</ol>';
                    }
                    $list .= '</li>';
                }
            }
        }
        return $list;
    }
}
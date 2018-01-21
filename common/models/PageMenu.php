<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page_menu".
 *
 * @property integer $page_id
 * @property integer $menu_id
 *
 * @property Page $page
 */
class PageMenu extends \yii\db\ActiveRecord
{

    const MENU_TOP = 1;
    const MENU_BOTTOM_LEFT = 2;
    const MENU_BOTTOM_RIGHT = 3;

    /**
     * Return page menus list
     * @return array
     */
    public static function menus()
    {
        return [
            self::MENU_TOP => Yii::t('backend', 'Top Menu'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'menu_id'], 'integer'],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => Yii::t('backend', 'Menu'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}
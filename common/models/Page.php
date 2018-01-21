<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\query\PageQuery;
use omgdef\multilingual\MultilingualBehavior;
use yii\helpers\Url;
use yiidreamteam\upload\ImageUploadBehavior;
/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $slug
 * @property string $h1
 * @property string $text
 * @property string $image
 * @property string $metatitle
 * @property string $metakeys
 * @property string $metadesc
 * @property integer $sorting
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property string $imageUrl
 * @property string $topMenu
 *
 * @property Page $parent
 * @property Page[] $pages
 * @property PageMenu[] $pageMenus
 */
class Page extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const SCENARIO_NO_VALIDATE = 'no_validate';

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
                'immutable' => true
            ],
            'image' => [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'image',
                'filePath' => '@images/[[model]]/[[pk]].[[extension]]',
                'fileUrl' => '@imagesUrl/[[model]]/[[pk]].[[extension]]',
            ],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_NO_VALIDATE] = [];
        return $scenarios;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['text', 'metatitle', 'metakeys', 'metadesc'], 'string'],
            [['parent_id', 'sorting', 'status', 'created_at', 'updated_at'], 'integer'],
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 1024],
            [['name', 'h1'], 'string', 'max' => 512],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['sorting'], 'default', 'value' => 0],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('backend', 'ID'),
            'name'       => Yii::t('backend', 'Name'),
            'parent_id'  => Yii::t('backend', 'Parent Page'),
            'slug'       => Yii::t('backend', 'Url'),
            'h1'         => Yii::t('backend', 'H1'),
            'text'       => Yii::t('backend', 'Text'),
            'image'      => Yii::t('backend', 'Image'),
            'metatitle'  => Yii::t('backend', 'Metatitle'),
            'metakeys'   => Yii::t('backend', 'Metakeys'),
            'metadesc'   => Yii::t('backend', 'Metadesc'),
            'sorting'    => Yii::t('backend', 'Sorting'),
            'status'     => Yii::t('backend', 'Status'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
            'menusArray' => Yii::t('backend', 'Menu'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Page::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageMenus()
    {
        return $this->hasMany(PageMenu::className(), ['page_id' => 'id']);
    }

    /**
     * @return PageQuery
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function getMenusArray()
    {
        return $this->getPageMenus()->select('menu_id')->column();
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->updateMenus();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return array
     */
    public function breadcrumbs()
    {
        return array_reverse($this->createBreadcrumbs());
    }

    /**
     * @param bool $last
     * @return array
     */
    public function createBreadcrumbs($last = true)
    {
        $breadcrumbs = [];

        if ($last) {
            $breadcrumbs[] = [
                'breadUrl'  => Url::to(['page/view', 'slug' => $this->slug], true),
                'label'     => $this->name
            ];
        } else {
            $breadcrumbs[] = [
                'url' => Url::to(['/page/view', 'slug' => $this->slug], false),
                'label' => $this->name,
            ];
        }
        if ($this->parent){
            $breadcrumbs = array_merge($breadcrumbs, $this->parent->createBreadcrumbs(false));
        }

        return $breadcrumbs;
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function getImageUrl($name = 'image')
    {
        /* @var $imageUploadBehavior ImageUploadBehavior */
        $imageUploadBehavior = $this->getBehavior($name);
        if ($imageUrl = $imageUploadBehavior->getImageFileUrl($name)){
            if (($timestamp = @filemtime($imageUploadBehavior->getUploadedFilePath($name))) > 0) {
                $imageUrl .= "?_=$timestamp";
            }
        }
        return $imageUrl;
    }

    private function updateMenus()
    {
        $currentMenuIds = $this->getMenusArray();
        $post = Yii::$app->request->post();
        if (isset($post['Page']['menusArray'])) {
            $newMenuIds = (is_array($post['Page']['menusArray'])) ? $post['Page']['menusArray'] : [];

            // insert rows
            foreach (array_filter(array_diff($newMenuIds, $currentMenuIds)) as $menuId) {
                $menu = new PageMenu();
                $menu->page_id = $this->id;
                $menu->menu_id = $menuId;
                $menu->save();
            }

            // delete rows
            PageMenu::deleteAll([
                'page_id' => $this->id,
                'menu_id' => array_filter(array_diff($currentMenuIds, $newMenuIds))]);
        }
    }
}
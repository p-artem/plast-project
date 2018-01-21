<?php
namespace common\behaviors;

use rico\yii2images\behaviors\ImageBehave;
use rico\yii2images\models\Image;
use rico\yii2images\models\PlaceHolder;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Yii2imagesImageBehavior
 * @package common\behaviors
 */
class Yii2imagesImageBehavior extends ImageBehave
{
    public $component;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getMainImage()
    {
//        $finder = $this->getImagesFinder(['isMain' => 1]);
        /* @var $owner ActiveRecord the owner of this behavior */
        $owner = $this->owner;
        $imageQuery = $owner->hasOne(Image::className(), ['itemId' => 'id'])
            ->andWhere(['modelName' => $this->getModule()->getShortClass($this->owner)])
//            ->andWhere($finder)
            ->orderBy(['id' => SORT_ASC]);

        return $imageQuery;
    }

    /**
     *
     */
    public function afterSave()
    {
        $this->upload();
    }

    /**
     *
     */
    public function afterDelete()
    {
        $this->removeImages();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function upload($name = 'image'){
        $image = UploadedFile::getInstance($this->owner, $name);
        if( $image ){
            $path = Yii::getAlias('@storage') . '/web/source/temp/' . $image->baseName . '.' . $image->extension;
            $image->saveAs($path);
            $img = $this->getImageByName($name);

            if ($this->attachImage($path, true, $name) && $img instanceof Image && !($img instanceof PlaceHolder)){
                $this->removeImage($img);
            }
            @unlink($path);

            return true;
        }
        return false;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function removeImageByName($name = 'image')
    {
        if ($image = $this->getImageByName($name)) {
            $this->removeImage($image);
            return true;
        }
        return false;
    }
}
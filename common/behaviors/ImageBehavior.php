<?php
namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

/**
 * Class ImageBehavior
 * @package common\behaviors
 * @property string $subPath
 */
class ImageBehavior extends Behavior
{
    /**
     * @var string
     */
    public $name = 'image';
    /**
     * @var string
     */
    public $storagePath = '@images';
    /**
     * @var string
     */
    public $storageUrl = '@imagesUrl';
    /**
     * @var string
     */
    protected $_subPath;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        $owner = $this->owner;
        $subPath = $this->subPath .
            DIRECTORY_SEPARATOR . $owner->{$this->name};
        if ($owner->{$this->name}
            && file_exists(Yii::getAlias($this->storagePath) . $subPath)) {
            return Yii::getAlias($this->storageUrl) . $subPath;
        }

        return null;
    }

    /**
     *
     */
    public function beforeSave()
    {
        $this->upload($this->name);
    }

    /**
     *
     */
    public function afterDelete()
    {
        $this->removePath();
    }

    /**
     * Remove model images path
     */
    protected function removePath()
    {
        $dirToRemove = Yii::getAlias($this->storagePath) . $this->subPath;
        BaseFileHelper::removeDirectory($dirToRemove);
    }

    /**
     * @param ActiveRecord $obj
     * @return string
     */
    protected function getShortClass($obj)
    {
        $className = get_class($obj);

        if (preg_match('@\\\\([\w]+)$@', $className, $matches)) {
            $className = $matches[1];
        }

        return $className;
    }

    /**
     * @return string
     */
    protected function getSubPath()
    {
        if (empty($this->_subPath)) {
            $this->_subPath =
                DIRECTORY_SEPARATOR . strtolower($this->getShortClass($this->owner)) .
                DIRECTORY_SEPARATOR . $this->owner->id;
        }
        return $this->_subPath;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function upload($name = 'image'){
        /* @var $owner ActiveRecord */
        $owner = $this->owner;
        $image = UploadedFile::getInstance($owner, $name);
        if( $image ){
            $path = Yii::getAlias($this->storagePath) . '/temp/' . $image->baseName . '.' . $image->extension;
            $image->saveAs($path);

            if ($fileName = $this->saveImage($path, $name)){
                $owner->$name = $fileName;
                if ($oldFileName = $owner->getOldAttribute($name)){
                    @unlink(Yii::getAlias($this->storagePath) . $this->subPath
                        . DIRECTORY_SEPARATOR . $oldFileName);
                }
            }
            @unlink($path);

            return true;
        }
        return false;
    }

    /**
     *
     * Method copies image file to store.
     *
     * @param $absolutePath
     * @param $name
     * @return string
     * @throws \Exception
     */
    protected function saveImage($absolutePath, $name = '')
    {
        if(!preg_match('#http#', $absolutePath)){
            if (!file_exists($absolutePath)) {
                throw new \Exception('File not exist! :'.$absolutePath);
            }
        }else{
            //nothing
        }
        $owner = $this->owner;
        if (!$owner->primaryKey) {
            throw new \Exception('Owner must have primaryKey when you attach image!');
        }

        $pictureSubDir = Yii::getAlias($this->storagePath) . $this->subPath;
        $pictureFileName =
            substr(md5(microtime(true) . $absolutePath), 4, 6)
            . '.' .
            pathinfo($absolutePath, PATHINFO_EXTENSION);

        $newAbsolutePath = $pictureSubDir . DIRECTORY_SEPARATOR . $pictureFileName;
        BaseFileHelper::createDirectory($pictureSubDir, 0775, true);

        copy($absolutePath, $newAbsolutePath);

        if (!file_exists($newAbsolutePath)) {
            throw new \Exception('Cant copy file! ' . $absolutePath . ' to ' . $newAbsolutePath);
        }

        return $pictureFileName;
    }
}

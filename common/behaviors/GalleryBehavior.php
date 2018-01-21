<?php
namespace common\behaviors;

use Imagine\Image\ImageInterface;
use yii\base\Behavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use \zxbodya\yii2\galleryManager\GalleryBehavior as ZxbodyaGalleryBehavior;
use yii\db\ActiveRecord;

/**
 * Class GalleryBehavior
 * @package common\behaviors
 */
class GalleryBehavior extends ZxbodyaGalleryBehavior
{
    public $subPath = 'gallery';
    /**
     * @param ActiveRecord $owner
     */
    public function attach($owner)
    {
        Behavior::attach($owner);
    }

    public function beforeDelete()
    {
        $images = $this->getImages();
        foreach ($images as $image) {
            $this->deleteImage($image->id);
        }
        $dirPath = $this->directory
            . '/' . $this->getGalleryId()
            . ($this->subPath ? '/' . $this->subPath : '');
        @rmdir($dirPath);
    }

    /**
     * Replace existing image by specified file
     *
     * @param $imageId
     * @param $path
     */
    public function replaceImage($imageId, $path)
    {
        $this->createFolders($this->getFilePath($imageId, 'original'));

        $originalImage = Image::getImagine()->open($path);
        //save image in original size

        if (empty($this->versions['original'])){
            @copy($path, $this->getFilePath($imageId));
        }
        //create image preview for gallery manager
        foreach ($this->versions as $version => $fn) {
            /** @var ImageInterface $image */

            $image = call_user_func($fn, $originalImage);
            if (is_array($image)) {
                list($image, $options) = $image;
            } else {
                $options = [];
            }

            $image
                ->save($this->getFilePath($imageId, $version), $options);
        }
    }

    public function deleteImage($imageId)
    {
        $filePath = $this->getFilePath($imageId);
        FileHelper::removeDirectory(dirname($filePath));

        $db = \Yii::$app->db;
        $db->createCommand()
            ->delete(
                $this->tableName,
                ['id' => $imageId]
            )->execute();
    }

    protected function getFileName($imageId, $version = 'original')
    {
        return implode(
            '/',
            [
                $this->getGalleryId(),
                $this->subPath ?: '',
                $imageId,
                $version . '.' . $this->extension,
            ]
        );
    }

    private function removeFile($fileName)
    {
        if (file_exists($fileName)) {
            @unlink($fileName);
        }
    }

    private function createFolders($filePath)
    {
        $parts = explode('/', $filePath);
        // skip file name
        $parts = array_slice($parts, 0, count($parts) - 1);
        $targetPath = implode('/', $parts);
        $path = realpath($targetPath);
        if (!$path) {
            mkdir($targetPath, 0777, true);
        }
    }
}
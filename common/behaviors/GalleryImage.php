<?php

namespace common\behaviors;

/**
 * Class GalleryImage
 * @package common\behaviors
 */
class GalleryImage
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $id;
    /**
     * @var int
     */
    public $rank;
    /**
     * @var int
     */
    public $vertical;
    /**
     * @var GalleryBehavior
     */
    protected $galleryBehavior;

    /**
     * @param GalleryBehavior $galleryBehavior
     * @param array           $props
     */
    function __construct(GalleryBehavior $galleryBehavior, array $props)
    {
        $this->galleryBehavior = $galleryBehavior;

        $this->name = isset($props['name']) ? $props['name'] : '';
        $this->description = isset($props['description']) ? $props['description'] : '';
        $this->id = isset($props['id']) ? $props['id'] : '';
        $this->rank = isset($props['rank']) ? $props['rank'] : '';
        $this->vertical = isset($props['vertical']) ? $props['vertical'] : '';
    }

    /**
     * @param string $version
     *
     * @return string
     */
    public function getUrl($version)
    {
        return $this->galleryBehavior->getUrl($this->id, $version);
    }

    /**
     * @param int $imageId
     * @param string $version
     * @return string
     */
    public function getFilePath($imageId, $version = 'original')
    {
        return $this->galleryBehavior->directory . '/' . $this->getFileName($imageId, $version);
    }

    /**
     * @param int $imageId
     * @param string $version
     * @return string
     */
    protected function getFileName($imageId, $version = 'original')
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [
                $this->galleryBehavior->getGalleryId(),
                $this->galleryBehavior->subPath ?: '',
                $imageId,
                $version . '.' . $this->galleryBehavior->extension,
            ]
        );
    }
}
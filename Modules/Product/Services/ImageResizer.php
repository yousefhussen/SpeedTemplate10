<?php
namespace Modules\Product\Services;

use Intervention\Image\ImageManager;

class ImageResizer
{
    private $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function resize($image, $width, $height)
    {
        return $this->imageManager->make($image)->resize($width, $height);
    }
}

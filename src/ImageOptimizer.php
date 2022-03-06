<?php

namespace App;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;


class ImageOptimizer
{
    private const PARTICIPATION_MAX_WIDTH = 600;
    private const PARTICIPATION_MAX_HEIGHT = 500;
    private $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    public function resizeParticipation(string $filename): void
    {
        list($iwidth, $iheight) = getimagesize($filename);
        $ratio = $iwidth / $iheight;
        $width = self::PARTICIPATION_MAX_WIDTH;
        $height = self::PARTICIPATION_MAX_HEIGHT;
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }
        $picture = $this->imagine->open($filename);
        $picture->resize(new Box($width, $height))->save($filename);
    }
}

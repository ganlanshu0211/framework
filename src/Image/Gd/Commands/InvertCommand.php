<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 18:19
 */
namespace Notadd\Foundation\Image\Gd\Commands;

use Notadd\Foundation\Image\Commands\AbstractCommand;

/**
 * Class InvertCommand.
 */
class InvertCommand extends AbstractCommand
{
    /**
     * Inverts colors of an image.
     *
     * @param \Notadd\Foundation\Image\Image $image
     *
     * @return bool
     */
    public function execute($image)
    {
        return imagefilter($image->getCore(), IMG_FILTER_NEGATE);
    }
}
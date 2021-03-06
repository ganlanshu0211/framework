<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 18:52
 */
namespace Notadd\Foundation\Image\Imagick\Commands;

use Notadd\Foundation\Image\Commands\AbstractCommand;

/**
 * Class DestroyCommand.
 */
class DestroyCommand extends AbstractCommand
{
    /**
     * Destroys current image core and frees up memory.
     *
     * @param \Notadd\Foundation\Image\Image $image
     *
     * @return bool
     */
    public function execute($image)
    {
        $image->getCore()->clear();
        foreach ($image->getBackups() as $backup) {
            $backup->clear();
        }

        return true;
    }
}

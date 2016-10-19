<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-19 17:35
 */
namespace Notadd\Foundation\Database\Traits;
/**
 * Class MigrationPath
 * @package Notadd\Foundation\Database\Traits
 */
trait MigrationPath {
    /**
     * @return string
     */
    protected function getMigrationPath() {
        if(!is_null($path = $this->getInput()->getOption('path'))) {
            return base_path($path);
        }
        return realpath(database_path('migrations'));
    }
}
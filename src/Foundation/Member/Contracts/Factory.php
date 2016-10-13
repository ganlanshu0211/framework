<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-13 17:50
 */
namespace Notadd\Foundation\Member\Contracts;
/**
 * Interface Manager
 * @package Notadd\Member\Contracts
 */
interface Factory {
    /**
     * @param string $name
     * @return mixed
     */
    public function driver($name = null);
}
<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 16:31
 */
namespace Notadd\Module\Contracts;
/**
 * Class ModuleRegistrar
 * @package Notadd\Module\Contracts
 */
interface ModuleRegistrar {
    /**
     * @return void
     */
    public function boot();
    /**
     * @return \Notadd\Module\Contracts\Module
     */
    public function getModule();
}
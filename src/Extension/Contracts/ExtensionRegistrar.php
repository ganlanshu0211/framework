<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-30 17:48
 */
namespace Notadd\Extension\Contracts;
/**
 * Interface ExtensionRegistrar
 * @package Notadd\Extension\Contracts
 */
interface ExtensionRegistrar {
    /**
     * @return void
     */
    public function boot();
    /**
     * @return \Notadd\Extension\Contracts\Extension
     */
    public function getExtension();
}
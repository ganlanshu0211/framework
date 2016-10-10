<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-29 16:18
 */
namespace Notadd\Admin;
use Notadd\Admin\Listeners\RouteRegistrar;
use Notadd\Foundation\Abstracts\ServiceProvider;
/**
 * Class AdminServiceProvider
 * @package Notadd\Admin
 */
class AdminServiceProvider extends ServiceProvider {
    /**
     * @return void
     */
    public function boot() {
        $this->events->subscribe(RouteRegistrar::class);
    }
}
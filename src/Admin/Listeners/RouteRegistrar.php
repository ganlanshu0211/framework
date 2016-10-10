<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-09 18:26
 */
namespace Notadd\Admin\Listeners;
use Notadd\Admin\Controllers\AdminController;
use Notadd\Admin\Handlers\DashboardHandler;
use Notadd\Foundation\Routing\Abstracts\AbstractRouteRegistrar;
/**
 * Class RouteRegister
 * @package Notadd\Admin\Listeners
 */
class RouteRegistrar extends AbstractRouteRegistrar {
    /**
     * @return void
     */
    public function handle() {
        $this->router->group(['middleware' => 'web', 'prefix' => 'admin'], function() {
            $this->router->resource('/', AdminController::class, [
                'only' => 'index'
            ]);
            $this->router->api('dashboard', DashboardHandler::class);
        });
    }
}
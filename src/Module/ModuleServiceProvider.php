<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 16:25
 */
namespace Notadd\Module;
use Illuminate\Filesystem\Filesystem;
use Notadd\Foundation\Abstracts\AbstractServiceProvider;
/**
 * Class ModuleServiceProvider
 * @package Notadd\Module
 */
class ModuleServiceProvider extends AbstractServiceProvider {
    /**
     * @param \Notadd\Module\ModuleManager $manager
     */
    public function boot(ModuleManager $manager) {
        dd($manager->getModules());
    }
    /**
     * @return void
     */
    public function register() {
        $this->app->singleton('modules', function($app) {
            return new ModuleManager($app, $app['events'], $app['files']);
        });
    }
}
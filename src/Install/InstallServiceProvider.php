<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-24 10:49
 */
namespace Notadd\Install;
use Illuminate\Support\ServiceProvider;
use Notadd\Install\Commands\InstallCommand;
use Notadd\Install\Contracts\Prerequisite;
use Notadd\Install\Controllers\InstallController;
use Notadd\Install\Prerequisite\PhpExtension;
use Notadd\Install\Prerequisite\PhpVersion;
use Notadd\Install\Prerequisite\WritablePath;
/**
 * Class InstallServiceProvider
 * @package Notadd\Install
 */
class InstallServiceProvider extends ServiceProvider {
    /**
     * @return void
     */
    public function boot() {
        if(!$this->app->isInstalled()) {
            $this->app->make('router')->resource('/', InstallController::class);
        }
        $this->commands([
            InstallCommand::class
        ]);
        $this->loadViewsFrom(resource_path('views/install'), 'install');
    }
    /**
     * @return void
     */
    public function register() {
        $this->app->bind(Prerequisite::class, function () {
            return new Composite(new PhpVersion('5.5.0'),
                new PhpExtension([
                    'dom',
                    'fileinfo',
                    'gd',
                    'json',
                    'mbstring',
                    'openssl',
                    'pdo_mysql',
                ]),
                new WritablePath([
                    public_path(),
                    storage_path()
                ]));
        });
    }
}
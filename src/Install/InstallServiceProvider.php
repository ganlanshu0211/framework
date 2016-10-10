<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-27 16:31
 */
namespace Notadd\Install;
use Notadd\Foundation\Abstracts\ServiceProvider;
use Notadd\Install\Contracts\Prerequisite;
use Notadd\Install\Listeners\CommandRegistrar;
use Notadd\Install\Listeners\RouteRegistrar;
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
        $this->events->subscribe(CommandRegistrar::class);
        $this->events->subscribe(RouteRegistrar::class);
    }
    /**
     * @return void
     */
    public function register() {
        $this->app->bind(Prerequisite::class, function () {
            return new Composite(
                new PhpVersion('5.5.0'),
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
                ])
            );
        });
    }
}
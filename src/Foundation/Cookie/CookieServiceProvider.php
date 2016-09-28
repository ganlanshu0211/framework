<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-27 17:46
 */
namespace Notadd\Foundation\Cookie;
use Illuminate\Support\ServiceProvider;
/**
 * Class CookieServiceProvider
 * @package Notadd\Foundation\Cookie
 */
class CookieServiceProvider extends ServiceProvider {
    /**
     * @return void
     */
    public function register() {
        $this->app->singleton('cookie', function ($app) {
            $config = $app['config']['session'];
            return (new CookieJar)->setDefaultPathAndDomain($config['path'], $config['domain'], $config['secure']);
        });
    }
}
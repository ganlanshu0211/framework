<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-24 17:27
 */
namespace Notadd\Member;
use Notadd\Foundation\Abstracts\ServiceProvider;
use Notadd\Member\Listeners\RouteRegistrar;
/**
 * Class MemberServiceProvider
 * @package Notadd\Member
 */
class MemberServiceProvider extends ServiceProvider {
    /**
     * @return void
     */
    public function boot() {
        $this->events->subscribe(RouteRegistrar::class);
    }
    /**
     * @return void
     */
    public function register() {
        $this->app->singleton('member', function($app) {
            return new MemberManager($app, $app['events']);
        });
    }
}
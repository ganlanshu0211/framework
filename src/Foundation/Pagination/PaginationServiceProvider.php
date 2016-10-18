<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-18 13:33
 */
namespace Notadd\Foundation\Pagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Message\ServerRequestInterface;
/**
 * Class PaginationServiceProvider
 * @package Notadd\Foundation\Pagination
 */
class PaginationServiceProvider extends ServiceProvider {
    /**
     * @return void
     */
    public function boot() {
        $this->loadViewsFrom(base_path('vendor/illuminate/pagination/resources/views'), 'pagination');
    }
    /**
     * @return void
     */
    public function register() {
        Paginator::viewFactoryResolver(function () {
            return $this->app['view'];
        });
        Paginator::currentPathResolver(function () {
            return $this->app->make(ServerRequestInterface::class)->getUri()->getPath();
        });
        Paginator::currentPageResolver(function ($pageName = 'page') {
            $page = array_get($this->app->make(ServerRequestInterface::class)->getQueryParams(), $pageName);
            if(filter_var($page, FILTER_VALIDATE_INT) !== false && (int)$page >= 1) {
                return $page;
            }
            return 1;
        });
    }
}
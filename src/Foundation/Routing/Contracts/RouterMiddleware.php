<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-22 15:21
 */
namespace Notadd\Foundation\Routing\Contracts;
use Closure;
use Notadd\Foundation\Http\Contracts\Request;
/**
 * Interface RouterMiddleware
 * @package Notadd\Foundation\Routing\Contracts
 */
interface RouterMiddleware {
    /**
     * @param \Notadd\Foundation\Http\Contracts\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next);
}
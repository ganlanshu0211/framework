<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-29 19:12
 */
namespace Notadd\Foundation\Routing\Dispatchers;
use Illuminate\Container\Container;
use InvalidArgumentException;
use Notadd\Foundation\Http\Exceptions\MethodNotFoundException;
use Notadd\Foundation\Routing\Contracts\Handler;
use Notadd\Foundation\Routing\Router;
/**
 * Class ApiDispatcher
 * @package Notadd\Foundation\Routing\Dispatchers
 */
class ApiDispatcher {
    /**
     * ControllerDispatcher constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Foundation\Routing\Router $router
     */
    public function __construct(Container $container, Router $router) {
        $this->container = $container;
        $this->router = $router;
    }
    /**
     * @param array $routeInfo
     * @return mixed
     * @throws \Notadd\Foundation\Http\Exceptions\MethodNotFoundException
     */
    public function dispatch(array $routeInfo) {
        list($class, $method) = explode('@', $routeInfo[1]['uses']);
        if(!($instance = $this->container->make($class) instanceof Handler)) {
            throw new InvalidArgumentException('Route handler must be an instance of ' . Handler::class);
        }
        if(!method_exists($instance = $this->container->make($class), $method)) {
            throw new MethodNotFoundException("Controller method not found: {$class}@{$method}.");
        }
        return call_user_func_array([
            $instance,
            'run'
        ], array_merge([
            $method,
            $routeInfo[2]
        ]));
    }
}
<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-27 00:16
 */
namespace Notadd\Foundation\Routing\Events;
use Notadd\Foundation\Http\Contracts\Request;
use Notadd\Foundation\Routing\Router;
use Psr\Http\Message\ResponseInterface as Response;
/**
 * Class RouteMatched
 * @package Notadd\Routing\Events
 */
class RouteMatched {
    /**
     * @var \Notadd\Foundation\Http\Contracts\Request
     */
    protected $request;
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;
    /**
     * @var \Notadd\Foundation\Routing\Router
     */
    protected $route;
    /**
     * RouteMatched constructor.
     * @param \Notadd\Foundation\Routing\Router $route
     * @param \Notadd\Foundation\Http\Contracts\Request $request
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(Router $route, Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
        $this->route = $route;
    }
}
<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-29 15:48
 */
namespace Notadd\Install\Pipelines;
use Notadd\Foundation\Routing\Responses\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
/**
 * Class RedirectIfNotInstalled
 * @package Notadd\Install\Pipelines
 */
class RedirectIfNotInstalled {
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param callable|null $out
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $out = null) {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        if($method == 'GET' && ($path != '/' || !empty($request->getQueryParams()))) {
            return new RedirectResponse('/');
        }
        return $out ? $out($request, $response) : $response;
    }
}
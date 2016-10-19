<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-29 17:42
 */
namespace Notadd\Foundation\Http\Pipelines;
use Illuminate\Support\Str;
use Notadd\Foundation\Http\Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
/**
 * Class JsonBodyParser
 * @package Notadd\Foundation\Http\Middlewares
 */
class JsonBodyParser {
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param callable|null $out
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, Response $response, callable $out = null) {
        $request = new Request(call_user_func([$request, 'getCurrentRequest']), call_user_func([$request, 'getOriginalRequest']));
        if(Str::contains($request->getHeaderLine('content-type'), 'json')) {
            $input = json_decode($request->getBody(), true);
            $request = $request->withParsedBody($input ?: []);
        }
        return $out ? $out($request, $response) : $response;
    }
}
<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-20 00:51
 */
namespace Notadd\Foundation\Http;
use Notadd\Foundation\Abstracts\Server as BaseServer;
use Notadd\Foundation\Application;
use Notadd\Foundation\Http\Events\PipelineInjection;
use Notadd\Foundation\Http\Pipelines\ErrorHandler;
use Notadd\Foundation\Http\Pipelines\JsonBodyParser;
use Notadd\Foundation\Http\Pipelines\RouteDispatcher;
use Notadd\Foundation\Http\Pipelines\SessionStarter;
use Notadd\Install\InstallServiceProvider;
use Notadd\Install\Pipelines\RedirectIfNotInstalled;
use UnexpectedValueException;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Server as ZendServer;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Stratigility\MiddlewarePipe;
/**
 * Class Server
 * @package Notadd\Foundation\Http
 */
class Server extends BaseServer {
    /**
     * @param callable $callback
     * @param array $server
     * @param array $query
     * @param array $body
     * @param array $cookies
     * @param array $files
     * @return \Zend\Diactoros\Server
     */
    public static function createServer(callable $callback, array $server, array $query, array $body, array $cookies, array $files) {
        $server = ServerRequestFactory::normalizeServer($server ?: $_SERVER);
        $files = ServerRequestFactory::normalizeFiles($files ?: $_FILES);
        $headers = ServerRequestFactory::marshalHeaders($server);
        $request = new ServerRequest($server, $files, ServerRequestFactory::marshalUriFromServer($server, $headers), ServerRequestFactory::get('REQUEST_METHOD', $server, 'GET'), 'php://input', $headers, $cookies ?: $_COOKIE, $query ?: $_GET, $body ?: $_POST, static::marshalProtocolVersion($server));
        $response = new Response();
        return new ZendServer($callback, $request, $response);
    }
    /**
     * @param \Notadd\Foundation\Application $app
     * @return \Zend\Stratigility\MiddlewareInterface
     */
    protected function getMiddleware(Application $app) {
        $errorDir = realpath(__DIR__ . '/../../../errors');
        $pipe = new MiddlewarePipe;
        $path = parse_url($this->getUrl(), PHP_URL_PATH);
        if(!$app->isInstalled()) {
            $app->register(InstallServiceProvider::class);
            $pipe->pipe($path, $app->make(RedirectIfNotInstalled::class));
            $pipe->pipe($path, $app->make(RouteDispatcher::class));
            $pipe->pipe($path, new ErrorHandler($errorDir, true, $app->make('log')));
        } elseif($app->isInstalled()) {
            $pipe->pipe($path, $app->make(JsonBodyParser::class));
            $pipe->pipe($path, $app->make(SessionStarter::class));
            $app->make('events')->fire(new PipelineInjection($pipe, $path, $this));
            $pipe->pipe($path, $app->make(RouteDispatcher::class));
            $pipe->pipe($path, new ErrorHandler($errorDir, true, $app->make('log')));
        } else {
            $pipe->pipe($path, function () use ($errorDir) {
                return new HtmlResponse(file_get_contents($errorDir . '/503.html', 503));
            });
        }
        return $pipe;
    }
    /**
     * @param $path
     * @return mixed|string
     */
    protected function getUrl($path = null) {
        $config = [
            'url' => 'http://notadd.io',
            'paths' => [
                'api' => 'api',
                'admin' => 'admin',
            ]
        ];
        $url = array_get($config, 'url', $_SERVER['REQUEST_URI']);
        if(is_array($url)) {
            if(isset($url[$path])) {
                return $url[$path];
            }
            $url = $url['base'];
        }
        if($path) {
            $url .= '/' . array_get($config, "paths.$path", $path);
        }
        return $url;
    }
    /**
     * @return void
     */
    public function listen() {
        $app = $this->getApp();
        $server = static::createServer($this->getMiddleware($app), $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
        $server->listen();
    }
    /**
     * @param array $server
     * @return string
     */
    protected static function marshalProtocolVersion(array $server) {
        if(!isset($server['SERVER_PROTOCOL'])) {
            return '1.1';
        }
        if(!preg_match('#^(HTTP/)?(?P<version>[1-9]\d*(?:\.\d)?)$#', $server['SERVER_PROTOCOL'], $matches)) {
            throw new UnexpectedValueException(sprintf('Unrecognized protocol version (%s)', $server['SERVER_PROTOCOL']));
        }
        return $matches['version'];
    }
}
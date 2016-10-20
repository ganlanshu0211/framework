<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-29 14:19
 */
namespace Notadd\Foundation\Routing;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Illuminate\Container\Container;
use Illuminate\Session\SessionInterface;
use Notadd\Foundation\Routing\Responses\RedirectResponse;
use Psr\Http\Message\ResponseInterface as Response;
/**
 * Class Redirector
 * @package Notadd\Foundation\Routing
 */
class Redirector {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Notadd\Foundation\Routing\UrlGenerator
     */
    protected $generator;
    /**
     * @var \Illuminate\Session\SessionInterface
     */
    protected $session;
    /**
     * Redirector constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Foundation\Routing\UrlGenerator $generator
     */
    public function __construct(Container $container, UrlGenerator $generator) {
        $this->container = $container;
        $this->generator = $generator;
    }
    /**
     * @param string $path
     * @param int $status
     * @param array $headers
     * @return \Notadd\Foundation\Routing\Responses\RedirectResponse
     */
    public function away($path, $status = 302, $headers = []) {
        return $this->createRedirect($path, $status, $headers);
    }
    /**
     * @param $path
     * @param $status
     * @param $headers
     * @return \Notadd\Foundation\Routing\Responses\RedirectResponse
     */
    protected function createRedirect($path, $status, $headers) {
        $response = new RedirectResponse($path, $status, $headers);
        if(isset($this->session)) {
            $response = $this->withSessionCookie($response, $this->session);
        }
        $response->setRequest($this->container->make('request'));
        return $response;
    }
    /**
     * @return \Notadd\Foundation\Routing\UrlGenerator
     */
    public function getUrlGenerator() {
        return $this->generator;
    }
    /**
     * @param string $path
     * @param int $status
     * @param array $headers
     * @return \Notadd\Foundation\Routing\Responses\RedirectResponse
     */
    public function secure($path, $status = 302, $headers = []) {
        return $this->to($path, $status, $headers, true);
    }
    /**
     * @param \Illuminate\Session\SessionInterface $session
     */
    public function setSession(SessionInterface $session) {
        $this->session = $session;
    }
    /**
     * @param string $path
     * @param int $status
     * @param array $headers
     * @param bool $secure
     * @return \Notadd\Foundation\Routing\Responses\RedirectResponse
     */
    public function to($path, $status = 302, $headers = [], $secure = null) {
        $path = $this->generator->to($path, [], $secure);
        return $this->createRedirect($path, $status, $headers);
    }
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Illuminate\Session\SessionInterface $session
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function withSessionCookie(Response $response, SessionInterface $session) {
        return FigResponseCookies::set($response, SetCookie::create($session->getName(), $session->getId())->withPath('/')->withHttpOnly(true));
    }
}
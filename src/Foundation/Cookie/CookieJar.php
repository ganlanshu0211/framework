<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-27 18:56
 */
namespace Notadd\Foundation\Cookie;
use Dflydev\FigCookies\SetCookie;
use Illuminate\Contracts\Cookie\QueueingFactory as JarContract;
use Illuminate\Support\Arr;
/**
 * Class CookieJar
 * @package Notadd\Foundation\Cookie
 */
class CookieJar implements JarContract {
    /**
     * @var string
     */
    protected $path = '/';
    /**
     * @var string
     */
    protected $domain = null;
    /**
     * @var bool
     */
    protected $secure = false;
    /**
     * @var array
     */
    protected $queued = [];
    /**
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @return array
     */
    protected function getPathAndDomain($path, $domain, $secure = false) {
        return [
            $path ?: $this->path,
            $domain ?: $this->domain,
            $secure ?: $this->secure
        ];
    }
    /**
     * @param string $name
     * @param string $value
     * @param int $minutes
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     * @return \Dflydev\FigCookies\SetCookie
     */
    public function make($name, $value, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = true) {
        list($path, $domain, $secure) = $this->getPathAndDomain($path, $domain, $secure);
        $time = ($minutes == 0) ? 0 : time() + ($minutes * 60);
        return SetCookie::create($name, $value)->withExpires($time)->withPath($path)->withDomain($domain)->withSecure($domain)->withHttpOnly($httpOnly);
    }
    /**
     * @param string $name
     * @param string $value
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     * @return \Dflydev\FigCookies\SetCookie
     */
    public function forever($name, $value, $path = null, $domain = null, $secure = false, $httpOnly = true) {
        return $this->make($name, $value, 2628000, $path, $domain, $secure, $httpOnly);
    }
    /**
     * @param string $name
     * @param string $path
     * @param string $domain
     * @return \Dflydev\FigCookies\SetCookie
     */
    public function forget($name, $path = null, $domain = null) {
        return $this->make($name, null, -2628000, $path, $domain);
    }
    /**
     * @param string $key
     * @return bool
     */
    public function hasQueued($key) {
        return !is_null($this->queued($key));
    }
    /**
     * @param mixed
     * @return void
     */
    public function queue() {
        if(head(func_get_args()) instanceof SetCookie) {
            $cookie = head(func_get_args());
        } else {
            $cookie = call_user_func_array([
                $this,
                'make'
            ], func_get_args());
        }
        $this->queued[$cookie->getName()] = $cookie;
    }
    /**
     * @param string $key
     * @param mixed $default
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function queued($key, $default = null) {
        return Arr::get($this->queued, $key, $default);
    }
    /**
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @return \Notadd\Foundation\Cookie\CookieJar
     */
    public function setDefaultPathAndDomain($path, $domain, $secure = false) {
        list($this->path, $this->domain, $this->secure) = [
            $path,
            $domain,
            $secure
        ];
        return $this;
    }
    /**
     * @param string $name
     */
    public function unqueue($name) {
        unset($this->queued[$name]);
    }
    /**
     * @return array
     */
    public function getQueuedCookies() {
        return $this->queued;
    }
}
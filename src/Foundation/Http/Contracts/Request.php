<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-18 17:39
 */
namespace Notadd\Foundation\Http\Contracts;
use Psr\Http\Message\ServerRequestInterface;
/**
 * Interface Request
 * @package Notadd\Foundation\Http\Contracts
 */
interface Request extends ServerRequestInterface {
    /**
     * @return bool
     */
    public function ajax();
    /**
     * @return array
     */
    public function all();
    /**
     * @param  string $key
     * @param  string|array|null $default
     * @return string|array
     */
    public function cookie($key = null, $default = null);
    /**
     * @param array|string $keys
     * @return array
     */
    public function except($keys);
    /**
     * @param array|string $key
     * @return bool
     */
    public function exists($key);
    /**
     * @return bool
     */
    public function expectsJson();
    /**
     * @param string $key
     * @return mixed
     */
    public function file($key);
    /**
     * @return array
     */
    public function getAcceptableContentTypes();
    /**
     * @param string|array $key
     * @return bool
     */
    public function has($key);
    /**
     * @param string|array $key
     * @return bool
     */
    public function hasCookie($key);
    /**
     * @param string $key
     * @return bool
     */
    public function hasFile($key);
    /**
     * @return bool
     */
    public function hasSession();
    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function input($key = null, $default = null);
    /**
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public function old($key = null, $default = null);
    /**
     * @param array|string $keys
     * @return array
     */
    public function only($keys);
    /**
     * @return string
     */
    public function ip();
    /**
     * @return bool
     */
    public function pjax();
    /**
     * @return \Illuminate\Session\Store
     * @throws \RuntimeException
     */
    public function session();
    /**
     * @return mixed
     */
    public function url();
    /**
     * @return bool
     */
    public function wantsJson();
}
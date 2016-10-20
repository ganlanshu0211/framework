<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-20 01:40
 */
use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Notadd\Foundation\Routing\UrlGenerator;
if(!function_exists('app')) {
    /**
     * @param string $make
     * @param array $parameters
     * @return \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    function app($make = null, $parameters = []) {
        if(is_null($make)) {
            return Container::getInstance();
        }
        return Container::getInstance()->make($make, $parameters);
    }
}
if(!function_exists('app_path')) {
    /**
     * @param string $path
     * @return string
     */
    function app_path($path = '') {
        return app('path') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if(!function_exists('asset')) {
    /**
     * @param string $path
     * @param bool $secure
     * @return string
     */
    function asset($path, $secure = null) {
        return app('url')->asset($path, $secure);
    }
}
if(!function_exists('back')) {
    /**
     * @param int $status
     * @param array $headers
     * @return mixed
     */
    function back($status = 302, $headers = []) {
        return app('redirect')->back($status, $headers);
    }
}
if(!function_exists('base_path')) {
    /**
     * @param string $path
     * @return string
     */
    function base_path($path = '') {
        return app()->basePath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if(!function_exists('bcrypt')) {
    /**
     * @param string $value
     * @param array $options
     * @return string
     */
    function bcrypt($value, $options = []) {
        return app('hash')->make($value, $options);
    }
}
if(!function_exists('config')) {
    /**
     * @param array|string $key
     * @param mixed $default
     * @return mixed
     */
    function config($key = null, $default = null) {
        if(is_null($key)) {
            return app('config');
        }
        if(is_array($key)) {
            return app('config')->set($key);
        }
        return app('config')->get($key, $default);
    }
}
if(!function_exists('database_path')) {
    /**
     * @param string $path
     * @return string
     */
    function database_path($path = '') {
        return app()->databasePath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if(!function_exists('event')) {
    /**
     * @param string|object $event
     * @param mixed $payload
     * @param bool $halt
     * @return array|null
     */
    function event($event, $payload = [], $halt = false) {
        return app('events')->fire($event, $payload, $halt);
    }
}
if(!function_exists('head')) {
    /**
     * @param array $array
     * @return mixed
     */
    function head($array) {
        return reset($array);
    }
}
if(!function_exists('old')) {
    /**
     * Retrieve an old input item.
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function old($key = null, $default = null) {
        return app('request')->old($key, $default);
    }
}
if(!function_exists('public_path')) {
    /**
     * @param string $path
     * @return string
     */
    function public_path($path = '') {
        return app()->make('path.public') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if(!function_exists('redirect')) {
    /**
     * @param string|null  $to
     * @param int $status
     * @param array $headers
     * @param bool $secure
     * @return \Notadd\Foundation\Routing\Redirector|\Notadd\Foundation\Routing\Responses\RedirectResponse
     */
    function redirect($to = null, $status = 302, $headers = [], $secure = null) {
        if (is_null($to)) {
            return app('redirector');
        }
        return app('redirector')->to($to, $status, $headers, $secure);
    }
}
if(!function_exists('resource_path')) {
    /**
     * @param string $path
     * @return string
     */
    function resource_path($path = '') {
        return app()->resourcePath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if(!function_exists('secure_asset')) {
    /**
     * @param string $path
     * @return string
     */
    function secure_asset($path) {
        return asset($path, true);
    }
}
if(!function_exists('storage_path')) {
    /**
     * @param string $path
     * @return string
     */
    function storage_path($path = '') {
        return app('path.storage') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if(!function_exists('secure_url')) {
    /**
     * @param string $path
     * @param mixed $parameters
     * @return string
     */
    function secure_url($path, $parameters = []) {
        return url($path, $parameters, true);
    }
}
if(!function_exists('session')) {
    /**
     * Get / set the specified session value.
     * If an array is passed as the key, we will assume you want to set an array of values.
     * @param  array|string $key
     * @param  mixed $default
     * @return mixed
     */
    function session($key = null, $default = null) {
        if(is_null($key)) {
            return app('session');
        }
        if(is_array($key)) {
            return app('session')->put($key);
        }
        return app('session')->get($key, $default);
    }
}
if(!function_exists('url')) {
    /**
     * @param string $path
     * @param mixed $parameters
     * @param bool $secure
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function url($path = null, $parameters = [], $secure = null) {
        if(is_null($path)) {
            return app(UrlGenerator::class);
        }
        return app(UrlGenerator::class)->to($path, $parameters, $secure);
    }
}
if(!function_exists('view')) {
    /**
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    function view($view = null, $data = [], $mergeData = []) {
        $factory = app(ViewFactory::class);
        if(func_num_args() === 0) {
            return $factory;
        }
        return $factory->make($view, $data, $mergeData);
    }
}
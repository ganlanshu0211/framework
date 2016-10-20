<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-20 11:25
 */
namespace Notadd\Foundation\Routing;
use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\UrlRoutable;
use Notadd\Foundation\Http\Contracts\Request;
/**
 * Class UrlGenerator
 * @package Notadd\Foundation\Routing
 */
class UrlGenerator {
    /**
     * @var string|null
     */
    protected $cachedRoot;
    /**
     * @var string|null
     */
    protected $cachedScheme;
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var string|null
     */
    protected $forceSchema;
    /**
     * @var callable
     */
    protected $sessionResolver;
    /**
     * UrlGenerator constructor.
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container) {
        $this->container = $container;
    }
    /**
     * @param string $path
     * @param array $extra
     * @param bool $secure
     * @return string
     */
    public function to($path, $extra = [], $secure = null) {
        if($this->isValidUrl($path)) {
            return $path;
        }
        $scheme = $this->getSchemeForUrl($secure);
        $extra = $this->formatParametersForUrl($extra);
        $tail = implode('/', array_map('rawurlencode', (array)$extra));
        $root = $this->getRootUrl($scheme);
        return $this->trimUrl($root, $path, $tail);
    }
    /**
     * @param string $path
     * @return bool
     */
    protected function isValidUrl($path) {
        if(starts_with($path, [
            '#',
            '//',
            'mailto:',
            'tel:',
            'http://',
            'https://'
        ])) {
            return true;
        }
        return filter_var($path, FILTER_VALIDATE_URL) !== false;
    }
    /**
     * @param bool|null $secure
     * @return null|string
     */
    protected function getSchemeForUrl($secure) {
        if(is_null($secure)) {
            if(is_null($this->cachedScheme)) {
                $this->cachedScheme = $this->container->make(Request::class)->getUri()->getScheme() . '://';
            }
            return $this->cachedScheme;
        }
        return $secure ? 'https://' : 'http://';
    }
    /**
     * @param mixed|array $parameters
     * @return array
     */
    protected function formatParametersForUrl($parameters) {
        return $this->replaceRoutableParametersForUrl($parameters);
    }
    /**
     * @param array $parameters
     * @return array
     */
    protected function replaceRoutableParametersForUrl($parameters = []) {
        $parameters = is_array($parameters) ? $parameters : [$parameters];
        foreach($parameters as $key => $parameter) {
            if($parameter instanceof UrlRoutable) {
                $parameters[$key] = $parameter->getRouteKey();
            }
        }
        return $parameters;
    }
    /**
     * @param string $scheme
     * @param string $root
     * @return string
     */
    protected function getRootUrl($scheme, $root = null) {
        if(is_null($root)) {
            if(is_null($this->cachedRoot)) {
                $request = $this->container->make(Request::class);
                $this->cachedRoot = $scheme . $request->getUri()->getHost();
            }
            $root = rtrim($this->cachedRoot, '/');
        }
        $start = starts_with($root, 'http://') ? 'http://' : 'https://';
        return preg_replace('~' . $start . '~', $scheme, $root, 1);
    }
    /**
     * @param string $root
     * @param string $path
     * @param string $tail
     * @return string
     */
    protected function trimUrl($root, $path, $tail = '') {
        return trim($root . '/' . trim($path . '/' . $tail, '/'), '/');
    }
    /**
     * @param string $path
     * @param array $parameters
     * @return string
     */
    public function secure($path, $parameters = []) {
        return $this->to($path, $parameters, true);
    }
    /**
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    public function asset($path, $secure = null) {
        if($this->isValidUrl($path)) {
            return $path;
        }
        $root = $this->getRootUrl($this->getScheme($secure));
        return $this->removeIndex($root) . '/' . trim($path, '/');
    }
    /**
     * @param string $root
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    public function assetFrom($root, $path, $secure = null) {
        $root = $this->getRootUrl($this->getScheme($secure), $root);
        return $this->removeIndex($root) . '/' . trim($path, '/');
    }
    /**
     * @param string $root
     * @return string
     */
    protected function removeIndex($root) {
        $i = 'index.php';
        return str_contains($root, $i) ? str_replace('/' . $i, '', $root) : $root;
    }
    /**
     * @param string $path
     * @return string
     */
    public function secureAsset($path) {
        return $this->asset($path, true);
    }
    /**
     * @param bool|null $secure
     * @return string
     */
    protected function getScheme($secure) {
        if(is_null($secure)) {
            return $this->forceSchema ?: $this->container->make(Request::class)->getUri()->getScheme() . '://';
        }
        return $secure ? 'https://' : 'http://';
    }
    public function previous($fallback = false) {
        $referrer = $this->container->make(Request::class)->getHeader('referer');
        $url = $referrer ? $this->to($referrer) : $this->getPreviousUrlFromSession();
        if($url) {
            return $url;
        } elseif($fallback) {
            return $this->to($fallback);
        } else {
            return $this->to('/');
        }
    }
    protected function getPreviousUrlFromSession() {
        $session = $this->getSession();
        return $session ? $session->previousUrl() : null;
    }
    protected function getSession() {
        if($this->sessionResolver) {
            return call_user_func($this->sessionResolver);
        }
    }
    public function setSessionResolver(callable $sessionResolver) {
        $this->sessionResolver = $sessionResolver;
        return $this;
    }
}
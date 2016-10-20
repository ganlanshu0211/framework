<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-18 17:17
 */
namespace Notadd\Foundation\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Notadd\Foundation\Http\Contracts\Request as RequestContract;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Zend\Stratigility\Http\Request as ZendRequest;
/**
 * Class Request
 * @package Notadd\Foundation\Http
 */
class Request extends ZendRequest implements RequestContract {
    use Macroable;
    /**
     * @var array
     */
    protected $acceptableContentTypes;
    /**
     * @return bool
     */
    public function ajax() {
        return 'XMLHttpRequest' == $this->getHeader('X-Requested-With');
    }
    /**
     * @return array
     */
    public function all() {
        return collect($this->getQueryParams() + $this->getParsedBody() + $this->getUploadedFiles())->toArray();
    }
    /**
     * @param  string $key
     * @param  string|array|null $default
     * @return string|array
     */
    public function cookie($key = null, $default = null) {
        if(is_null($key)) {
            return $this->getCookieParams();
        }
        return data_get($this->getCookieParams(), $key, $default);
    }
    /**
     * @return \Notadd\Foundation\Http\Request
     */
    public function enableHttpMethodParameterOverride() {
        if('POST' === $this->getMethod()) {
            if($method = $this->getHeader('X-HTTP-METHOD-OVERRIDE')) {
                return $this->withMethod(strtoupper($method));
            } else {
                $method = collect($this->getQueryParams())->get('_method', collect($this->getParsedBody())->get('_method', 'POST'));
                return $this->withMethod(strtoupper($method));
            }
        }
        return $this;
    }
    /**
     * @param array|string $keys
     * @return array
     */
    public function except($keys) {
        $keys = is_array($keys) ? $keys : func_get_args();
        $results = $this->all();
        Arr::forget($results, $keys);
        return $results;
    }
    /**
     * @param array|string $key
     * @return bool
     */
    public function exists($key) {
        $keys = is_array($key) ? $key : func_get_args();
        $input = $this->all();
        foreach($keys as $value) {
            if(!Arr::has($input, $value)) {
                return false;
            }
        }
        return true;
    }
    /**
     * @return bool
     */
    public function expectsJson() {
        return ($this->ajax() && !$this->pjax()) || $this->wantsJson();
    }
    /**
     * @param string $key
     * @return mixed
     */
    public function file($key) {
        return collect($this->getUploadedFiles())->get($key);
    }
    /**
     * @return array
     */
    public function getAcceptableContentTypes() {
        if(null !== $this->acceptableContentTypes) {
            return $this->acceptableContentTypes;
        }
        return $this->acceptableContentTypes = array_keys(AcceptHeader::fromString(collect((array)$this->getHeader('Accept'))->first())->all());
    }
    /**
     * @param string|array $key
     * @return bool
     */
    public function has($key) {
        $keys = is_array($key) ? $key : func_get_args();
        foreach($keys as $value) {
            if($this->isEmptyString($value)) {
                return false;
            }
        }
        return true;
    }
    /**
     * @param string $key
     * @return bool
     */
    public function hasCookie($key) {
        return !is_null($this->cookie($key));
    }
    /**
     * @param string $key
     * @return bool
     */
    public function hasFile($key) {
        return collect($this->getUploadedFiles())->offsetExists($key);
    }
    /**
     * @return bool
     */
    public function hasSession() {
        return null !== $this->getAttribute('session');
    }
    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function input($key = null, $default = null) {
        $input = $this->getQueryParams() + $this->getParsedBody();
        return data_get($input, $key, $default);
    }
    /**
     * @return string
     */
    public function ip() {
        return collect($this->getServerParams())->get('REMOTE_ADDR');
    }
    /**
     * @param $key
     * @return bool
     */
    protected function isEmptyString($key) {
        $value = $this->input($key);
        $boolOrArray = is_bool($value) || is_array($value);
        return !$boolOrArray && trim((string)$value) === '';
    }
    /**
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public function old($key = null, $default = null) {
        return $this->session()->getOldInput($key, $default);
    }
    /**
     * @param array|string $keys
     * @return array
     */
    public function only($keys) {
        $keys = is_array($keys) ? $keys : func_get_args();
        $results = [];
        $input = $this->all();
        foreach($keys as $key) {
            Arr::set($results, $key, data_get($input, $key));
        }
        return $results;
    }
    /**
     * @return bool
     */
    public function pjax() {
        return $this->getHeader('X-PJAX') == true;
    }
    /**
     * @return \Illuminate\Session\Store
     * @throws \RuntimeException
     */
    public function session() {
        if(!$this->hasSession()) {
            throw new RuntimeException('Session store not set on request.');
        }
        return $this->getAttribute('session');
    }
    /**
     * @return mixed
     */
    public function url() {
        return $this->getUri();
    }
    /**
     * @return bool
     */
    public function wantsJson() {
        $acceptable = $this->getAcceptableContentTypes();
        return isset($acceptable[0]) && Str::contains($acceptable[0], [
            '/json',
            '+json'
        ]);
    }
    /**
     * @param string $header
     * @param string|\string[] $value
     * @return \Notadd\Foundation\Http\Request
     */
    public function withAddedHeader($header, $value) {
        $new = $this->getCurrentRequest()->withAddedHeader($header, $value);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param string $attribute
     * @param mixed $value
     * @return \Notadd\Foundation\Http\Request
     */
    public function withAttribute($attribute, $value) {
        $new = $this->getCurrentRequest()->withAttribute($attribute, $value);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param \Psr\Http\Message\StreamInterface $body
     * @return \Notadd\Foundation\Http\Request
     */
    public function withBody(StreamInterface $body) {
        $new = $this->getCurrentRequest()->withBody($body);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param array $cookies
     * @return \Notadd\Foundation\Http\Request
     */
    public function withCookieParams(array $cookies) {
        $new = $this->getCurrentRequest()->withCookieParams($cookies);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param string $header
     * @param string|\string[] $value
     * @return \Notadd\Foundation\Http\Request
     */
    public function withHeader($header, $value) {
        $new = $this->getCurrentRequest()->withHeader($header, $value);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param string $method
     * @return \Notadd\Foundation\Http\Request
     */
    public function withMethod($method) {
        $new = $this->getCurrentRequest()->withMethod($method);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param string $attribute
     * @return \Notadd\Foundation\Http\Request
     */
    public function withoutAttribute($attribute) {
        $new = $this->getCurrentRequest()->withoutAttribute($attribute);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param string $header
     * @return \Notadd\Foundation\Http\Request
     */
    public function withoutHeader($header) {
        $new = $this->getCurrentRequest()->withoutHeader($header);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param array|null|object $params
     * @return \Notadd\Foundation\Http\Request
     */
    public function withParsedBody($params) {
        $new = $this->getCurrentRequest()->withParsedBody($params);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param string $version
     * @return \Notadd\Foundation\Http\Request
     */
    public function withProtocolVersion($version) {
        $new = $this->getCurrentRequest()->withProtocolVersion($version);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param array $query
     * @return \Notadd\Foundation\Http\Request
     */
    public function withQueryParams(array $query) {
        $new = $this->getCurrentRequest()->withQueryParams($query);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param mixed $requestTarget
     * @return \Notadd\Foundation\Http\Request
     */
    public function withRequestTarget($requestTarget) {
        $new = $this->getCurrentRequest()->withRequestTarget($requestTarget);
        return new static($new, $this->getOriginalRequest());
    }
    /**
     * @param \Psr\Http\Message\UriInterface $uri
     * @param bool $preserveHost
     * @return \Notadd\Foundation\Http\Request
     */
    public function withUri(UriInterface $uri, $preserveHost = false) {
        $new = $this->getCurrentRequest()->withUri($uri, $preserveHost);
        return new static($new, $this->getOriginalRequest());
    }
}
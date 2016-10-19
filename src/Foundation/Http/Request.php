<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-18 17:17
 */
namespace Notadd\Foundation\Http;
use Illuminate\Support\Arr;
use Notadd\Foundation\Http\Contracts\Request as RequestContract;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Stratigility\Http\Request as ZendRequest;
/**
 * Class Request
 * @package Notadd\Foundation\Http
 */
class Request extends ZendRequest implements RequestContract {
    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    private $originalRequest;
    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    private $psrRequest;
    /**
     * Request constructor.
     * @param \Psr\Http\Message\ServerRequestInterface $decoratedRequest
     * @param \Psr\Http\Message\ServerRequestInterface $originalRequest
     */
    public function __construct(ServerRequestInterface $decoratedRequest, $originalRequest) {
        if(null === $originalRequest) {
            $originalRequest = $decoratedRequest;
        }
        $this->originalRequest = $originalRequest;
        if('POST' === $decoratedRequest->getMethod()) {
            if($method = $decoratedRequest->getHeader('X-HTTP-METHOD-OVERRIDE')) {
                $decoratedRequest = $decoratedRequest->withMethod(strtoupper($method));
            } else {
                $method = collect($decoratedRequest->getQueryParams())->get('_method', collect($decoratedRequest->getParsedBody())->get('_method', 'POST'));
                $decoratedRequest = $decoratedRequest->withMethod(strtoupper($method));
            }
        }
        $this->psrRequest = $decoratedRequest->withAttribute('originalUri', $originalRequest->getUri());
    }
    /**
     * @return array
     */
    public function all() {
        return collect($this->getQueryParams() + $this->getParsedBody() + $this->getUploadedFiles())->toArray();
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
     * @param string $key
     * @return mixed
     */
    public function file($key) {
        return collect($this->getUploadedFiles())->get($key);
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
    public function hasFile($key) {
        return collect($this->getUploadedFiles())->offsetExists($key);
    }
    /**
     * @param string $key
     * @return mixed
     */
    public function input($key) {
        return collect($this->getQueryParams() + $this->getParsedBody())->get($key);
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
     * @return mixed
     */
    public function url() {
        return $this->getUri();
    }
}
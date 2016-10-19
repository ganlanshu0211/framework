<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-18 17:17
 */
namespace Notadd\Foundation\Http;
use Notadd\Foundation\Http\Contracts\Request as RequestContract;
use Zend\Stratigility\Http\Request as ZendRequest;
/**
 * Class Request
 * @package Notadd\Foundation\Http
 */
class Request extends ZendRequest implements RequestContract {
    /**
     * @param string $key
     * @return mixed
     */
    public function file($key) {
        return collect($this->getUploadedFiles())->get($key);
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
     * @return mixed
     */
    public function url() {
        return $this->getUri();
    }
}
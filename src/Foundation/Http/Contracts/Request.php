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
     * @param string $key
     * @return mixed
     */
    public function file($key);
    /**
     * @param string $key
     * @return mixed
     */
    public function input($key);
    /**
     * @return mixed
     */
    public function url();
}
<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-29 18:07
 */
namespace Notadd\Foundation\Routing\Contracts;
/**
 * Interface Handler
 * @package Notadd\Foundation\Routing\Contracts
 */
interface Handler {
    /**
     * @return \Tobscure\JsonApi\SerializerInterface
     */
    public function getSerializer();
    /**
     * @return string
     */
    public function getType();
    /**
     * @param string $method
     * @return \Notadd\Foundation\Http\Responses\JsonResponse
     */
    public function run($method = 'handle');
}
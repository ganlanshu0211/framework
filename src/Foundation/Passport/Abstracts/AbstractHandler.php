<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-29 17:17
 */
namespace Notadd\Foundation\Passport\Abstracts;
use Exception;
use Illuminate\Container\Container;
use Notadd\Foundation\Http\Responses\JsonResponse;
use Notadd\Foundation\Routing\Contracts\Handler;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\ElementInterface;
use Tobscure\JsonApi\SerializerInterface;
/**
 * Class AbstractHandler
 * @package Notadd\Foundation\Passport\Abstracts
 */
abstract class AbstractHandler implements Handler {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * AbstractHandler constructor.
     */
    public function __construct() {
        $this->container = $this->getContainer();
    }
    /**
     * @return \Illuminate\Container\Container
     */
    protected function getContainer() {
        return Container::getInstance();
    }
    /**
     * @param string $method
     * @return \Notadd\Foundation\Http\Responses\JsonResponse
     * @throws \Exception
     */
    public function run($method = 'handle') {
        $document = new Document();
        $data = $this->{$method}();
        $serializer = $this->getSerializer();
        if(!($serializer instanceof SerializerInterface)) {
            throw new Exception('Serializer must implement of ' . SerializerInterface::class);
        }
        $type = $this->getType();
        $creator = 'create' . ucfirst($type) . 'Element';
        if(!function_exists($creator)) {
            throw new Exception('Element Creator not found!', 404);
        }
        $element = $this->{$creator}($data, $serializer);
        if(!($element instanceof  ElementInterface)) {
            throw new Exception('Element must implement of ' . ElementInterface::class);
        }
        $document->setData($element);
        return new JsonResponse($document);
    }
    /**
     * @return \Tobscure\JsonApi\SerializerInterface
     * @throws \Exception
     */
    public function getSerializer() {
        throw new Exception('Serializer not found!', 404);
    }
    /**
     * @return string
     * @throws \Exception
     */
    public function getType() {
        throw new Exception('Type not fount!', 404);
    }
}
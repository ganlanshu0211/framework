<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-29 17:17
 */
namespace Notadd\Foundation\Passport\Abstracts;
use Exception;
use Illuminate\Bus\Dispatcher as BusDispatcher;
use Illuminate\Container\Container;
use Notadd\Foundation\Http\Responses\JsonResponse;
use Notadd\Foundation\Routing\Contracts\Handler;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\ElementInterface;
use Tobscure\JsonApi\Resource;
use Tobscure\JsonApi\SerializerInterface;
/**
 * Class AbstractHandler
 * @package Notadd\Foundation\Passport\Abstracts
 */
abstract class AbstractHandler implements Handler {
    /**
     * @var \Illuminate\Bus\Dispatcher
     */
    protected $bus;
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * AbstractHandler constructor.
     */
    public function __construct() {
        $this->container = $this->getContainer();
        $this->bus = $this->container->make(BusDispatcher::class);
    }
    /**
     * @param $data
     * @param \Tobscure\JsonApi\SerializerInterface $serializer
     * @return \Tobscure\JsonApi\Collection
     */
    protected function createCollectionElement($data, SerializerInterface $serializer) {
        return new Collection($data, $serializer);
    }
    /**
     * @param $data
     * @param \Tobscure\JsonApi\SerializerInterface $serializer
     * @return \Tobscure\JsonApi\Resource
     */
    protected function createResourceElement($data, SerializerInterface $serializer) {
        return new Resource($data, $serializer);
    }
    /**
     * @return \Illuminate\Container\Container
     */
    protected function getContainer() {
        return Container::getInstance();
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
    /**
     * @param string $method
     * @return \Notadd\Foundation\Http\Responses\JsonResponse
     * @throws \Exception
     */
    public function run($method = 'handle') {
        $document = new Document();
        $data = $this->{$method}();
        if(is_null($data)) {
            throw new Exception('Handler return null data !');
        }
        $serializer = $this->getSerializer();
        if(is_string($serializer)) {
            $serializer = $this->container->make($serializer);
        }
        if(!($serializer instanceof SerializerInterface)) {
            throw new Exception('Serializer must implement of ' . SerializerInterface::class);
        }
        $type = strtolower($this->getType());
        if(!in_array($type, [
            'collection',
            'resource'
        ])) {
            throw new Exception('Type not Supported !');
        }
        $creator = 'create' . ucfirst($type) . 'Element';
        $element = $this->{$creator}($data, $serializer);
        if(!($element instanceof ElementInterface)) {
            throw new Exception('Element must implement of ' . ElementInterface::class);
        }
        $document->setData($element);
        return new JsonResponse($document);
    }
}
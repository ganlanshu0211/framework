<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 10:44
 */
namespace Notadd\Extension\Abstracts;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Notadd\Extension\Extension;
/**
 * Class ExtensionRegistrar
 * @package Notadd\Extension\Abstracts
 */
abstract class ExtensionRegistrar {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * @var \Illuminate\Support\ServiceProvider
     */
    protected $provider;
    /**
     * ExtensionRegistrar constructor.
     */
    public function __construct() {
        $this->container = $this->getContainer();
        $this->events = $this->container->make('events');
    }
    /**
     * @return array
     */
    public function compiles() {
        return [];
    }
    /**
     * @return \Illuminate\Container\Container
     */
    protected function getContainer() {
        return Container::getInstance();
    }
    /**
     * @return \Notadd\Extension\Extension
     */
    final public function getExtension() {
        $extension = new Extension($this->getExtensionName(), $this->getExtensionPath());
        $extension->setRegistrar($this);
        return $extension;
    }
    /**
     * @return string
     */
    abstract protected function getExtensionName();
    /**
     * @return string
     */
    abstract protected function getExtensionPath();
    /**
     * @return void
     */
    abstract public function register();
    /**
     * @param \Illuminate\Support\ServiceProvider $provider
     * @return \Notadd\Extension\Abstracts\ExtensionRegistrar
     */
    public function withProvider(ServiceProvider $provider) {
        $instance = clone $this;
        $instance->provider = $provider;
        return $instance;
    }
}
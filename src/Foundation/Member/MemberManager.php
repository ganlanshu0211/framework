<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-13 16:12
 */
namespace Notadd\Foundation\Member;
use Closure;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use InvalidArgumentException;
use Notadd\Foundation\Member\Contracts\Factory as FactoryContract;
/**
 * Class MemberManager
 * @package Notadd\Member
 */
class MemberManager implements FactoryContract {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var array
     */
    protected $drivers = [];
    /**
     * @var string
     */
    protected $default = 'notadd';
    /**
     * @var array
     */
    protected $providers = [];
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * MemberManager constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function __construct(Container $container, Dispatcher $events) {
        $this->container = $container;
        $this->events = $events;
    }
    /**
     * @param string $name
     * @return mixed
     */
    public function driver($name = null) {
        if(isset($this->drivers[$name])) {
            return call_user_func($this->drivers[$name]);
        }
        throw new InvalidArgumentException("Auth guard driver [{$name}] is not defined.");
    }
    /**
     * @param string $driver
     * @param \Closure $callback
     * @return \Notadd\Foundation\Member\MemberManager
     */
    public function extend($driver, Closure $callback) {
        $this->drivers[$driver] = $callback;
        return $this;
    }
    /**
     * @return string
     */
    public function getDefaultDriver() {
        return $this->default;
    }
    /**
     * @param string $provider
     * @param \Closure $callback
     * @return \Notadd\Foundation\Member\MemberManager
     */
    public function provider($provider, Closure $callback) {
        $this->providers[$provider] = $callback;
        return $this;
    }
    /**
     * @param $driver
     * @throws \Exception
     */
    public function setDefaultDriver($driver) {
        if(in_array($driver, array_keys($this->drivers))) {
            $this->default = $driver;
        }
        throw new InvalidArgumentException('Member Manager Driver is not defined.');
    }
}
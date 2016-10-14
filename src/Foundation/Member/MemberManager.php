<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-13 16:12
 */
namespace Notadd\Foundation\Member;
use Closure;
use Illuminate\Container\Container;
use InvalidArgumentException;
use Notadd\Foundation\Member\Abstracts\Driver;
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
    protected $default;
    /**
     * MemberManager constructor.
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container) {
        $this->container = $container;
    }
    /**
     * @param string $name
     * @return \Notadd\Foundation\Member\Abstracts\Driver
     */
    public function driver($name = null) {
        if(isset($this->drivers[$name])) {
            $driver = $this->container->call($this->drivers[$name]);
            if($driver instanceof Driver) {
                return $driver;
            }
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
     * @param $driver
     * @throws \Exception
     */
    public function setDefaultDriver($driver) {
        $this->default = $driver;
    }
}
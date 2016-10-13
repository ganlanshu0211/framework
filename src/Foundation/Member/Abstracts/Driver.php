<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-13 19:05
 */
namespace Notadd\Foundation\Member\Abstracts;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Member\Contracts\Driver as DriverContract;
/**
 * Class Driver
 * @package Notadd\Foundation\Member\Abstracts
 */
abstract class Driver implements DriverContract {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * Driver constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function __construct(Container $container, Dispatcher $events) {
        $this->container = $container;
        $this->events = $events;
    }
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    abstract public function create(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    abstract public function delete(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    abstract public function edit(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    abstract public function store(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    abstract public function update(array $data, $force = false);
}
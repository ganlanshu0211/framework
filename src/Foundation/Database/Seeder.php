<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-19 14:05
 */
namespace Notadd\Foundation\Database;
use Illuminate\Container\Container;
use Illuminate\Database\ConnectionInterface;
use Notadd\Foundation\Console\Abstracts\Command;
/**
 * Class Seeder
 * @package Notadd\Foundation\Database
 */
abstract class Seeder {
    /**
     * @var \Notadd\Foundation\Console\Abstracts\Command
     */
    protected $command;
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $connection;
    /**
     * Seeder constructor.
     * @param \Illuminate\Database\ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection) {
        $this->connection = $connection;
    }
    /**
     * @param $class
     */
    public function call($class) {
        $this->resolve($class)->run();
        if(isset($this->command)) {
            $this->command->getOutput()->writeln("<info>Seeded:</info> $class");
        }
    }
    /**
     * @param $class
     * @return mixed
     */
    protected function resolve($class) {
        if(isset($this->container)) {
            $instance = $this->container->make($class);
            $instance->setContainer($this->container);
        } else {
            $instance = new $class;
        }
        if(isset($this->command)) {
            $instance->setCommand($this->command);
        }
        return $instance;
    }
    /**
     * @return void
     */
    abstract public function run();
    /**
     * @param \Notadd\Foundation\Console\Abstracts\Command $command
     * @return \Notadd\Foundation\Database\Seeder
     */
    public function setCommand(Command $command) {
        $this->command = $command;
        return $this;
    }
    /**
     * @param \Illuminate\Container\Container $container
     * @return \Notadd\Foundation\Database\Seeder
     */
    public function setContainer(Container $container) {
        $this->container = $container;
        return $this;
    }
}
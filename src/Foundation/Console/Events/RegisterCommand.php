<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-03 03:01
 */
namespace Notadd\Foundation\Console\Events;
use Illuminate\Container\Container;
use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Console\Application as Console;
/**
 * Class RegisterCommand
 * @package Notadd\Foundation\Console\Events
 */
class RegisterCommand {
    /**
     * @var \Notadd\Foundation\Console\Application
     */
    protected $console;
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * RegisterCommand constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Foundation\Console\Application $console
     */
    public function __construct(Container $container, Console $console) {
        $this->console = $console;
        $this->container = $container;
    }
    /**
     * @param \Notadd\Foundation\Console\Abstracts\Command $command
     * @return null|\Symfony\Component\Console\Command\Command
     */
    public function registerCommand(Command $command) {
        if(is_string($command)) {
            $command = $this->console->add($this->container->make($command));
        }
        if($command instanceof Command) {
            $command = $this->console->add($command);
        }
        return $command;
    }
}
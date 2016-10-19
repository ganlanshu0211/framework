<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-19 18:17
 */
namespace Notadd\Foundation\Routing\Listeners;
use Notadd\Foundation\Console\Abstracts\CommandRegistrar as AbstractCommandRegistrar;
use Notadd\Foundation\Console\Events\RegisterCommand;
use Notadd\Foundation\Routing\Commands\RouteListCommand;
/**
 * Class CommandRegistrar
 * @package Notadd\Foundation\Routing\Listeners
 */
class CommandRegistrar extends AbstractCommandRegistrar {
    /**
     * @param \Notadd\Foundation\Console\Events\RegisterCommand $console
     */
    public function handle(RegisterCommand $console) {
        $console->registerCommand($this->container->make(RouteListCommand::class));
    }
}
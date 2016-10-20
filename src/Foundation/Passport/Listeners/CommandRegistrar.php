<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-27 09:52
 */
namespace Notadd\Foundation\Passport\Listeners;
use Notadd\Foundation\Console\Abstracts\CommandRegistrar as AbstractCommandRegistrar;
use Notadd\Foundation\Console\Events\RegisterCommand as CommandRegisterEvent;
use Notadd\Foundation\Passport\Commands\ClientCommand;
use Notadd\Foundation\Passport\Commands\InstallCommand;
use Notadd\Foundation\Passport\Commands\KeysCommand;
/**
 * Class RegisterCommand
 * @package Notadd\Passport\Listeners
 */
class CommandRegistrar extends AbstractCommandRegistrar {
    /**
     * @param \Notadd\Foundation\Console\Events\RegisterCommand $console
     */
    public function handle(CommandRegisterEvent $console) {
        $console->registerCommand($this->container->make(ClientCommand::class));
        $console->registerCommand($this->container->make(InstallCommand::class));
        $console->registerCommand($this->container->make(KeysCommand::class));
    }
}
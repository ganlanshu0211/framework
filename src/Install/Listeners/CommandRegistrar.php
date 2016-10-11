<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-27 10:39
 */
namespace Notadd\Install\Listeners;
use Notadd\Foundation\Console\Abstracts\CommandRegistrar as AbstractCommandRegistrar;
use Notadd\Foundation\Console\Events\RegisterCommand as CommandRegisterEvent;
use Notadd\Install\Commands\InstallCommand;
/**
 * Class RegisterCommand
 * @package Notadd\Install\Listeners
 */
class CommandRegistrar extends AbstractCommandRegistrar {
    /**
     * @param \Notadd\Foundation\Console\Events\RegisterCommand $console
     */
    public function handle(CommandRegisterEvent $console) {
        $console->registerCommand($this->container->make(InstallCommand::class));
    }
}
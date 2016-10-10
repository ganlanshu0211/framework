<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-03 03:09
 */
namespace Notadd\Foundation\Database\Listeners;
use Notadd\Foundation\Console\Abstracts\CommandRegistrar as AbstractCommandRegistrar;
use Notadd\Foundation\Console\Events\RegisterCommand as CommandRegisterEvent;
use Notadd\Foundation\Database\Commands\InfoCommand;
use Notadd\Foundation\Database\Commands\InstallCommand;
use Notadd\Foundation\Database\Commands\MakeMigrationCommand;
use Notadd\Foundation\Database\Commands\MigrateCommand;
use Notadd\Foundation\Database\Commands\RollbackCommand;
/**
 * Class RegisterCommand
 * @package Notadd\Foundation\Database\Listeners
 */
class CommandRegistrar extends AbstractCommandRegistrar {
    /**
     * @param \Notadd\Foundation\Console\Events\RegisterCommand $console
     */
    public function handle(CommandRegisterEvent $console) {
        $console->registerCommand(new InfoCommand());
        $console->registerCommand($this->container->make(InstallCommand::class));
        $console->registerCommand($this->container->make(MakeMigrationCommand::class));
        $console->registerCommand($this->container->make(MigrateCommand::class));
        $console->registerCommand($this->container->make(RollbackCommand::class));
    }
}
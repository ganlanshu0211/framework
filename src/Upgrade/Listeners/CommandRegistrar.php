<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-09 17:38
 */
namespace Notadd\Upgrade\Listeners;
use Notadd\Foundation\Abstracts\EventSubscriber;
use Notadd\Foundation\Console\Events\RegisterCommand as CommandRegisterEvent;
use Notadd\Upgrade\Commands\UpgradeCommand;
/**
 * Class RegisterCommand
 * @package Notadd\Upgrade\Listeners
 */
class CommandRegistrar extends EventSubscriber {
    /**
     * @return string
     */
    protected function getEvent() {
        return CommandRegisterEvent::class;
    }
    /**
     * @param \Notadd\Foundation\Console\Events\RegisterCommand $console
     */
    public function handle(CommandRegisterEvent $console) {
        $console->registerCommand($this->container->make(UpgradeCommand::class));
    }
}
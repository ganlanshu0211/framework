<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-20 10:40
 */
namespace Notadd\Foundation\Console\Commands;
use Notadd\Foundation\Console\Abstracts\Command;
/**
 * Class EnvironmentCommand
 * @package Notadd\Foundation\Console\Commands
 */
class EnvironmentCommand extends Command {
    /**
     * @return void
     */
    public function configure() {
        $this->setDescription('Display the current framework environment');
        $this->setName('env');
    }
    /**
     * @return void
     */
    public function fire() {
        $this->output->writeln('<info>Current application environment:</info><comment>' . $this->container['env'] . '</comment>');
    }
}
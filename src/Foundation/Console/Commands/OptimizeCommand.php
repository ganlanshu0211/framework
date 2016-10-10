<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-30 13:58
 */
namespace Notadd\Foundation\Console\Commands;
use Notadd\Foundation\Console\Abstracts\Command;
use Symfony\Component\Console\Input\InputOption;
/**
 * Class OptimizeCommand
 * @package Notadd\Foundation\Console\Commands
 */
class OptimizeCommand extends Command {
    /**
     * @return void
     */
    public function configure() {
        $this->addOption('force', null, InputOption::VALUE_NONE, 'Force the compiled class file to be written.');
        $this->addOption('psr', null, InputOption::VALUE_NONE, 'Do not optimize Composer dump-autoload.');
        $this->setDescription('Optimize the framework for better performance');
        $this->setName('optimize');
    }
    /**
     * @return void
     */
    public function fire() {
    }
}
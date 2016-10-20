<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-20 10:27
 */
namespace Notadd\Foundation\Console\Commands;
use Notadd\Foundation\Console\Abstracts\Command;
/**
 * Class OptimizeClearCommand
 * @package Notadd\Foundation\Console\Commands
 */
class OptimizeClearCommand extends Command {
    /**
     * @return void
     */
    public function configure() {
        $this->setDescription('Remove the compiled class file');
        $this->setName('optimize:clear');
    }
    /**
     * @return void
     */
    protected function fire() {
        $path = $this->container->getCachedCompilePath();
        if(file_exists($path)) {
            @unlink($path);
        }
        $this->info('Optimize compiled file removed!');
    }
}
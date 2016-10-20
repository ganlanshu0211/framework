<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-20 10:22
 */
namespace Notadd\Foundation\Console\Commands;
use Illuminate\Filesystem\Filesystem;
use Notadd\Foundation\Console\Abstracts\Command;
use RuntimeException;
/**
 * Class ViewClearCommand
 * @package Notadd\Foundation\Console\Commands
 */
class ViewClearCommand extends Command {
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
     * ViewClearCommand constructor.
     * @param \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Filesystem $files) {
        parent::__construct();
        $this->files = $files;
    }
    /**
     * @return void
     */
    protected function configure() {
        $this->setDescription('Clear all compiled view files');
        $this->setName('view:clear');
    }
    /**
     * @return void
     */
    protected function fire() {
        $path = $this->container['config']['view.compiled'];
        if(!$path) {
            throw new RuntimeException('View path not found.');
        }
        foreach($this->files->glob("{$path}/*") as $view) {
            $this->files->delete($view);
        }
        $this->info('Compiled views cleared!');
    }
}
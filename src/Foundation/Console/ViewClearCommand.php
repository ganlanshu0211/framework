<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 13:05
 */
namespace Notadd\Foundation\Console;
use RuntimeException;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
/**
 * Class ViewClearCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class ViewClearCommand extends Command {
    /**
     * @var string
     */
    protected $name = 'view:clear';
    /**
     * @var string
     */
    protected $description = 'Clear all compiled view files';
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
    public function fire() {
        $path = $this->laravel['config']['view.compiled'];
        if(!$path) {
            throw new RuntimeException('View path not found.');
        }
        foreach($this->files->glob("{$path}/*") as $view) {
            $this->files->delete($view);
        }
        $this->info('Compiled views cleared!');
    }
}
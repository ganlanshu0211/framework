<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-19 12:20
 */
namespace Notadd\Foundation\Database\Commands;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Notadd\Foundation\Console\Abstracts\Command;
use Symfony\Component\Console\Input\InputArgument;
/**
 * Class SeederMakeCommand
 * @package Notadd\Foundation\Database\Commands
 */
class SeederMakeCommand extends Command {
    /**
     * @var \Illuminate\Support\Composer
     */
    protected $composer;
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
     * SeederMakeCommand constructor.
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param \Illuminate\Support\Composer $composer
     */
    public function __construct(Filesystem $files, Composer $composer) {
        parent::__construct();
        $this->composer = $composer;
        $this->files = $files;
    }
    /**
     * @param $name
     * @return bool
     */
    protected function alreadyExists($name) {
        return $this->files->exists($this->getPath($name));
    }
    /**
     * @param $name
     * @return mixed
     */
    protected function buildClass($name) {
        $stub = $this->files->get(resource_path('stubs/seeders/seeder.stub'));
        $stub = str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);
        return str_replace('DummyClass', $name, $stub);
    }
    /**
     * @return void
     */
    protected function configure() {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the class');
        $this->setDescription('Create a new seeder class');
        $this->setName('make:seeder');
    }
    /**
     * @return bool
     */
    protected function fire() {
        $name = $this->input->getArgument('name');
        $path = $this->getPath($name);
        if($this->alreadyExists($name)) {
            $this->error("Seeder {$name} already exists!");
            return false;
        }
        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($name));
        $this->composer->dumpAutoloads();
        $this->info("Seeder {$name} created successfully.");
        $this->info('File path : ' . $path . '.');
        return true;
    }
    /**
     * @param $name
     * @return string
     */
    protected function getPath($name) {
        return resource_path('seeds' . DIRECTORY_SEPARATOR . $name . '.php');
    }
    /**
     * @param string $path
     */
    protected function makeDirectory($path) {
        if(!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }
}
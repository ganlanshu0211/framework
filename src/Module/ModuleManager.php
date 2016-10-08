<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 16:26
 */
namespace Notadd\Module;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Notadd\Module\Contracts\Module;
use Notadd\Module\Contracts\ModuleRegistrar;
/**
 * Class ModuleManager
 * @package Notadd\Module
 */
class ModuleManager {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $modules;
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;
    /**
     * ExtensionManager constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Events\Dispatcher $events
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Container $container, Dispatcher $events, Filesystem $filesystem) {
        $this->container = $container;
        $this->events = $events;
        $this->modules = new Collection();
        $this->filesystem = $filesystem;
    }
    /**
     * @return string
     */
    protected function getModulePath() {
        return base_path('modules');
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function getModules() {
        if($this->modules->isEmpty()) {
            if($this->filesystem->exists($file = base_path('vendor/composer') . DIRECTORY_SEPARATOR . 'installed.json')) {
                $packages = new Collection(json_decode($this->filesystem->get($file), true));
                $packages->each(function (array $package) {
                });
            }
            if($this->filesystem->isDirectory($this->getModulePath()) && !empty($directories = $this->filesystem->directories($this->getModulePath()))) {
                (new Collection($directories))->each(function($directory) {
                    if($this->filesystem->exists($bootstrap = $directory . DIRECTORY_SEPARATOR . 'bootstrap.php')) {
                        $module = $this->filesystem->getRequire($bootstrap);
                        if(is_string($module) && in_array(ModuleRegistrar::class, class_implements($module))) {
                            $registrar = $this->container->make($module);
                            $module = $registrar->getModule();
                        }
                        if($module instanceof Module) {
                            $this->modules->put($module->getId(), $module);
                        }
                    }
                });
            }
        }
        return $this->modules;
    }
    /**
     * @return string
     */
    protected function getVendorPath() {
        return base_path('vendor');
    }
}
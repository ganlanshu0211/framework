<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-29 14:07
 */
namespace Notadd\Extension;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Notadd\Extension\Abstracts\ExtensionRegistrar;
/**
 * Class ExtensionManager
 * @package Notadd\Extension
 */
class ExtensionManager {
    /**
     * @var array
     */
    protected $booted = [];
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
    protected $extensions;
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
        $this->extensions = new Collection();
        $this->filesystem = $filesystem;
    }
    /**
     * @param \Notadd\Extension\Abstracts\ExtensionRegistrar $registrar
     */
    public function bootExtension(ExtensionRegistrar $registrar) {
        $registrar->register();
        $this->booted[get_class($registrar)] = $registrar;
    }
    /**
     * @return string
     */
    protected function getExtensionPath() {
        return base_path('extensions');
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function getExtensions() {
        if($this->extensions->isEmpty()) {
            if($this->filesystem->exists($file = base_path('vendor/composer') . DIRECTORY_SEPARATOR . 'installed.json')) {
                $packages = new Collection(json_decode($this->filesystem->get($file), true));
                $packages->each(function (array $package) {
                    $name = Arr::get($package, 'name');
                    if(Arr::get($package, 'type') == 'notadd-extension' && $name) {
                        $extension = new Extension($name, $this->getVendorPath() . DIRECTORY_SEPARATOR . $name);
                        $this->extensions->put($extension->getId(), $extension);
                    }
                });
            }
            if($this->filesystem->isDirectory($this->getExtensionPath()) && !empty($directories = $this->filesystem->directories($this->getExtensionPath()))) {
                (new Collection($directories))->each(function($directory) {
                    if($this->filesystem->exists($file = $directory . DIRECTORY_SEPARATOR . 'composer.json')) {
                        $package = new Collection(json_decode($this->filesystem->get($file), true));
                        if(Arr::get($package, 'type') == 'notadd-extension' && $this->filesystem->exists($bootstrap = $directory . DIRECTORY_SEPARATOR . 'bootstrap.php')) {
                            $extension = $this->filesystem->getRequire($bootstrap);
                            if(is_string($extension) && in_array(ExtensionRegistrar::class, class_parents($extension))) {
                                $registrar = $this->container->make($extension);
                                $extension = $registrar->getExtension();
                            }
                            if($extension instanceof Extension) {
                                $this->extensions->put($extension->getId(), $extension);
                            }
                        }
                    }
                });
            }
        }
        return $this->extensions;
    }
    /**
     * @return string
     */
    protected function getVendorPath() {
        return base_path('vendor');
    }
}
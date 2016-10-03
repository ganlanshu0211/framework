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
use Notadd\Extension\Contracts\Extension as ExtensionContract;
use Notadd\Extension\Contracts\ExtensionRegistrar;
/**
 * Class ExtensionManager
 * @package Notadd\Extension
 */
class ExtensionManager {
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
                    if(Arr::get($package, 'type') != 'notadd-extension' || empty($name)) {
                        return;
                    }
                    $extension = new Extension($name, $this->getVendorPath() . DIRECTORY_SEPARATOR . $name);
                    $this->extensions->put($extension->getId(), $extension);
                });
            }
            if($this->filesystem->exists($this->getExtensionPath()) && !empty($directories = $this->filesystem->directories($this->getExtensionPath()))) {
                $directories = new Collection($directories);
                $directories->each(function($directory) {
                    if(!$this->filesystem->exists($bootstrap = $directory . DIRECTORY_SEPARATOR . 'bootstrap.php')) {
                        return null;
                    }
                    $extension = $this->filesystem->getRequire($bootstrap);
                    if(is_string($extension) && in_array(ExtensionRegistrar::class, class_implements($extension))) {
                        $registrar = $this->container->make($extension);
                        $extension = $registrar->getExtension();
                        return $this->extensions->put($extension->getId(), $extension);
                    } elseif($extension instanceof Extension) {
                        return $this->extensions->put($extension->getId(), $extension);
                    }
                    return null;
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
<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-29 14:07
 */
namespace Notadd\Extension;
use Notadd\Extension\Contracts\Extension as ExtensionContract;
/**
 * Class Extension
 * @package Notadd\Extension
 */
class Extension implements ExtensionContract {
    /**
     * @var bool
     */
    protected $enabled = false;
    /**
     * @var string
     */
    protected $id;
    /**
     * @var bool
     */
    protected $installed = false;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $path;
    /**
     * @var string
     */
    protected $version;
    /**
     * Extension constructor.
     * @param string $name
     * @param string $path
     */
    public function __construct($name, $path) {
        $this->name = $name;
        $this->path = $path;
        $this->assignId();
    }
    /**
     * @return void
     */
    protected function assignId() {
        list($vendor, $package) = explode('/', $this->name);
        $package = str_replace([
            'notadd-ext-',
            'notadd-'
        ], '', $package);
        $this->id = "$vendor-$package";
    }
    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getPath() {
        return $this->path;
    }
    /**
     * @return bool
     */
    public function hasAssets() {
        return realpath($this->path . '/assets/') !== false;
    }
    /**
     * @return bool
     */
    public function hasMigrations() {
        return realpath($this->path . '/migrations/') !== false;
    }
    /**
     * @return array
     */
    public function toArray() {
        return [];
    }
}
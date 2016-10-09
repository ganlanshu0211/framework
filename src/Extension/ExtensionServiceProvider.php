<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-29 14:06
 */
namespace Notadd\Extension;
use Illuminate\Support\Collection;
use Notadd\Foundation\Abstracts\AbstractServiceProvider;
/**
 * Class ExtensionServiceProvider
 * @package Notadd\Extension
 */
class ExtensionServiceProvider extends AbstractServiceProvider {
    /**
     * @var \Illuminate\Support\Collection
     */
    protected static $complies;
    /**
     * ExtensionServiceProvider constructor.
     * @param \Illuminate\Contracts\Foundation\Application $application
     */
    public function __construct($application) {
        parent::__construct($application);
        static::$complies = new Collection();
    }
    /**
     * @param \Notadd\Extension\ExtensionManager $manager
     */
    public function boot(ExtensionManager $manager) {
        $extensions = $manager->getExtensions();
        $extensions->each(function(Extension $extension) use($manager) {
            $registrar = $extension->getRegistrar()->withProvider($this);
            static::$complies = static::$complies->merge($registrar->compiles());
            $manager->bootExtension($registrar);
        });
    }
    /**
     * @return array
     */
    public static function compiles() {
        return static::$complies->toArray();
    }
    /**
     * @return void
     */
    public function register() {
        $this->app->singleton('extensions', function($app) {
            return new ExtensionManager($app, $app['events'], $app['files']);
        });
    }
}
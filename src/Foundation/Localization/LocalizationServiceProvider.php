<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-11 18:41
 */
namespace Notadd\Foundation\Localization;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
/**
 * Class LocalizationServiceProvider
 * @package Notadd\Foundation\Localization
 */
class LocalizationServiceProvider extends ServiceProvider {
    /**
     * @var bool
     */
    protected $defer = true;
    /**
     * @return void
     */
    public function register() {
        $this->app->singleton('localization.loader', function ($app) {
            return new FileLoader($app['files'], $app['path.localization']);
        });
        $this->app->singleton('localizer', function ($app) {
            $loader = $app['localization.loader'];
            $locale = 'zh-cn';
            $trans = new Translator($loader, $locale);
            $trans->setFallback('zh-cn');
            return $trans;
        });
    }
}
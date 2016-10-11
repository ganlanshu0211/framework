<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-19 22:45
 */
require __DIR__ . '/../vendor/autoload.php';
if(file_exists($compiled = realpath(__DIR__ . '/../storage/caches/compiled.php'))) {
    require $compiled;
}
(new Notadd\Foundation\Http\Server(realpath(__DIR__ . '/../')))->listen();
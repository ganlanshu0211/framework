<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-05 14:28
 */
namespace Notadd\Admin\Handlers;
use Notadd\Admin\Jobs\DashboardJob;
use Notadd\Admin\Serializers\DashboardSerializer;
use Notadd\Foundation\Passport\Abstracts\AbstractHandler;
/**
 * Class DashboardDHandler
 * @package Notadd\Admin\Handlers
 */
class DashboardHandler extends AbstractHandler {
    /**
     * @return string
     */
    public function getSerializer() {
        return DashboardSerializer::class;
    }
    /**
     * @return string
     */
    public function getType() {
        return static::RESOURCE;
    }
    /**
     * @return mixed
     */
    public function handle() {
        $data = $this->bus->dispatch(new DashboardJob());
        return $data;
    }
}
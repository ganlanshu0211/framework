<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-23 16:12
 */
namespace Notadd\Foundation\Auth\Events;
use Notadd\Foundation\Http\Contracts\Request;
/**
 * Class Lockout
 * @package Notadd\Foundation\Auth\Events
 */
class Lockout {
    /**
     * @var \Notadd\Foundation\Http\Contracts\Request
     */
    public $request;
    /**
     * Lockout constructor.
     * @param \Notadd\Foundation\Http\Contracts\Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
}
<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-24 15:46
 */
namespace Notadd\Foundation\Session;
use Illuminate\Session\Store as IlluminateStore;
use Notadd\Foundation\Http\Contracts\Request;
use Notadd\Foundation\Session\Contracts\Session as SessionContract;
/**
 * Class Store
 * @package Notadd\Foundation\Session
 */
class Store extends IlluminateStore implements SessionContract {
    /**
     * @param \Notadd\Foundation\Http\Contracts\Request $request
     */
    public function setPsrRequestOnHandler(Request $request) {
        if($this->handlerNeedsRequest()) {
            $this->handler->setRequest($request);
        }
    }
}
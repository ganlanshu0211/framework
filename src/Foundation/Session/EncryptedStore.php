<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-24 16:48
 */
namespace Notadd\Foundation\Session;
use Illuminate\Session\EncryptedStore as IlluminateEncryptedStore;
use Notadd\Foundation\Http\Contracts\Request;
use Notadd\Foundation\Session\Contracts\Session as SessionContract;
/**
 * Class EncryptedStore
 * @package Notadd\Foundation\Session
 */
class EncryptedStore extends IlluminateEncryptedStore implements SessionContract {
    /**
     * @param \Notadd\Foundation\Http\Contracts\Request $request
     */
    public function setPsrRequestOnHandler(Request $request) {
        if($this->handlerNeedsRequest()) {
            $this->handler->setRequest($request);
        }
    }
}
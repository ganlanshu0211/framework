<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-13 17:29
 */
namespace Notadd\Foundation\Routing\Responses;
use Illuminate\Contracts\Support\MessageProvider;
use Illuminate\Session\Store as SessionStore;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Notadd\Foundation\Http\Request;
use Zend\Diactoros\Response\RedirectResponse as ZendRedirectResponse;
/**
 * Class RedirectResponse
 * @package Notadd\Foundation\Routing
 */
class RedirectResponse extends ZendRedirectResponse {
    /**
     * @var \Notadd\Foundation\Http\Request
     */
    protected $request;
    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;
    /**
     * @return \Notadd\Foundation\Routing\Responses\RedirectResponse
     */
    public function exceptInput() {
        return $this->withInput($this->request->except(func_get_args()));
    }
    /**
     * @return \Notadd\Foundation\Http\Request
     */
    public function getRequest() {
        return $this->request;
    }
    /**
     * @return \Illuminate\Session\Store
     */
    public function getSession() {
        return $this->session;
    }
    /**
     * @return \Notadd\Foundation\Routing\Responses\RedirectResponse
     */
    public function onlyInput() {
        return $this->withInput($this->request->only(func_get_args()));
    }
    /**
     * @param $provider
     * @return \Illuminate\Contracts\Support\MessageBag|\Illuminate\Support\MessageBag
     */
    protected function parseErrors($provider) {
        if($provider instanceof MessageProvider) {
            return $provider->getMessageBag();
        }
        return new MessageBag((array)$provider);
    }
    /**
     * @param array $input
     * @return array
     */
    protected function removeFilesFromInput(array $input) {
        foreach($input as $key => $value) {
            if(is_array($value)) {
                $input[$key] = $this->removeFilesFromInput($value);
            }
            //if($value instanceof SymfonyUploadedFile) {
            //    unset($input[$key]);
            //}
        }
        return $input;
    }
    /**
     * @param \Notadd\Foundation\Http\Request $request
     */
    public function setRequest(Request $request) {
        $this->request = $request;
    }
    /**
     * @param \Illuminate\Session\Store $session
     */
    public function setSession(SessionStore $session) {
        $this->session = $session;
    }
    /**
     * @param $provider
     * @param string $key
     * @return \Notadd\Foundation\Routing\Responses\RedirectResponse
     */
    public function withErrors($provider, $key = 'default') {
        $value = $this->parseErrors($provider);
        $this->session->flash('errors', $this->session->get('errors', new ViewErrorBag)->put($key, $value));
        return $this;
    }
    /**
     * Flash an array of input to the session.
     * @param  array $input
     * @return $this
     */
    public function withInput(array $input = null) {
        $input = $input ?: $this->request->input();
        $this->session->flashInput($this->removeFilesFromInput($input));
        return $this;
    }
}
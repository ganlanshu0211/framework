<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-26 16:04
 */
namespace Notadd\Foundation\Routing\Abstracts;
use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Support\Str;
use Notadd\Foundation\Console\Application;
use Notadd\Foundation\Http\Contracts\Request;
use Notadd\Foundation\Http\Traits\ValidatesRequests;
use Notadd\Foundation\Routing\Contracts\Controller as ControllerContract;
/**
 * Class Controller
 * @package Notadd\Foundation\Http\Abstracts
 */
abstract class Controller implements ControllerContract {
    use ValidatesRequests;
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * @var array
     */
    protected $middleware = [];
    /**
     * @var \Notadd\Foundation\Routing\Redirector
     */
    protected $redirector;
    /**
     * @var \Notadd\Foundation\Http\Contracts\Request
     */
    protected $request;
    /**
     * @var \Notadd\Foundation\Session\Contracts\Session
     */
    protected $session;
    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;
    /**
     * Controller constructor.
     */
    public function __construct() {
        $this->container = $this->getContainer();
        $this->events = $this->container->make('events');
        $this->redirector = $this->container->make('redirector');
        $this->request = $this->container->make('request');
        $this->session = $this->request->getAttribute('session');
        $this->view = $this->container->make('view');
    }
    /**
     * @return \Notadd\Foundation\Console\Application
     */
    public function getConsole() {
        return Application::getInstance($this->container);
    }
    /**
     * @return \Illuminate\Config\Repository
     */
    public function getConfig() {
        return $this->container->make('config');
    }
    /**
     * @return \Illuminate\Container\Container
     */
    public function getContainer() {
        return Container::getInstance();
    }
    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger() {
        return $this->container->make('log');
    }
    /**
     * @return \Illuminate\Mail\Mailer
     */
    public function getMailer() {
        return $this->container->make('mailer');
    }
    /**
     * @param string $name
     * @return \Symfony\Component\Console\Command\Command
     */
    public function getCommand($name) {
        return $this->getConsole()->find($name);
    }
    /**
     * @param string $method
     * @return array
     */
    public function getMiddlewareForMethod($method) {
        $middleware = [];
        foreach($this->middleware as $name => $options) {
            if(isset($options['only']) && !in_array($method, (array)$options['only'])) {
                continue;
            }
            if(isset($options['except']) && in_array($method, (array)$options['except'])) {
                continue;
            }
            $middleware[] = $name;
        }
        return $middleware;
    }
    /**
     * @return \Illuminate\Contracts\Validation\Factory|mixed
     */
    protected function getValidationFactory() {
        return $this->container->make(ValidationFactory::class);
    }
    /**
     * @param string $middleware
     * @param array $options
     * @return void
     */
    public function middleware($middleware, array $options = []) {
        $this->middleware[$middleware] = $options;
    }
    /**
     * @param $key
     * @param null $value
     */
    protected function share($key, $value = null) {
        $this->view->share($key, $value);
    }
    /**
     * @param $template
     * @param array $data
     * @param array $mergeData
     * @return \Illuminate\Contracts\View\View
     */
    protected function view($template, array $data = [], $mergeData = []) {
        if(Str::contains($template, '::')) {
            return $this->view->make($template, $data, $mergeData);
        } else {
            return $this->view->make('theme::' . $template, $data, $mergeData);
        }
    }
}
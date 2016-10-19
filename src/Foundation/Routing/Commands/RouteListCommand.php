<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-19 16:49
 */
namespace Notadd\Foundation\Routing\Commands;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Routing\Router;
use Symfony\Component\Console\Input\InputOption;
/**
 * Class RouteListCommand
 * @package Notadd\Foundation\Routing\Commands
 */
class RouteListCommand extends Command {
    /**
     * @var array
     */
    protected $headers = ['Domain', 'Method', 'URI', 'Name', 'Action', 'Middleware'];
    /**
     * @var \Notadd\Foundation\Routing\Router
     */
    protected $router;
    /**
     * @var array
     */
    protected $routes;
    /**
     * RouteListCommand constructor.
     * @param \Notadd\Foundation\Routing\Router $router
     */
    public function __construct(Router $router) {
        parent::__construct();
        $this->router = $router;
        $this->routes = $this->router->getRoutes();
    }
    /**
     * @return void
     */
    protected function configure() {
        $this->addOption('method', null, InputOption::VALUE_OPTIONAL, 'Filter the routes by method.');
        $this->addOption('name', null, InputOption::VALUE_OPTIONAL, 'Filter the routes by name.');
        $this->addOption('path', null, InputOption::VALUE_OPTIONAL, 'Filter the routes by path.');
        $this->addOption('reverse', 'r', InputOption::VALUE_NONE, 'Reverse the ordering of the routes.');
        $this->addOption('sort', null, InputOption::VALUE_OPTIONAL, 'The column (host, method, uri, name, action, middleware) to sort by.', 'uri');
        $this->setDescription('List all registered routes');
        $this->setName('route:list');
    }
    protected function displayRoutes(array $routes) {
        $this->table($this->headers, $routes);
    }
    /**
     * @param array $route
     * @return array|void
     */
    protected function filterRoute(array $route) {
        if(($this->input->getOption('name') && !Str::contains($route['name'], $this->input->getOption('name'))) || $this->input->getOption('path') && !Str::contains($route['uri'], $this->input->getOption('path')) || $this->input->getOption('method') && !Str::contains($route['method'], $this->input->getOption('method'))) {
            return;
        }
        return $route;
    }
    /**
     * @return bool
     */
    protected function fire() {
        if(count($this->routes) == 0) {
            $this->error("Your application doesn't have any routes.");
            return false;
        }
        $results = [];
        foreach($this->routes as $route) {
            $results[] = $this->getRouteInformation($route);
        }
        if($sort = $this->input->getOption('sort')) {
            $results = Arr::sort($results, function ($value) use ($sort) {
                return $value[$sort];
            });
        }
        if($this->input->getOption('reverse')) {
            $results = array_reverse($results);
        }
        $this->displayRoutes(array_filter($results));
        return true;
    }
    /**
     * @param array $route
     * @return array|void
     */
    protected function getRouteInformation(array $route) {
        return $this->filterRoute([
            'host' => isset($route['domain']) ? $route['domain'] : null,
            'method' => $route['method'],
            'uri' => $route['uri'],
            'name' => isset($route['action']['as']) ? $route['action']['as'] : null,
            'action' => $route['action']['uses'] ?: 'Closure',
            'middleware' => isset($route['action']['middleware']) ? $route['action']['middleware'] : null,
        ]);
    }
}
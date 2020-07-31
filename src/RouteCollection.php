<?php
declare(strict_types=1);

namespace FastD\FastRoute;

use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteParser\Std;

/**
 * Class RouteCollection
 * @package FastD\FastRoute
 */
class RouteCollection
{

    /**
     * @var Std
     */
    private Std $routeParser;

    /**
     * @var GroupCountBased
     */
    public GroupCountBased $dataGenerator;

    /**
     * @var string
     */
    protected string $currentGroupPrefix = '';

    /**
     * @var array
     */
    protected array $currentGroupMiddleware = [];

    /**
     * RouteCollection constructor.
     */
    public function __construct()
    {
        $this->routeParser = new Std;
        $this->dataGenerator = new GroupCountBased;
    }

    /**
     * @param $method
     * @param string $path
     * @param $handler
     * @param array $middleware
     * @param array $parameters
     */
    public function addRoute($method, string $path, string $handler, array $middleware = [], array $parameters = [])
    {
        $path = $this->currentGroupPrefix . $path;
        $middleware = $this->currentGroupMiddleware + $middleware;
        $routeDatas = $this->routeParser->parse($path);
        foreach ((array) $method as $value) {
            foreach ($routeDatas as $routeData) {
                $this->dataGenerator->addRoute($value, $routeData, function ($variables) use ($method, $handler, $middleware, $parameters) {
                    return new Route($method, $handler, $variables, (array) $middleware, (array) $middleware);
                });
            }
        }
    }

    /**
     * @param string $prefix
     * @param callable $callable
     * @param array $middleware
     */
    public function addGroup(string $prefix, callable $callable, $middleware = [])
    {
        $previousGroupPrefix = $this->currentGroupPrefix;
        $previousGroupMiddleware = $this->currentGroupMiddleware;
        $this->currentGroupPrefix = $previousGroupPrefix . $prefix;
        $this->currentGroupMiddleware = $previousGroupMiddleware + $middleware;
        $callable($this);
        $this->currentGroupPrefix = $previousGroupPrefix;
        $this->currentGroupMiddleware = $previousGroupMiddleware;
    }

    /**
     * Adds a GET route to the collection
     * @param string $path
     * @param $handler
     * @param array $middleware
     * @param array $parameters
     */
    public function get(string $path, string $handler, array $middleware = [], array $parameters = [])
    {
        $this->addRoute('GET', $path, $handler, $middleware, $parameters);
    }

    /**
     * Adds a POST route to the collection
     * @param string $path
     * @param $handler
     * @param array $middleware
     * @param array $parameters
     */
    public function post(string $path, string $handler, array $middleware = [], array $parameters = [])
    {
        $this->addRoute('POST', $path, $handler, $middleware, $parameters);
    }

    /**
     * Adds a PUT route to the collection
     * @param string $path
     * @param $handler
     * @param array $middleware
     * @param array $parameters
     */
    public function put(string $path, string $handler, array $middleware = [], array $parameters = [])
    {
        $this->addRoute('PUT', $path, $handler, $middleware, $parameters);
    }

    /**
     * Adds a PATCH route to the collection
     * @param string $path
     * @param $handler
     * @param array $middleware
     * @param array $parameters
     */
    public function patch(string $path, string $handler, array $middleware = [], array $parameters = [])
    {
        $this->addRoute('PATCH', $path, $handler, $middleware, $parameters);
    }

    /**
     * Adds a DELETE route to the collection
     * @param string $path
     * @param $handler
     * @param array $middleware
     * @param array $parameters
     */
    public function delete(string $path, string $handler, array $middleware = [], array $parameters = [])
    {
        $this->addRoute('DELETE', $path, $handler, $middleware, $parameters);
    }

    /**
     * Adds a OPTIONS route to the collection
     * @param string $path
     * @param $handler
     * @param array $middleware
     * @param array $parameters
     * @return mixed
     */
    public function options(string $path, string $handler, array $middleware = [], array $parameters = [])
    {
        $this->addRoute('OPTIONS', $path, $handler, $middleware, $parameters);
    }

}

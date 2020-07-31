<?php
declare(strict_types=1);

namespace FastD\FastRoute;

use FastRoute\Dispatcher\GroupCountBased;

/**
 * Class RouteDispatcher
 * @package FastD\FastRoute
 */
class RouteDispatcher
{
    /**
     * @var RouteCollection
     */
    protected RouteCollection $routeCollection;

    /**
     * RouteDispatcher constructor.
     *
     * @param RouteCollection $routeCollection
     */
    public function __construct(RouteCollection $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }

    /**
     * @param $method
     * @param $path
     * @return array|mixed[]
     */
    public function dispatch($method, $path)
    {
        return (new GroupCountBased($this->routeCollection->dataGenerator->getData()))->dispatch($method, $path);
    }

}

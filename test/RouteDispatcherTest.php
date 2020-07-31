<?php

use FastD\FastRoute\Route;
use FastD\FastRoute\RouteCollection;
use FastD\FastRoute\RouteDispatcher;
use PHPUnit\Framework\TestCase;

class RouteDispatcherTest extends TestCase
{
    /**
     * @var RouteCollection
     */
    protected RouteCollection $routeCollection;

    public function setUp()
    {
        $this->routeCollection = new RouteCollection();
    }

    public function testDispatchStaticRoute()
    {
        $this->routeCollection->addRoute('GET', '/name', hello::class);
        $dispatch = new RouteDispatcher($this->routeCollection);
        $info = $dispatch->dispatch('GET', '/name');

        self::assertEquals($info[0], FastRoute\Dispatcher::FOUND);
    }

    public function testDispatchRegexRoute()
    {
        $this->routeCollection->addRoute('GET', '/{name}', hello::class);
        $dispatch = new RouteDispatcher($this->routeCollection);
        $info = $dispatch->dispatch('GET', '/php.net');

        self::assertEquals($info[0], FastRoute\Dispatcher::FOUND);
        self::assertArrayHasKey('name', $info[2]);
        self::assertEquals($info[2]['name'], 'php.net');
    }

    public function testDispatchHandler()
    {
        $this->routeCollection->addRoute('GET', '/name', hello::class);
        $dispatch = new RouteDispatcher($this->routeCollection);
        $info = $dispatch->dispatch('GET', '/name');
        $handler = $info[1];
        $vars = $info[2];

        self::assertContainsOnlyInstancesOf(Route::class, [$handler($vars)]);

    }

}

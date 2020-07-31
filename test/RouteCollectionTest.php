<?php

use FastD\FastRoute\RouteCollection;
use PHPUnit\Framework\TestCase;

class RouteCollectionTest extends TestCase
{
    /**
     * @var RouteCollection
     */
    protected RouteCollection $routeCollection;

    public function setUp()
    {
        $this->routeCollection = new RouteCollection();
    }

    public function testAddStaticRoute()
    {
        $this->routeCollection->addRoute('GET', '/get', hello::class);
        $this->routeCollection->addRoute('POST', '/post', hello::class);
        $this->routeCollection->addRoute(['GET', 'POST'], '/get_or_post', hello::class);

        self::assertCount(2, $this->routeCollection->dataGenerator->getData()[0]['GET']);
        self::assertCount(2, $this->routeCollection->dataGenerator->getData()[0]['POST']);
    }

    public function testAddRegexRoute()
    {
        $this->routeCollection->addRoute('GET', '/{name}/{age}', hello::class);
        $this->routeCollection->addRoute('POST', '/{name}/{address}', hello::class);

        self::assertCount(1, $this->routeCollection->dataGenerator->getData()[1]['GET']);
        self::assertCount(1, $this->routeCollection->dataGenerator->getData()[1]['POST']);
    }

    public function testAddGroupRoute()
    {
        $this->routeCollection->addGroup('/group', function (RouteCollection $route) {
            $route->addRoute('GET', '/test', hello::class);
            $route->addRoute('GET', '/{name}', hello::class);
            $route->addGroup('/child', function (RouteCollection $route) {
                $route->addRoute('GET', '/child_test', hello::class);
            });
        });

        self::assertCount(2, $this->routeCollection->dataGenerator->getData()[0]['GET']);
        self::assertCount(1, $this->routeCollection->dataGenerator->getData()[1]['GET']);
    }

}

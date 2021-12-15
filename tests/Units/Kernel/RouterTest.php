<?php

use Kernel\Interfaces\RouterInterface;
use Kernel\Router;
use Tests\TestCase;

class RouterTest extends TestCase
{
    private RouterInterface $router;

    public function setUp(): void
    {
        parent::setUp();
        $this->router = new Router();
    }

    /**
     * @test
     * @covers Router
     */
    public function itShouldRegisterRouteTypeGet()
    {
        $this->router->get('foo', 'App\Controllers\HomeController', 'index');

        $routes = $this->getProperty($this->router, 'routes');

        $expected = [
            'foo' => [
                'method' => 'GET',
                'regex' => '/foo/',
                'controller' => 'App\Controllers\HomeController',
                'action' => 'index'
            ]
        ];

        $this->assertEquals($expected, $routes);
    }

    /**
     * @test
     * @covers Router
     */
    public function itShouldRegisterRouteTypeGetWithRouterParams()
    {
        $this->router->get('foo/{id}/bar/{bar_id}', 'App\Controllers\HomeController', 'index');

        $routes = $this->getProperty($this->router, 'routes');

        $expected = [
            'foo/{id}/bar/{bar_id}' => [
                'method' => 'GET',
                'regex' => '/foo\/+[a-zA-z1-9]+\/bar\/+[a-zA-z1-9]/',
                'controller' => 'App\Controllers\HomeController',
                'action' => 'index'
            ]
        ];

        $this->assertEquals($expected, $routes);
    }

    /**
     * @test
     * @covers Router
     */
    public function itShouldReturnRouteInfoByUri()
    {
        $this->setProperty($this->router, 'routes', [
            'foo' => [
                'method' => 'GET',
                'regex' => '/foo/',
                'controller' => 'App\Controllers\HomeController',
                'action' => 'index'
            ]
        ]);

        $routeInfo = $this->router->getRouteInfo('foo');

        $expected = [
            'method' => 'GET',
            'regex' => '/foo/',
            'controller' => 'App\Controllers\HomeController',
            'action' => 'index',
            'params' => []
        ];

        $this->assertEquals($expected, $routeInfo);
    }

    /**
     * @test
     * @covers Router
     */
    public function itShouldReturnRouteInfoByUriWithParams()
    {
        $this->setProperty($this->router, 'routes', [
            'foo/{id}/bar/{bar_id}' => [
                'method' => 'GET',
                'regex' => '/foo\/+[a-zA-z1-9]+\/bar\/+[a-zA-z1-9]/',
                'controller' => 'App\Controllers\HomeController',
                'action' => 'index'
            ]
        ]);

        $routeInfo = $this->router->getRouteInfo('foo/123/bar/abc');

        $expected = [
            'method' => 'GET',
            'regex' => '/foo\/+[a-zA-z1-9]+\/bar\/+[a-zA-z1-9]/',
            'controller' => 'App\Controllers\HomeController',
            'action' => 'index',
            'params' => [
                'id' => '123',
                'bar_id' => 'abc'
            ]
        ];

        $this->assertEquals($expected, $routeInfo);
    }


    /**
     * @test
     * @covers Router
     * @dataProvider routerProvider
     */
    public function itShouldReturnExptionRouteNotFound()
    {
        $this->expectExceptionMessage('Route not found');
        $this->expectExceptionCode(404);

        (new Router())->getRouteInfo('');
    }
}

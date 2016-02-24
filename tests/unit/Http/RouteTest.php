<?php

namespace RayRutjes\Tsr\Test\Unit\Http;

use RayRutjes\Tsr\Http\JsonResponse;
use RayRutjes\Tsr\Http\Request;
use RayRutjes\Tsr\Http\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider invalidMethods
     * @expectedException \InvalidArgumentException
     */
    public function testShouldOnlyAcceptValidMethods($invalidMethod)
    {
        new Route($invalidMethod, '/', function() {});
    }

    public function invalidMethods()
    {
        return [
            ['PUT'],
            ['PATH'],
            ['other'],
            [''],
        ];
    }

    /**
     * @dataProvider matchesProvider
     */
    public function testCanTellIfARequestMatchesTheRoute($routeMethod, $routePath, $requestMethod, $requestUri, $shouldMatch)
    {
        $route = new Route($routeMethod, $routePath, function() {});
        $request = new Request($requestMethod, $requestUri);
        $this->assertEquals($shouldMatch, $route->matches($request));
    }

    public function matchesProvider()
    {
        // routeMethod, routePath, requestMethod, requestUri, shouldMatch
        return [
            ['GET', '/users', 'GET', '/users', true],
            ['GET', '/users/', 'GET', '/users', false],
            ['GET', '/users', 'GET', '/users?query=string', true],
            ['GET', '/users', 'POST', '/users', false],
            ['GET', '/users/:user_id', 'GET', '/users/99', true],
            ['GET', '/users/:user_id', 'GET', '/users/99/action', false],
            ['GET', '/users/:user_id/action', 'GET', '/users/99', false],
        ];
    }

    public function testDispatchesTheCallbackWithDynamicArgsAndRequest()
    {
        $request = new Request('GET', '/users/99');
        $route = new Route('GET', '/users/:user_id', function() use ($request) {
            $args = func_get_args();
            // userId and request.
            $this->assertCount(2, $args);
            $this->assertEquals('99', $args[0]);
            $this->assertSame($request, $args[1]);

            return new JsonResponse(200);
        });
        $route->dispatchWith($request);
    }
}

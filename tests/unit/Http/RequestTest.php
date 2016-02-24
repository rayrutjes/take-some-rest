<?php

namespace RayRutjes\Tsr\Test\Unit\Http;

use RayRutjes\Tsr\Http\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testCanBeCreatedFromEnvironment()
    {
        $_SERVER['REQUEST_URI'] = '/my/path';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = Request::current();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/my/path', $request->getPath());
    }

    /**
     * @dataProvider uriProvider
     */
    public function testShouldNormalizePath($uri, $path)
    {
        $request = new Request('GET', $uri);
        $this->assertEquals($path, $request->getPath());
    }

    public function uriProvider()
    {
        return [
            ['/my/path', '/my/path'],
            ['/my/path/', '/my/path/'],
            ['/my/path?query=string', '/my/path'],
        ];
    }
}

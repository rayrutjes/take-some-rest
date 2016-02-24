<?php

namespace RayRutjes\Tsr\Http;

final class Router
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    /**
     * @param Request $request
     *
     * @return ResponseInterface
     *
     * @throw RuntimeException
     */
    public function dispatch(Request $request): ResponseInterface
    {
        foreach ($this->routes as $route) {
            /** @var Route $route */
            if ($route->matches($request)) {
                return $route->dispatchWith($request);
            }
        }

        // Todo: type the exception so that it can be handled appropriately.
        throw new \RuntimeException(sprintf('No route found for path: %s %s', $request->getMethod(), $request->getPath()));
    }
}

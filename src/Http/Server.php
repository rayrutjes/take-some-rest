<?php

namespace RayRutjes\Tsr\Http;

use RayRutjes\Tsr\Persistence\NotFoundException;

final class Server
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Dispatches the current request and sends a response.
     */
    public function run()
    {
        $request = Request::current();
        try {
            $response = $this->router->dispatch($request);
        } catch (NotFoundException $e) {
            // We intercept NotFoundExceptions so as to provide the correct http response code.
            // Let other eventually raised exceptions bubble up to the http server.
            $response = new JsonResponse(JsonResponse::STATUS_NOT_FOUND);
        }
        $response->send();
    }
}

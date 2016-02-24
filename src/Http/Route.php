<?php

namespace RayRutjes\Tsr\Http;

final class Route
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @var callable
     */
    private $action;

    /**
     * @var array
     */
    private $methods = ['GET', 'POST', 'DELETE'];

    /**
     * Route constructor.
     *
     * @param string   $method
     * @param string   $path
     * @param callable $action
     */
    public function __construct(string $method, string $path, callable $action)
    {
        $method = strtoupper($method);
        if (!in_array($method, $this->methods)) {
            throw new \InvalidArgumentException(sprintf('Method is not valid, Got: %s', $method));
        }
        $this->method = $method;
        $this->path = $path;
        $this->action = $action;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function matches(Request $request): bool
    {
        if ($request->getMethod() != $this->method) {
            return false;
        }

        $requestPathParts = explode('/', $request->getPath());
        $pathParts = explode('/', $this->path);

        if (count($requestPathParts) !== count($pathParts)) {
            return false;
        }

        foreach ($pathParts as $index => $value) {

            // A dynamic path part like :user_id.
            if ($this->isDynamicPathPart($value)) {
                continue;
            }

            if ($value != $requestPathParts[$index]) {
                return false;
            }
        }

        return true;
    }

    /**
     * If the path part starts with ":" then we assume it is a dynamic part.
     *
     * @param $part
     *
     * @return bool
     */
    private function isDynamicPathPart($part): bool
    {
        return strrpos($part, ':', -strlen($part)) !== false;
    }

    /**
     * Extract dynamic parts and inject them with the request inside the callback.
     *
     * @param Request $request
     *
     * @return ResponseInterface
     */
    public function dispatchWith(Request $request): ResponseInterface
    {
        $requestPathParts = explode('/', $request->getPath());
        $pathParts = explode('/', $this->path);

        $args = [];
        foreach ($pathParts as $index => $value) {

            // A dynamic path part like :user_id.
            if (!$this->isDynamicPathPart($value)) {
                continue;
            }
            $args[] = $requestPathParts[$index];
        }
        $args[] = $request;

        return call_user_func($this->action, ...$args);
    }
}

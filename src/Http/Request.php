<?php

namespace RayRutjes\Tsr\Http;

final class Request
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $body;

    /**
     * @var string
     */
    private $queryString;

    /**
     * @param string $method
     * @param string $uri
     * @param array  $body
     */
    public function __construct(string $method, string $uri, array $body = [])
    {
        $this->method = $method;

        $uriParts = explode('?', $uri);
        $this->path = $uriParts[0];
        $this->queryString = $uriParts[1] ?? '';

        $this->body = $body;
    }

    /**
     * @return Request
     */
    public static function current(): Request
    {
        $body = [];
        if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $input = file_get_contents('php://input');
            $body = json_decode($input, true);
        }

        return new self($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $body);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }
}

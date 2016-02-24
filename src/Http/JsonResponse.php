<?php

namespace RayRutjes\Tsr\Http;

final class JsonResponse implements ResponseInterface
{
    /**
     * Request succeeded for a GET call, for a DELETE that completed synchronously.
     */
    const STATUS_OK = 200;

    /**
     * Request succeeded for a POST call that completed synchronously, or for a PUT call that synchronously created a
     * new resource.
     */
    const STATUS_CREATED = 201;

    /**
     * Not found.
     */
    const STATUS_NOT_FOUND = 404;

    /**
     * @var array
     */
    private $supportedStatusCodes = [self::STATUS_OK, self::STATUS_CREATED, self::STATUS_NOT_FOUND];

    /**
     * @var array
     */
    private $statusMessages = [
        self::STATUS_OK        => 'OK',
        self::STATUS_CREATED   => 'CREATED',
        self::STATUS_NOT_FOUND => 'NOT FOUND',
    ];

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $body;

    /**
     * @param int   $statusCode
     * @param array $body
     */
    public function __construct(int $statusCode, array $body = [])
    {
        if (!in_array($statusCode, $this->supportedStatusCodes)) {
            throw new \InvalidArgumentException(sprintf('Unsupported status code, Got: %d', $statusCode));
        }
        $this->statusCode = $statusCode;
        $this->body = json_encode($body);
    }

    /**
     *  Sends the headers and the contents.
     */
    public function send()
    {
        // Todo: This can be enhanced by allowing to change the protocol and its version.
        header(sprintf('HTTP/1.1 %d %s', $this->statusCode, $this->statusMessages[$this->statusCode]));
        header(sprintf('Content-Length: %s', strlen($this->body)));
        header('Content-Type: application/json');
        echo $this->body;
    }
}

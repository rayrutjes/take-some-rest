<?php

namespace RayRutjes\Tsr\Http;

interface ResponseInterface
{
    /**
     *  Sends the headers and the contents.
     */
    public function send();
}

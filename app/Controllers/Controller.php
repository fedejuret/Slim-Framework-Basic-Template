<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class Controller
{
    private ResponseFactoryInterface $responseFactory;

    protected ResponseInterface $response;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
        $this->response = $responseFactory->createResponse();
    }
}
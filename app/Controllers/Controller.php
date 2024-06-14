<?php

namespace App\Controllers;

use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;

abstract class Controller
{
    private ResponseFactoryInterface $responseFactory;

    /**
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param array|null $data
     * @param int $statusCode
     * @return ResponseInterface
     */
    protected function response(?array $data = null, int $statusCode = 200): ResponseInterface
    {
        $responseInterface = $this->responseFactory->createResponse($statusCode)->withHeader('Content-Type', 'application/json');
        $responseInterface->getBody()->write(json_encode($data));
        return $responseInterface;
    }
}
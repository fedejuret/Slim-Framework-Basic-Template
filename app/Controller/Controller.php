<?php

namespace App\Controller;

use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;

abstract class Controller
{

    /**
     * @param ResponseInterface $response
     * @param array|null $data
     * @param int $statusCode
     * @return ResponseInterface
     */
    protected function response(ResponseInterface $response, ?array $data = null, int $statusCode = 200): ResponseInterface
    {
        $responseInterface = $response->withHeader('Content-Type', 'application/json');
        $responseInterface->getBody()->write(json_encode($data));
        return $responseInterface;
    }
}
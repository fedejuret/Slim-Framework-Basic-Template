<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;

abstract class Controller
{
    protected function response(ResponseInterface $response, ?array $data = null, int $statusCode = 200): ResponseInterface
    {
        $responseInterface = $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
        $responseInterface->getBody()->write(json_encode($data));
        return $responseInterface;
    }
}

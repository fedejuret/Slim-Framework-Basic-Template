<?php

require '../vendor/autoload.php';

use Jgut\Slim\Routing\AppFactory;
use Jgut\Slim\Routing\Configuration;
use DI\Container;

// Create Container using PHP-DIcd
$container = new Container();

// Set ResponseFactoryInterface in container
$container->set(\Psr\Http\Message\ResponseFactoryInterface::class, function () {
    return new Slim\Psr7\Factory\ResponseFactory();
});

// Set the container to create the App with the factory
\Slim\Factory\AppFactory::setContainer($container);

$configuration = new Configuration([
    'sources' => ['../app/Controllers'],
]);
AppFactory::setRouteCollectorConfiguration($configuration);

// Instantiate the app
$app = AppFactory::create();

$routeCollector = $app->getRouteCollector();
$responseFactory = $app->getResponseFactory();

// Register routes
$routeCollector->registerRoutes();

$app->run();
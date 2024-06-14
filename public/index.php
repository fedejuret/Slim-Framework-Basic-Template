<?php

require '../vendor/autoload.php';

use Jgut\Slim\Routing\AppFactory;
use Jgut\Slim\Routing\Configuration;
use DI\Container;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..', '.env');
$dotenv->load();

// Create Container using PHP-DIcd
$container = new Container();

// Set ResponseFactoryInterface in container
$container->set(\Psr\Http\Message\ResponseFactoryInterface::class, function () {
    return new Slim\Psr7\Factory\ResponseFactory();
});

$container->set('db', require __DIR__ . '/../config/database.php');

// Set the container to create the App with the factory
\Slim\Factory\AppFactory::setContainer($container);

$configuration = new Configuration([
    'sources' => ['../app/Controllers'],
]);
AppFactory::setRouteCollectorConfiguration($configuration);

// Instantiate the app
$app = AppFactory::create();

$database = $container->get('db');

// Set up Eloquent ORM
$capsule = new Illuminate\Database\Capsule\Manager();
$capsule->addConnection($database['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$routeCollector = $app->getRouteCollector();
$responseFactory = $app->getResponseFactory();

// Register routes
$routeCollector->registerRoutes();

$app->run();
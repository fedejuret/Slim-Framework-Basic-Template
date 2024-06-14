<?php

require '../vendor/autoload.php';

use Jgut\Slim\Routing\AppFactory;
use Jgut\Slim\Routing\Configuration;
use DI\ContainerBuilder;
use function DI\autowire;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..', '.env');
$dotenv->load();

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    'App\\' => autowire(),

    \Psr\Http\Message\ResponseFactoryInterface::class => \DI\create(Slim\Psr7\Factory\ResponseFactory::class),

    'db' => function () {
        return require __DIR__ . '/../config/database.php';
    },
]);
$containerBuilder->useAutowiring(true);

$container = $containerBuilder->build();

\Slim\Factory\AppFactory::setContainer($container);

$configuration = new Configuration([
    'sources' => ['../app/Controllers'],
]);
AppFactory::setRouteCollectorConfiguration($configuration);

$app = AppFactory::create();

$database = $container->get('db');

$capsule = new Illuminate\Database\Capsule\Manager();
$capsule->addConnection($database['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$routeCollector = $app->getRouteCollector();
$responseFactory = $app->getResponseFactory();

$app->run();

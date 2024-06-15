<?php

require '../vendor/autoload.php';

use DI\ContainerBuilder;
use Jgut\Slim\Routing\AppFactory;
use Jgut\Slim\Routing\Configuration;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..', '.env');
$dotenv->load();

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    \Psr\Http\Message\ResponseFactoryInterface::class => \DI\create(Slim\Psr7\Factory\ResponseFactory::class),

    'db' => function () {
        return require __DIR__ . '/../config/database.php';
    },
]);
$containerBuilder->useAutowiring(true);

$container = $containerBuilder->build();

$loggingConfig = require __DIR__ . '/../config/logging.php';
\App\Logging\LoggerFactory::createLoggers($container, $loggingConfig);

\Slim\Factory\AppFactory::setContainer($container);

$configuration = new Configuration([
    'sources' => ['../app/Controller'],
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

$handlers = require __DIR__ . '/../config/exception_handler.php';
$app->add(new \App\Exception\ExceptionMiddleware($handlers, $container));

$app->run();

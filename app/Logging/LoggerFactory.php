<?php

declare(strict_types=1);

namespace App\Logging;

use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;

class LoggerFactory
{
    /**
     * @throws ReflectionException
     */
    public static function createLoggers(ContainerInterface $container, array $config): void
    {
        foreach ($config['channels'] as $name => $channel) {
            $logger = new Logger($name);
            $handlerClass = $channel['handler'];
            $params = $channel['params'];

            // Use reflection to instantiate the handler with the given parameters
            $reflection = new ReflectionClass($handlerClass);
            $handler = $reflection->newInstanceArgs($params);
            $logger->pushHandler($handler);
            $container->set("logger.{$name}", $logger);

            // Optionally set the default logger
            if ($name === $config['default']) {
                $container->set(Logger::class, $logger);
                $container->set(LoggerInterface::class, $logger);
            }
        }
    }
}

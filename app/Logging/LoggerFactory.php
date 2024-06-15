<?php

namespace App\Logging;

use ReflectionException;
use Psr\Container\ContainerInterface;
use Monolog\Logger;

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
            $reflection = new \ReflectionClass($handlerClass);
            $handler = $reflection->newInstanceArgs($params);
            $logger->pushHandler($handler);
            $container->set("logger.{$name}", $logger);

            // Optionally set the default logger
            if ($name === $config['default']) {
                $container->set(Logger::class, $logger);
                $container->set(\Psr\Log\LoggerInterface::class, $logger);
            }
        }
    }
}
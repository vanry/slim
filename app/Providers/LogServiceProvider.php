<?php

namespace App\Providers;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LogServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['logger'] = function ($container) {
            $config = $container['config'];

            $logger = new Logger($config['logger.name']);

            $logger->pushProcessor(new WebProcessor);

            $handler = new RotatingFileHandler($config['logger.path'], $config['logger.max_files'], $config['logger.level']);

            $handler->setFormatter(new LineFormatter(null, $config['logger.date_format'], true, true));

            $logger->pushHandler($handler);

            return $logger;
        };
    }
}

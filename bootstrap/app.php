<?php

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;
use Noodlehaus\Config;
use Pimple\Container;
use Pimple\Psr11\Container as PsrContainer;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Slim\Views\PhpRenderer;

require __DIR__.'/../vendor/autoload.php';

$container = new Container;

$container['config'] = function () {
    return new Config(app_path('config.php'));
};

$container['logger'] = function ($container) {
    $config = $container['config'];

    $logger = new Logger($config->get('logger.name'));

    $logger->pushProcessor(new WebProcessor);

    $handler = new RotatingFileHandler(
        $config->get('logger.path'),
        $config->get('logger.max_files'),
        $config->get('logger.level'),
    );

    $handler->setFormatter(new LineFormatter(null, $config->get('logger.date_format'), true, true));

    $logger->pushHandler($handler);

    return $logger;
};

$container['view'] = function ($container) {
    $config = $container['config'];

    $view = new PhpRenderer($config->get('view.path'));

    if ($layout = $config->get('view.layout')) {
        $view->setLayout($layout);
    }

    return $view;
};

$app = AppFactory::createFromContainer(new PsrContainer($container));

$app->addErrorMiddleware($container['config']['app.debug'], true, true, $container['logger']);

$app->getRouteCollector()->setDefaultInvocationStrategy(new RequestResponseArgs);

return $app;

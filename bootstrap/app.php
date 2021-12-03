<?php

require __DIR__.'/../vendor/autoload.php';

$container = new Pimple\Container;

$container->register(new App\Providers\LogServiceProvider);
$container->register(new App\Providers\ViewServiceProvider);
$container->register(new App\Providers\ConfigServiceProvider);

$app = Slim\Factory\AppFactory::createFromContainer(
    new Pimple\Psr11\Container($container)
);

$errorHandler = new App\Handlers\ErrorHandler(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    $container->offsetGet('logger'),
);

$app->addErrorMiddleware($container['config']['app.debug'], true, true)
    ->setDefaultErrorHandler($errorHandler);

$app->getRouteCollector()->setDefaultInvocationStrategy(
    new Slim\Handlers\Strategies\RequestResponseArgs
);

return $app;

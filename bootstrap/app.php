<?php

require __DIR__.'/../vendor/autoload.php';

date_default_timezone_set(config('app.timezone'));

$container = new Pimple\Container;

$container->register(new App\Providers\LogServiceProvider);
$container->register(new App\Providers\ViewServiceProvider);

$app = Slim\Factory\AppFactory::createFromContainer(
    new Pimple\Psr11\Container($container)
);

$errorHandler = new App\Handlers\ErrorHandler(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    $container->offsetGet('logger'),
);

$app->addErrorMiddleware(config('app.debug'), true, true)
    ->setDefaultErrorHandler($errorHandler);

$app->getRouteCollector()->setDefaultInvocationStrategy(
    new Slim\Handlers\Strategies\RequestResponseArgs
);

return $app;

<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;

class PhpRendererMiddleware implements MiddlewareInterface
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var \Slim\Views\PhpRenderer */
        $view = $this->app->getContainer()->get('view');

        $view->addAttribute('request', $request);
        $view->addAttribute('routeParser', $this->app->getRouteCollector()->getRouteParser());

        return $handler->handle($request);
    }
}

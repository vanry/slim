<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\PhpRenderer;

class PhpRendererMiddleware implements MiddlewareInterface
{
    protected $renderer;

    protected $routeParser;

    public function __construct(PhpRenderer $renderer, RouteParserInterface $routeParser)
    {
        $this->renderer = $renderer;
        $this->routeParser = $routeParser;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->renderer->addAttribute('uri', $request->getUri());
        $this->renderer->addAttribute('routeParser', $this->routeParser);

        return $handler->handle($request);
    }
}

<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = require __DIR__.'/../bootstrap/app.php';

$app->get('/', function (Request $request, Response $response) {
    return $this->get('view')->render($response, 'index.php');
});

$app->run();

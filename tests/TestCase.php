<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Slim\App;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;
use Slim\Psr7\Uri;

class TestCase extends PHPUnitTestCase
{
    /**
     * The Slim App instance.
     *
     * @var \Slim\App
     */
    protected $app;

    protected function setUp(): void
    {
        $this->app = $this->createApp();
    }

    protected function createApp(): App
    {
        return require base_path('bootstrap/app.php');
    }

    protected function tearDown(): void
    {
        $this->app = null;
    }

    public function createRequest(
        $method,
        $path,
        array $headers,
        array $cookies = [],
        array $serverParams = [],
        array $uploadedFiles = []
    ) {
        $uri = new Uri('', '', null, $path);

        $slimHeaders = new Headers($headers);

        $stream = (new StreamFactory)->createStream();

        return new Request($method, $uri, $slimHeaders, $cookies, $serverParams, $stream, $uploadedFiles);
    }
}

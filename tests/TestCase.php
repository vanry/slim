<?php

namespace Tests;

use Fig\Http\Message\StatusCodeInterface as StatusCode;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Psr\Http\Message\UploadedFileInterface;
use Slim\App;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Factory\UriFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;

class TestCase extends PHPUnitTestCase
{
    /**
     * The Slim App instance.
     *
     * @var \Slim\App
     */
    protected $app;

    /**
     * The Psr7 Response instance.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * Request headers.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Request cookies.
     *
     * @var array
     */
    protected $cookies = [];

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

    public function withHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    public function withHeader(string $name, string $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    public function flushHeaders()
    {
        $this->headers = [];

        return $this;
    }

    public function withCookies(array $cookies)
    {
        $this->cookies = array_merge($this->cookies, $cookies);

        return $this;
    }

    public function withCookie(string $name, string $value)
    {
        $this->cookies[$name] = $value;

        return $this;
    }

    public function get(string $uri)
    {
        return $this->call('GET', $uri);
    }

    public function post(string $uri, array $data = [])
    {
        return $this->call('POST', $uri, $data);
    }

    public function put(string $uri, array $data = [])
    {
        return $this->call('PUT', $uri, $data);
    }

    public function patch(string $uri, array $data = [])
    {
        return $this->call('PATCH', $uri, $data);
    }

    public function delete(string $uri, array $data = [])
    {
        return $this->call('DELETE', $uri, $data);
    }

    public function options(string $uri, array $data = [])
    {
        return $this->call('OPTIONS', $uri, $data);
    }

    public function call(string $method, string $uri, array $data = [])
    {
        $serverParams = $this->getServerParamsFromHeaders($this->headers);

        $uploadedFiles = $this->extractFilesFromData($data);

        $request = $this->createRequest($method, $uri, $this->headers, $this->cookies, $serverParams, $uploadedFiles);

        if ($data) {
            $request = $request->withParsedBody($data);
        }

        $this->response = $this->app->handle($request);

        return $this;
    }

    protected function getServerParamsFromHeaders(array $headers)
    {
        $serverParams = [];

        foreach ($headers as $name => $value) {
            $serverParams[$this->formatServerHeaderKey($name)] = $value;
        }

        return $serverParams;
    }

    protected function formatServerHeaderKey(string $name)
    {
        $name = strtr(strtoupper($name), '-', '_');

        if (strpos($name, 'HTTP_') !== 0 && ! in_array($name, ['CONTENT_TYPE', 'REMOTE_ADDR'])) {
            return 'HTTP_'.$name;
        }

        return $name;
    }

    protected function extractFilesFromData(array &$data)
    {
        $files = [];

        foreach ($data as $key => $value) {
            if ($value instanceof UploadedFileInterface) {
                $files[$key] = $value;
            }

            if (is_array($value)) {
                $files[$key] = $this->extractFilesFromData($value);
            }

            if (array_key_exists($key, $files)) {
                unset($data[$key]);
            }
        }

        return $files;
    }

    public function createRequest(
        string $method,
        string $uri,
        array $headers = [],
        array $cookies = [],
        array $serverParams = [],
        array $uploadedFiles = []
    ) {
        $uri = (new UriFactory)->createUri($uri);

        $headers = new Headers($headers);

        $stream = (new StreamFactory)->createStream();

        return new Request($method, $uri, $headers, $cookies, $serverParams, $stream, $uploadedFiles);
    }

    public function assertResponseOk()
    {
        return $this->assertResponseStatus(StatusCode::STATUS_OK);
    }

    public function assertResponseStatus(int $status)
    {
        $this->assertEquals($status, $this->response->getStatusCode());

        return $this;
    }

    public function assertSee(string $value)
    {
        $this->assertStringContainsString($value, (string) $this->response->getBody());
    }
}

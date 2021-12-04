<?php

namespace App\Handlers;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Handlers\ErrorHandler as Handler;

class ErrorHandler extends Handler
{
    protected function logError(string $error): void
    {
        if ($this->statusCode == StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR) {
            $this->logger->error($error);
        }
    }
}

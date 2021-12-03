<?php

namespace App\Handlers;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Handlers\ErrorHandler as Handler;

class ErrorHandler extends Handler
{
    const SERVER_ERROR_STATUS_CODE = 500;

    protected function logError(string $error): void
    {
        if ($this->statusCode == StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR) {
            $this->logger->error($error);
        }
    }
}

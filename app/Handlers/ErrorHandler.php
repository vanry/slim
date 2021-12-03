<?php

namespace App\Handlers;

use Slim\Handlers\ErrorHandler as Handler;

class ErrorHandler extends Handler
{
    const SERVER_ERROR_STATUS_CODE = 500;

    protected function logError(string $error): void
    {
        if ($this->statusCode >= static::SERVER_ERROR_STATUS_CODE) {
            $this->logger->error($error);
        }
    }
}

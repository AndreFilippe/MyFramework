<?php

namespace App\Exception;

class Handler extends \Exception
{
    public function __construct(\Throwable $exception)
    {
        echo '<pre>';
        var_dump([
            'message' => $exception->getMessage(),
            'statusCode' => $exception->getCode(),
            'debug' => $exception
        ]);
        echo '</pre>';

        parent::__construct($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
    }
}

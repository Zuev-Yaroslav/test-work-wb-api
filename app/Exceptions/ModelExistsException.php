<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ModelExistsException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function checkExistsModel(?string $model) : void
    {
        if (!config('entities.models.' . $model)) {
            throw new ModelExistsException("Model $model does not exist", 404);
        }
    }

}

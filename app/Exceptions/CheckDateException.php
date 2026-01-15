<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class CheckDateException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function checkFormatDate(string|null $date) : void
    {
        if ($date && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date))
        {
            throw new CheckDateException('Wrong date format');
        }
    }

}

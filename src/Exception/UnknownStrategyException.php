<?php

namespace Denno\Censor\Exception;

use Exception;
use Throwable;

class UnknownStrategyException extends Exception
{
    CONST MSG = 'Unknown strategy given: ';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(self::MSG.$message, $code, $previous);
    }
}
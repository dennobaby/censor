<?php

namespace Censor\Exception;

use Throwable;

class BoundaryException extends \Exception
{
    CONST MSG = 'Positions out of boundary';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(self::MSG.$message, $code, $previous);
    }
}
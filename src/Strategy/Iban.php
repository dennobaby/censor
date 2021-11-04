<?php

namespace Denno\Censor\Strategy;

class Iban implements StrategyInterface
{
    private $string;

    public function __construct($string)
    {
        $this->string = str_replace(' ', '', $string);
    }

    public function getAdjustedString(): string
    {
        return $this->string;
    }

    public function getPositions(): array
    {
        return [
            0,
            2,
            4,
            strlen($this->string)-4,
            strlen($this->string),
        ];
    }
}
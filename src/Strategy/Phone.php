<?php

namespace Denno\Censor\Strategy;

class Phone implements StrategyInterface
{
    private string $string;

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
            strlen($this->string)-3,
            strlen($this->string),
        ];
    }
}
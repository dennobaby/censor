<?php

namespace Denno\Censor\Strategy;

class Full implements StrategyInterface
{
    private string $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function getAdjustedString(): string
    {
        return $this->string;
    }

    public function getPositions(): array
    {
        return [strlen($this->string)];
    }
}
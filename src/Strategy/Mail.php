<?php

namespace Denno\Censor\Strategy;

class Mail implements StrategyInterface
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
        $atpos = strpos($this->string, '@');
        $dotpos = strrpos($this->string, '.');
        return [
            0,
            $atpos > 4 ? $atpos-3 : $atpos-1,
            $atpos,
            $dotpos-$atpos > 5 ? $dotpos-3 : $dotpos-1,
            $dotpos,
        ];
    }
}
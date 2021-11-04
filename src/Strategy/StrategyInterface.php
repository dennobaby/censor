<?php

namespace Denno\Censor\Strategy;

interface StrategyInterface
{
    public function __construct(string $string);
    public function getAdjustedString(): string;
    public function getPositions(): array;
}
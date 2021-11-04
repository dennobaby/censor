<?php

namespace Denno\Censor\Strategy;

class PersonName implements StrategyInterface
{
    private string $re = '/[^\S\r\n]|&|-|\+|$/m';

    private string $string;
    private array $positions = [];

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function getAdjustedString(): string
    {
        return $this->string;
    }

    /**
     * @return array
     */
    public function getPositions(): array
    {
        $this->findPositions();
        return $this->positions;
    }

    private function findPositions()
    {
        preg_match_all($this->re, $this->string, $matches, PREG_OFFSET_CAPTURE);
        $pre = 0;
        $this->positions[] = 0;
        foreach ($matches[0] as $match){
            $p = $match[1];
            if($p-$pre > 5){
                $p = $p-3;
            } elseif ($p-$pre > 2){
                $p = $p-1;
            }
            $pre = $match[1];
            $this->positions[] = $p;
            $this->positions[] = $match[1];
        }
    }
}
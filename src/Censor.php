<?php

namespace Denno\Censor;

use Denno\Censor\Exception\BoundaryException;
use Denno\Censor\Exception\UnknownStrategyException;
use Denno\Censor\Strategy\StrategyInterface;
use Exception;

class Censor
{

    /**
     * @param $string
     * @param $strategy
     * @return mixed
     * @throws UnknownStrategyException
     */
    final static function censorOnStrategy($string, $strategy): string
    {
        if(!class_exists($strategy)){
            throw new UnknownStrategyException($strategy);
        }
        /** @var StrategyInterface $strategy */
        $strategy = new $strategy($string);

        return self::censor($strategy->getAdjustedString(), ...$strategy->getPositions());
    }

    /**
     * @throws Exception
     */
    final static function censor($string, ...$positions)
    {
        if(max($positions) > strlen($string) || min($positions) < 0){
            throw new BoundaryException(
                "String-Length: " . strlen($string)
                . " Maximal position: " . max($positions)
                . " Minimal position: " . min($positions)
            );
        }
        if(min($positions) !== 0){
            $positions = array_merge((array) $positions, [0, 0]);
        }
        sort($positions);

        $c = true;
        foreach ($positions as $k => $position){
            foreach (str_split($string) as $p => $s){
                $string[$p] = $c && $p >= $positions[$k-($k > 0 ? 1 : 0)] && $p < $position ? '*' : $s;
            }
            $c = !$c;
        }

        return $string;
    }
}
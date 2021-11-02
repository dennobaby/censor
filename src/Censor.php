<?php

namespace Censor;


use Censor\Exception\BoundaryException;
use Exception;

class Censor
{
    CONST STRATEGY_FULL = 0;
    CONST STRATEGY_PHONE = 1;
    CONST STRATEGY_MAIL = 2;
    CONST STRATEGY_IBAN = 3;
    CONST STRATEGY_PHONE_SHORT = 4;

    /**
     * @param $string
     * @param int $strategy
     * @return string
     * @throws Exception
     */
    final static function censorOnStrategy($string, int $strategy = self::STRATEGY_FULL): string
    {
        $string = str_replace(' ', '', $string);
        switch ($strategy){
            case self::STRATEGY_PHONE:
                return self::censor($string, 0, strlen($string)-3, strlen($string));
            case self::STRATEGY_IBAN:
                return self::censor($string, 0, 2, 4, strlen($string)-4, strlen($string));
            case self::STRATEGY_MAIL:
                $atpos = strpos($string, '@');
                $dotpos = strrpos($string, '.');
                return self::censor($string,
                    0,
                    $atpos > 4 ? $atpos-3 : $atpos-1,
                    $atpos,
                    $dotpos-$atpos > 5 ? $dotpos-3 : $dotpos-1,
                    $dotpos
                );
            case self::STRATEGY_PHONE_SHORT:
                return self::censor($string, 0, strlen($string)/2, strlen($string));
            default:
                return self::censor($string, strlen($string));
        }
    }

    /**
     * @throws Exception
     */
    final static function censor($string, ...$positions)
    {
        if(max($positions) > strlen($string) || min($positions) < 0){
            throw new BoundaryException();
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
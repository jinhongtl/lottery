<?php

namespace lottery\algorithm;

use lottery\AlgorithmInterface;

class SimpleAlgorithm implements AlgorithmInterface
{
    public function lottery(array $prizes)
    {
        if (empty($prizes)) {
            return null;
        }
        $startPoint = $min = 0;
        $max = 0;
        foreach ($prizes as $prize) {
            $max += $prize->chance;
        }

        if ($max <= 0) {
            return null;
        }
        $multiple = 1000;
        $max = $max * $multiple;
        $luckyNum = mt_rand($min, $max);
        foreach ($prizes as $prize) {
            $step = $multiple * $prize->chance;
            if ($luckyNum > $startPoint && $luckyNum <= ($startPoint + $step)) {
                return $prize;
            }
            $startPoint += $step;
        }
        return null;

    }
}

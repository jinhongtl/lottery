<?php

namespace lottery\algorithm;

use lottery\AlgorithmInterface;

class PercentAlgorithm implements AlgorithmInterface
{
    public function lottery(array $prizes)
    {
        if (!$prizes) {
            return null;
        }
        $prizeTotalChance = 0;
        foreach ($prizes as $key => $prize) {
            $prizeTotalChance += $prize->chance;
        }
        if ($prizeTotalChance <= 0) {
            return null;
        }
        $realChance = 0;
        $prizeCount = count($prizes);
        $prizePool = [];
        foreach ($prizes as $key => $prize) {
            if ($key == ($prizeCount - 1)) {
                $currentChance = 100 - $realChance;
            } else {
                $currentChance = round(bcmul(bcdiv($prize->chance, $prizeTotalChance, 4), 100, 2));
                $realChance += $currentChance;
            }
            for ($i = 0; $i < $currentChance; $i++) {
                array_push($prizePool, $prize->id);
            }
        }
        shuffle($prizePool);
        $id = $prizePool[mt_rand(0, 99)];
        foreach ($prizes as $prize) {
            if ($prize->id == $id) {
                return $prize;
            }
        }
        return null;
    }
}

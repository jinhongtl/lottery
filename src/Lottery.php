<?php

namespace lottery;

use lottery\algorithm\PercentAlgorithm;
use lottery\exception\CheckException;
use lottery\exception\CheckLimitException;
use lottery\exception\DeductionLotteryNumException;
use lottery\exception\InvalidConfigException;
use lottery\exception\PrizeNotFoundException;
use lottery\exception\UnLuckyException;

class Lottery
{
    /**@var LotteryInterface $lotteryClass */
    public $lotteryClass = null;

    /**@var AlgorithmInterface $algorithm */
    public $algorithm = null;

    public function __construct($lotteryClass, $algorithm = null)
    {
        $this->lotteryClass = $lotteryClass;
        if ($this->lotteryClass === null) {
            throw new InvalidConfigException("lotteryClass must be set");
        }

        if (!$this->lotteryClass instanceof LotteryInterface) {
            throw new InvalidConfigException("lotteryClass must be implements interface LotteryInterface");
        }

        if ($algorithm === null) {
            $this->algorithm = new PercentAlgorithm();
        } else {
            $this->algorithm = $algorithm;
        }

        if (!$this->algorithm instanceof AlgorithmInterface) {
            throw new InvalidConfigException("algorithm must be implements interface AlgorithmInterface");
        }
    }

    /**
     * 抽奖
     * @param int $userId
     * @param integer $activityId
     * @return Prize
     */
    public function run($userId, $activityId = 0): Prize
    {
        $class = $this->lotteryClass;
        $class->init($userId, $activityId);
        if (!$class->check()) {
            throw new CheckException("You have not get allow to lottery");
        }

        if (!$class->deductionLotteryNum()) {
            throw new DeductionLotteryNumException("You have not get allow to lottery");
        }

        if (!$class->checkLimit()) {
            throw new CheckLimitException("You have not get allow to lottery");
        }

        if (!$class->preLottery()) {
            throw new UnLuckyException("Unlucky to get the prize,next time you will get it");
        }
        $prizes = $class->getPrizes();
        if (!$prizes) {
            throw new PrizeNotFoundException("Could not find any prize");
        }
        $prize = $this->algorithm->lottery($prizes);
        if (!$prize) {
            throw new UnLuckyException("Unlucky to get the prize,next time you will get it");
        }
        if (!$class->afterLottery($prize)) {
            throw new UnLuckyException("Unlucky to get the prize,next time you will get it");
        }
        return $prize;
    }
}

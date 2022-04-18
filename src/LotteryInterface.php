<?php

namespace lottery;

interface LotteryInterface
{
    public function init($userId, $activityId);

    /** 进入抽奖前的条件校验*/
    public function check(): bool;

    /** 是否允许中奖，包括总抽奖概率与用户中奖次数限制的校验 */
    public function checkLimit(): bool;

    /** 获取满足抽奖条件的奖品 */
    public function getPrizes(): array;

    /** 扣除抽奖机会 */
    public function deductionLotteryNum(): bool;

    /** 预抽奖逻辑 */
    public function preLottery(): bool;

    /** 写入奖品 */
    public function afterLottery(Prize $prize): bool;
}

<?php

namespace lottery;

interface LotteryInterface
{
    /** 进入抽奖前的条件校验*/
    public function check($userId, $activityId): bool;

    /** 是否允许中奖，包括总抽奖概率与用户中奖次数限制的校验 */
    public function checkLimit($userId, $activityId): bool;

    /** 获取满足抽奖条件的奖品 */
    public function getPrizes($userId, $activityId): array;

    /** 扣除抽奖机会 */
    public function deductionLotteryNum($userId, $activityId): bool;

    /** 预抽奖逻辑 */
    public function preLottery($userId, $activityId): bool;

    /** 写入奖品 */
    public function afterLottery($userId, $activityId, Prize $prize): bool;
}

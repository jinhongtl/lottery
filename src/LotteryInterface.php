<?php

namespace lottery;

interface LotteryInterface
{
    /** 进入抽奖前的条件校验*/
    public static function check($userId, $activityId): bool;

    /** 是否允许中奖，包括总抽奖概率与用户中奖次数限制的校验 */
    public static function checkLimit($userId, $activityId): bool;

    /** 获取满足抽奖条件的奖品 */
    public static function getPrizes($userId, $activityId): array;

    /** 扣除抽奖机会 */
    public static function deductionLotteryNum($userId, $activityId): bool;

    /** 预抽奖逻辑 */
    public static function preLottery($userId, $activityId): bool;

    /** 写入奖品 */
    public static function afterLottery($userId, $activityId, Prize $prize);
}

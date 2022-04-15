# Lottery Framework - 通用抽奖框架


这是一个通用抽奖框架，连接不同的组件以支持抽奖

## 安装

```
php composer.phar require  jinhongtl/lottery
```

## 使用

- 创建一个类实现lottery\LotteryInterface接口
- new一个抽奖类(lottery\Lottery),通过run()方法进行抽奖
- 配置抽奖算法(有默认抽奖算法，可省略)


### 自定义抽奖逻辑

通过实现`lottery\LotteryInterface`接口中的方法，来自定义自己的抽奖逻辑

```
<?php

namespace micro\controllers;

use lottery\LotteryInterface;
use lottery\Prize;
use Yii;

class RushLottery implements LotteryInterface
{
    /** 进入抽奖前的条件校验*/
    public static function check($userId, $activityId): bool
    {
        return true;
    }

    /** 是否允许中奖，包括总抽奖概率与用户中奖次数限制的校验 */
    public static function checkLimit($userId, $activityId): bool
    {
        return true;
    }

    /** 获取满足抽奖条件的奖品 */
    public static function getPrizes($userId, $activityId): array
    {
        $prizesDb = [
            [
                'id' => 1,
                'name' => '红包1元',
                'chance' => 0,
            ],
            [
                'id' => 2,
                'name' => '耳机1个',
                'chance' => 0,
            ],
        ];
        $prizes = [];
        foreach ($prizesDb as $prize) {
            $prizes[] = Yii::createObject([
                'class' => Prize::class,
                'id' => $prize['id'],
                'name' => $prize['name'],
                'chance' => $prize['chance'],
            ]);
        }
        return $prizes;
    }

    /** 扣除抽奖机会 */
    public static function deductionLotteryNum($userId, $activityId): bool
    {
        return true;
    }

    /** 预抽奖逻辑 */
    public static function preLottery($userId, $activityId): bool
    {
        return true;
    }

    /** 如写入奖品 */
    public static function afterLottery($userId, $activityId, Prize $prize)
    {

    }
}


```

### 使用

```
$userId = 1;
$activityId = 1;
try {
    $lottery = new Lottery(new RushLottery());
    $prize = $lottery->run($userId, $activityId);
    return $prize;
} catch (UnLuckyException $ex) {
    return ['code' => 1000, 'message' => '没抽中，下次再抽~'];

} catch (Exception $ex) {
    return ['code' => 1000, 'message' => '您与奖品擦肩而过~'];
}
```



### 自定义抽奖算法

```

```

```

```
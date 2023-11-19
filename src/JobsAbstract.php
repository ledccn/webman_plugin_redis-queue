<?php

namespace Ledc\RedisQueue;

use Ledc\RedisQueue\Library\JobsConsumer;

/**
 * Redis异步任务抽象类
 * - 多进程
 * @author 大卫 2023年3月21日
 */
abstract class JobsAbstract
{
    use HasJobs;

    /**
     * 构造函数
     * - 未处理构造函数的参数，暂时禁止子类重写构造函数
     */
    final public function __construct()
    {
    }

    /**
     * 同步投递任务，异步执行
     * @param array $data
     * @param int $delay
     * @return bool
     */
    final protected static function send(array $data, int $delay): bool
    {
        return JobsConsumer::send($data, $delay);
    }
}

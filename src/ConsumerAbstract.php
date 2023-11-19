<?php

namespace Ledc\RedisQueue;

use Ledc\Redis\Redis;
use RuntimeException;
use Throwable;

/**
 * redis队列消费者抽象类
 *
 * @link https://www.workerman.net/plugin/12
 */
abstract class ConsumerAbstract
{
    /**
     * 连接名，对应 config/redis-queue.php 里的连接
     * @return string
     */
    public static function connection(): string
    {
        return 'default';
    }

    /**
     * 要消费的队列名
     * @return string
     */
    abstract public static function queue(): string;

    /**
     * 消费方法
     *  - 消费过程中没有抛出异常和Error视为消费成功；否则消费失败,进入重试队列
     * @param $data
     * @return void
     */
    abstract public function consume($data): void;

    /**
     * 同步投递任务，异步执行
     * @param array $data
     * @param int $delay
     * @return bool
     */
    final public static function send(array $data, int $delay = 0): bool
    {
        try {
            $connection = static::connection();
            $queue = static::queue();
            return Redis::connection($connection)->send($queue, $data, $delay);
        } catch (Throwable $throwable) {
            throw new RuntimeException($throwable->getMessage());
        }
    }
}

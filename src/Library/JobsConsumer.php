<?php

namespace Ledc\RedisQueue\Library;

use Ledc\RedisQueue\ConsumerAbstract;
use support\Container;

/**
 * 异步任务队列
 */
class JobsConsumer extends ConsumerAbstract
{
    /**
     * 异步任务队列名称
     */
    public static function queue(): string
    {
        return 'JobsQueueAsync';
    }

    /**
     * @param $data
     * @return void
     */
    final public function consume($data): void
    {
        $job = $data['job'] ?? '';
        $data = $data['args'] ?? null;
        $constructor = $data['constructor'] ?? [];
        if (empty($job)) {
            return;
        }

        list($class, $method) = self::parseJob($job);
        $instance = $constructor ? Container::make($class, $constructor) : Container::get($class);
        if (method_exists($instance, $method)) {
            if ($data && is_array($data)) {
                $instance->{$method}(... array_values($data));
            } else {
                // null/int/bool/string/空数组
                $instance->{$method}($data);
            }
        }
    }

    /**
     * 将job解析为类和方法
     * @param string $job
     * @return array
     */
    final protected static function parseJob(string $job): array
    {
        $segments = explode('@', $job);
        return 2 === count($segments) ? $segments : [$segments[0], 'execute'];
    }
}

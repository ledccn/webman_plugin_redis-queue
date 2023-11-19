<?php

namespace Ledc\RedisQueue\Library;

/**
 * 单进程：异步任务队列
 */
class SingleProcessJobsConsumer extends JobsConsumer
{
    /**
     * 异步任务队列名称
     */
    public static function queue(): string
    {
        return 'SingleProcessJobsQueueAsync';
    }
}

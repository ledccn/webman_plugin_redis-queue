<?php

return [
    'consumer' => [
        'handler' => Ledc\RedisQueue\Library\Process::class,
        'count' => 8, // 可以设置多进程同时消费
        'constructor' => [
            // 消费者类目录
            'consumer_dir' => app_path() . '/queue/redis',
            'failed_callback' => function ($package, $connection_name) {
                var_dump($connection_name, $package);
            }
        ]
    ],
];

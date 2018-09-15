<?php

/**
 * 缓存配置
 */
return [
    /**
     * 主服务器优先配置在前面
     */
    'server' => [
        ['host' => '127.0.0.1', 'port' => '6379'],
        ['host' => '127.0.0.1', 'port' => '6379']
    ],
    /**
     * 连接超时时间
     */
    'connect_timeout' => 3,
    /**
     * 读取超时时间
     */
    'read_timeout' => 3,
    /**
     * 持久连接id
     */
    'persistent_id' => 'devmanager',
    /**
     * 是否记录info
     */
    'log_info' => true
];


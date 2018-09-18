<?php

/**
 * 数据库配置
 */
return [
    /**
     * 默认业务类型
     * 当通过表确定不了业务类型时
     */
    'default_business_type' => 'devmanager',
    /**
     * 是否记录info
     */
    'log_info' => false,
    /**
     * 业务信息
     */
    'business_info' => [
        /**
         * 业务类别
         */
        'devmanager' => [
            /**
             * 主库是否参与读
             */
            'master_read' => 1,
            /**
             * 连接超时时间
             */
            'connect_timeout' => 3,
            /**
             * 长连接
             */
            'persistent' => true,
            /**
             * 主库
             */
            'master' => [
                'business' => 'devmanager',
                'type' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'db' => 'devmanager',
                'username' => 'test',
                'password' => '4jqp5AzwjjNEC0rc7RyLELoLMG5HAHerBNR9XuvbqUaYCf5jO+eNSjRFmQMnQDH25rJ7VAeBb4ORsTq5AWU/sA=='
            ],
            /**
             * 从库
             */
            'slave' => [
                [
                    'business' => 'devmanager',
                    'type' => 'mysql',
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'db' => 'devmanager',
                    'username' => 'test',
                    'password' => '4jqp5AzwjjNEC0rc7RyLELoLMG5HAHerBNR9XuvbqUaYCf5jO+eNSjRFmQMnQDH25rJ7VAeBb4ORsTq5AWU/sA=='
                ]
            ],
            /**
             * 连接池信息
             */
            'connect_pool' => [
                'host' => '127.0.0.1',
                'port' => '9602',
                /**
                 * 连接池队列，公用连接
                 */
                'worker_num' => 4,
                /**
                 * 连接次可用连接
                 */
                'task_num' => 2,
                'log_file' => 'devmanager_connect_pool.log'
            ]
        ]
    ],
    /**
     * 表信息
     */
    'table_info' => [
    ]
];


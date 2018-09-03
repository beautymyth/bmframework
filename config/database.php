<?php

/**
 * 数据库配置
 */
return [
    /**
     * 默认业务类型
     */
    'default_business_type' => 'devmanager',
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
        'persistent' => false,
        /**
         * 主库
         */
        'master' => [
            'business' => 'devmanager',
            'type' => 'mysql',
            'host' => '10.100.2.235',
            'port' => '3306',
            'db' => 'devmanager',
            'username' => 'appuser',
            'password' => 'h86oFd19Ley8//NSWK/UvCzirw0cg6TolMo+RrYl0g08Pbf+4WYt1j3Mv2D8Y7ZkI/DfSg6XhI5+XkBgb4etcA=='
        ],
        /**
         * 从库
         */
        'slave' => [
            [
                'business' => 'devmanager',
                'type' => 'mysql',
                'host' => '10.100.2.235',
                'port' => '3306',
                'db' => 'devmanager',
                'username' => 'appuser',
                'password' => 'h86oFd19Ley8//NSWK/UvCzirw0cg6TolMo+RrYl0g08Pbf+4WYt1j3Mv2D8Y7ZkI/DfSg6XhI5+XkBgb4etcA=='
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
];


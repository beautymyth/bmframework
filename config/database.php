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
            'password' => '+foUvu6l60YHoUj79pj33oJLw3AUf7ix/UtvKF7DHMaO57Oq+TA+AtTrbjPf57rRUl0wurmAgwVSDPCKvpQ8Kw=='
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
                'password' => '+foUvu6l60YHoUj79pj33oJLw3AUf7ix/UtvKF7DHMaO57Oq+TA+AtTrbjPf57rRUl0wurmAgwVSDPCKvpQ8Kw=='
            ]
        ]
    ]
];


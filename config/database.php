<?php

/**
 * 数据库配置
 */
return [
    /**
     * 业务类别
     */
    'message' => [
        /**
         * 主库是否参与读
         */
        'master_read' => 1,
        /**
         * 主库
         */
        'master' => [
            'business' => 'message',
            'type' => 'mysql',
            'host' => 'host',
            'port' => '3306',
            'db' => 'dbname',
            'username' => 'username',
            'password' => 'password'
        ],
        /**
         * 从库
         */
        'slave' => [
            [
                'business' => 'message',
                'type' => 'mysql',
                'host' => 'host',
                'port' => '3306',
                'db' => 'dbname',
                'username' => 'username',
                'password' => 'password'
            ]
        ]
    ]
];


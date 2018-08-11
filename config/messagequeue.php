<?php

/**
 * 消息队列配置
 */
return [
    /**
     * 应用名
     * 用于标记不同系统的应用
     */
    'system_name' => 'message_center',
    /**
     * 服务器
     */
    'server' => [
        ['host' => 'host', 'port' => 5672, 'user' => 'admin', 'password' => 'admin'],
        ['host' => 'host', 'port' => 5672, 'user' => 'admin', 'password' => 'admin']
    ],
    /**
     * 生产者发送消息的重试次数
     * 由于服务器原因导致的
     */
    'producer_try_count' => 1,
    /**
     * 消息模块
     */
    'message' => [
        /**
         * 队列
         */
        'queue' => [
            'exchange_name' => 'message',
            'exchange_type' => 'topic',
            'ae_exchange' => 1,
            'queue_bind' => [
                [
                    'queue_name' => 'message_wechat',
                    'route_key' => ['message.wechat'],
                    /**
                     * 死信队列
                     * 0:不需要
                     * 1:需要，新建交换器与队列
                     * 2:需要，使用原交换器，消息回到原队列
                     */
                    'dead_letter' => 2
                ], [
                    'queue_name' => 'message_email',
                    'route_key' => ['message.email'],
                    'dead_letter' => 1
                ], [
                    'queue_name' => 'message_mobile',
                    'route_key' => ['message.mobile'],
                    'dead_letter' => 0
                ]
            ]
        ],
        /**
         * 消息生产者
         */
        'producer' => [
            /**
             * 消息发送的交换器
             */
            'exchange_send' => 'message'
        ],
        /**
         * 微信消息-消费者
         */
        'wechat_consumer' => [
            /**
             * 消费接收的队列
             */
            'queue_listen' => 'message_wechat',
            /**
             * 消息消费失败是否重进队列
             * false:不重进，进入死信队列或丢弃
             * true:重进，需要确保消息之后能消费掉，否则会一直占用资源
             */
            'is_requeue' => false
        ]
    ],
    /**
     * 发送微信消息的消费者
     */
    'send_wechat_msg_consumer' => [
        /**
         * swoole
         */
        'host' => '127.0.0.1',
        'port' => '9601',
        'worker_num' => 10,
        'log_file' => 'send_wechat_msg_consumer.log'
    ]
];


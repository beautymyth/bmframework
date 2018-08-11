<?php

/**
 * 类中的常量配置
 */
return [
    /**
     * 日志类
     */
    'Log' => [
        /**
         * 常规日志
         */
        'LOG_INFO' => 'INFO',
        /**
         * 错误日志
         */
        'LOG_ERR' => 'ERR',
        /**
         * sql普通日志
         */
        'LOG_SQLINFO' => 'SQLINFO',
        /**
         * sql错误
         */
        'LOG_SQLERR' => 'SQLERR',
        /**
         * redis错误
         */
        'LOG_REDISERR' => 'REDISERR',
        /**
         * 消息队列错误
         */
        'LOG_MQERR' => 'MESSAGEQUEUEERR',
        /**
         * curl调用错误
         */
        'LOG_CURLEERR' => 'CURLEERR',
        /**
         * 微信调用接口时token异常日志
         */
        'LOG_WECHATTOKENINFO' => 'WECHATTOKENINFO',
        /**
         * 微信模板消息日志
         */
        'LOG_WECHATMSGINFO' => 'WECHATMSGINFO',
        /**
         * 接口日志
         */
        'LOG_APIINFO' => 'APIINFO'
    ]
];


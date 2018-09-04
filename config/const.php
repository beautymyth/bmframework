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
    ],
    /**
     * 数据格式校验类
     */
    'ValidFormat' => [
        /**
         * int
         */
        'FORMAT_INT' => 'int',
        /**
         * decimal
         */
        'FORMAT_DECIMAL' => 'decimal',
        /**
         * datetime
         */
        'FORMAT_DATETIME' => 'datetime',
        /**
         * guid
         */
        'FORMAT_UNIQ' => 'uniq',
        /**
         * email
         */
        'FORMAT_EMAIL' => 'email',
        /**
         * 身份证
         */
        'FORMAT_IDCARD' => 'idcard',
        /**
         * 手机
         */
        'FORMAT_MOBILE' => 'mobile',
        /**
         * 用户名：需要以字母开头，长度为6-18位，只能包含字母数字下划线
         */
        'FORMAT_USERNAME' => 'username',
        /**
         * 密码：需要包含字母与数字，长度为6-18位，只能包含字母数字下划线
         */
        'FORMAT_PASSWORD' => 'password',
        /**
         * 文件名：长度为1-50位，只能包含中文字母数字下划线中划线空格中文括号英文括号
         */
        'FORMAT_FILENAME' => 'filename',
        /**
         * 文件名：长度为1-10位，只能包含中文字母数字
         */
        'FORMAT_VIEWNAME' => 'viewname'
    ]
];


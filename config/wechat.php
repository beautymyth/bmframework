<?php

/*
 * 微信配置
 */
return [
    /**
     * 微信接口
     */
    'api' => [
        'access_token' => 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={APPID}&secret={APPSECRET}',
        'jsapi_ticket' => 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={ACCESS_TOKEN}&type=jsapi',
        'template_msg' => 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={ACCESS_TOKEN}'
    ],
    /**
     * 模板消息
     */
    'template_msg' => [
        /**
         * 日志记录类型
         * 0:不记录
         * 1:记录成功与失败的
         * 2:记录失败的
         */
        'log_type' => 1,
        /**
         * 忽略的错误code
         * 当为这些code时，认为消息发送成功
         */
        'ignore_err_code' => [
            /**
             * 用户拒收消息
             */
            '48002',
            /**
             * 用户未关注公众号
             */
            '50005',
            /**
             * 需要接收者关注
             */
            '43004',
            /**
             * 模板消息id错误
             */
            '40037'
        ],
        /**
         * 模板信息
         */
        2 => [
            'WECHAT_ATTSIGNREMIND_MODELID' => [
                'template_id' => 'kb43fwMDkZwGGuk2tjgXOATEhlbiyV3Rkdzp1284EeA'
            ]
        ]
    ],
    /**
     * 公众号
     * key:这里使用客户id表示
     */
    'gzh' => [
        22 => [
            'appid' => 'appid',
            'appsecret' => 'appsecret',
            'access_token_redis_key' => '22_access_token_hroweixintest',
            'jsapi_ticket_redis_key' => '22_jsapi_ticket_hroweixintest'
        ],
        2 => [
            'appid' => 'appid',
            'appsecret' => 'appsecret',
            'access_token_redis_key' => '2_access_token_hroweixin',
            'jsapi_ticket_redis_key' => '2_jsapi_ticket_hroweixin'
        ]
    ]
];


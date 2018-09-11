<?php

/**
 * 网站基本的配置
 */
return [
    /**
     * 外观
     * 1.提供类中方法的静态调用
     */
    'facade' => [
        /**
         * 框架
         */
        'Config' => Framework\Facade\Config::class,
        'Log' => Framework\Facade\Log::class,
        'Cache' => Framework\Facade\Cache::class,
        'Request' => Framework\Facade\Request::class,
        'User' => Framework\Facade\User::class,
        'Des' => Framework\Facade\Des::class,
        'Http' => Framework\Facade\Http::class,
        'App' => Framework\Facade\App::class
    ],
    /**
     * 服务提供者
     * 1.单例的绑定
     * 2.接口到实现的绑定
     * 3.实例的绑定
     * 
     * 其它类的使用方式，可不通过服务提供者
     */
    'provider' => [
        /**
         * 框架
         */
        Framework\Provider\Cache\CacheServiceProvider::class,
        Framework\Provider\View\ViewServiceProvider::class,
        Framework\Provider\Security\DesServiceProvider::class,
        Framework\Provider\Network\HttpServiceProvider::class,
        Framework\Provider\Validation\ValidFormatServiceProvider::class,
	Framework\Provider\Database\DBServiceProvider::class,
        Framework\Provider\Database\HashCacheDBServiceProvider::class,
    /**
     * 应用
     */
    ],
    /**
     * 中间件
     * 1.http请求需要通过的检查
     * 2.按顺序检查
     * 3.按照uri中第一个/前进行匹配
     */
    'middleware' => [
        /**
         * 所有请求都需经过
         */
        'all' => [
            Framework\Service\Foundation\Middleware\All\CheckUri::class
        ],
        /**
         * api请求需要经过
         */
        'api' => [
            Framework\Service\Foundation\Middleware\Api\CheckSign::class
        ],
        /**
         * web请求需要经过
         * 1.非登记的二级域名，都算web
         */
        'web' => [
            Framework\Service\Foundation\Middleware\Web\CheckAuth::class
        ],
        /**
         * 控制台程序不经过中间件处理
         */
        'console' => [
        ]
    ],
    /**
     * 重定向配置
     */
    'redirect' => [
        'uri_empty' => 'http://blog.beautymyth.cn/home',
        'uri_wrong' => 'http://blog.beautymyth.cn/home',
        'auth_wrong' => 'http://blog.beautymyth.cn/login',
        'controller_wrong' => 'http://blog.beautymyth.cn/home'
    ],
    /**
     * 显式的二级目录
     * 1.不配置默认为web
     */
    'second_dir' => ['api', 'web'],
    /**
     * uri解析控制器规则
     * 1.配置的二级目录，认为uri包含控制器与控制器方法
     */
    'uri_resolve_rule' => ['api'],
    /**
     * web/api路由
     * 1.配置uri对应的控制器
     * 2.如果没配置，则使用默认uri结构处理
     */
    'route' => [
        'login' => 'Web\\Common\\LoginController',
        'login/login' => 'Web\\Common\\LoginController@login'
    ],
    /**
     * 视图
     * 1.配置uri对应的视图
     * 2.如果没配置，则使用默认uri结构处理
     */
    'view' => [
        'login' => 'web/common/login'
    ],
    /**
     * 控制台路由
     * 1.配置uri对应的控制器
     */
    'console_route' => [
        'send_wechat_msg_consumer' => 'Console\\SendWeChatMsgController@run',
        'mysql_connect_pool' => 'Console\\MysqlConnectPoolController@run'
    ]
];


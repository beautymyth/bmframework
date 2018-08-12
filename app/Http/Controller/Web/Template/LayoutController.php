<?php

namespace App\Http\Controller\Web\Template;

use Framework\Service\Foundation\Controller as BaseController;

class LayoutController extends BaseController {

    /**
     * 控制器方法对应的中间件
     * 方法名(小写):方法对应的中间件
     */
    protected $arrMiddleware = [
    ];

    /**
     * 依赖注入，使用外部类
     */
    public function __construct() {
        
    }

    /**
     * 获取视图模板里填充的数据
     * 模板,内容,js,css
     */
    public function getViewData() {
        return [
            /**
             * 文档内容
             */
            'content' => [
                'layout_user_name' => '登录',
                'layout_menu' => 'menu'
            ],
            /**
             * js
             * path:路径
             * is_pack:本地文件，是否需要压缩
             * is_remote:远程文件，直接加载
             */
            'js' => [
                    ['path' => 'plugin/jquery-1.12.2.min.js', 'is_pack' => 0, 'is_remote' => 0],
                    ['path' => 'https://cdn.jsdelivr.net/npm/vue', 'is_pack' => 0, 'is_remote' => 1]
            ],
            /**
             * css
             */
            'css' => [
                    ['path' => 'plugin/bootstrap.min.css', 'is_pack' => 0, 'is_remote' => 0]
            ]
        ];
    }

}

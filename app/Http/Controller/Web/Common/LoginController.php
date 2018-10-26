<?php

namespace App\Http\Controller\Web\Common;

use App\Http\Model\Web\Common\LoginModel;
use App\Http\Controller\Web\Template\LayoutController;
use Framework\Service\Foundation\Controller as BaseController;

class LoginController extends BaseController {

    /**
     * 登录实例
     */
    protected $objLoginModel;

    /**
     * 控制器方法对应的中间件
     * 方法名(小写):方法对应的中间件
     */
    protected $arrMiddleware = [
    ];

    /**
     * 依赖注入，使用外部类
     */
    public function __construct(LoginModel $objLoginModel) {
        $this->objLoginModel = $objLoginModel;
    }

    /**
     * 获取视图模板里填充的数据
     * 模板,内容,js,css
     */
    protected function getViewData() {
        return [
            /**
             * 文档内容
             */
            'content' => [
                'title' => '登录'
            ],
            /**
             * js
             * path:路径
             * is_pack:本地文件，是否需要压缩
             * is_remote:远程文件，直接加载
             * is_addhead:js文件加载位置，1:head 0:body，默认0
             */
            'js' => [
                ['path' => 'plugin/jquery-1.12.2.min.js', 'is_pack' => 0, 'is_remote' => 0, 'is_addhead' => 1],
                ['path' => 'plugin/vue.min.js', 'is_pack' => 0, 'is_remote' => 0, 'is_addhead' => 1],
                ['path' => 'common/login.js', 'is_pack' => 1, 'is_remote' => 0]
            ],
            /**
             * css
             */
            'css' => [
                ['path' => 'plugin/bootstrap.min.css', 'is_pack' => 0, 'is_remote' => 0],
                ['path' => 'common/login.css', 'is_pack' => 1, 'is_remote' => 0]
            ]
        ];
    }

    /**
     * 登陆操作
     */
    public function login() {
        var_dump('login');
        $this->objLoginModel->checkLogin();
    }

}

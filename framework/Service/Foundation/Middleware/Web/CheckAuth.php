<?php

namespace Framework\Service\Foundation\Middleware\Web;

use Closure;
use Exception;
use Framework\Service\Auth\User;
use Framework\Contract\Http\Request;
use Framework\Service\Foundation\Application;
use Framework\Service\Exception\AuthException;

/**
 * 用户检查
 */
class CheckAuth {

    /**
     * 应用实例
     */
    protected $objApp;

    /**
     * 不需要检查的uri规则
     * 1.login页面
     */
    protected $arrNotCheckPattern = [
        '/^(.*)(\/)?login(\/[a-z]+)*$/i'
    ];

    /**
     * 创建用户检查实例
     */
    public function __construct(Application $objApp) {
        $this->objApp = $objApp;
    }

    /**
     * 中间件处理
     */
    public function handle(Request $objRequest, Closure $mixNext) {
        if ($this->needCheck($objRequest)) {
            if (!$this->checkAuth($objRequest)) {
                throw new AuthException('账号错误');
            }
        }
        //运行下一个中间件
        return $mixNext($objRequest);
    }

    /**
     * uri是否需要进行检查
     */
    protected function needCheck($objRequest) {
        $strUri = $objRequest->getUri();
        foreach ($this->arrNotCheckPattern as $strPattern) {
            if (preg_match($strPattern, $strUri)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 用户检查
     */
    protected function checkAuth($objRequest) {
        $strCookie = $objRequest->getCookie('UserInfo');
        //cookie为空
        if (empty($strCookie)) {
            return false;
        }
        //解析错误
        $arrCookie = json_decode($strCookie, true);
        if (!is_array($arrCookie)) {
            return false;
        }
        //生成用户信息
        $objUser = new User($arrCookie);
        //检查用户信息
        if (!$objUser->check()) {
            return false;
        }
        //记录用户信息到容器
        $this->objApp->instance(User::class, $objUser);
        return true;
    }

}

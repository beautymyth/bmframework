<?php

namespace App\Http\Middleware\Api;

use Closure;
use Framework\Facade\Log;
use Framework\Facade\Config;
use Framework\Contract\Http\Request;
use Framework\Service\Foundation\Application;

/**
 * 记录接口调用信息
 */
class ApiLog {

    /**
     * 应用实例
     */
    protected $objApp;

    /**
     * 创建实例
     */
    public function __construct(Application $objApp) {
        $this->objApp = $objApp;
    }

    /**
     * 中间件处理
     */
    public function handle(Request $objRequest, Closure $mixNext) {
        $dateStartTime = getMicroTime();
        //运行下一个中间件
        $arrRes = $mixNext($objRequest);
        $dateEndTime = getMicroTime();
        $this->logInfo($arrRes, $dateStartTime, $dateEndTime);
        return $arrRes;
    }

    /**
     * 记录接口信息
     */
    protected function logInfo($arrRes, $dateStartTime, $dateEndTime) {
        $strLog = sprintf("\n res:%s \n starttime:%s \n endtime:%s \n", json_encode($arrRes), $dateStartTime, $dateEndTime);
        Log::log($strLog, Config::get('const.Log.LOG_APIINFO'));
    }

}

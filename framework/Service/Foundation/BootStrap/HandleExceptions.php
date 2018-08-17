<?php

namespace Framework\Service\Foundation\BootStrap;

use Exception;
use Framework\Facade\Config;
use Framework\Service\Foundation\Application;
use Framework\Contract\Exception\ExceptionHandler as ExceptionHandlerContract;

class HandleExceptions {

    /**
     * 应用实例
     */
    protected $objApp;

    public function bootStrap(Application $objApp) {
        $this->objApp = $objApp;

        error_reporting(E_ALL);

        set_exception_handler([$this, 'handleException']);

        set_error_handler([$this, 'handleError']);
    }

    /**
     * 自定义异常处理
     */
    public function handleException($objException) {
        //非Exception异常，进行处理
        if (!$objException instanceof Exception) {
            if (method_exists($objException, 'getMessage')) {
                throw new Exception($objException->getMessage());
            } else {
                throw new Exception('未知错误');
            }
        }

        $this->getHandleException()->report($objException);

        if (!$this->objApp->runningInConsole()) {
            //非控制台运行，生成http响应并发送
            $this->getHandleException()->render($objException)->send();
        }
    }

    /**
     * 自定义错误处理
     */
    public function handleError($strErrNo, $strErrStr, $strErrFile, $intErrLine) {
        if (!(error_reporting() & $strErrNo)) {
            //如果出现的错误不在定义接受的错误范围内，则转交给php自身处理
            return false;
        }

        //日志记录
        $strLog = sprintf("\n errno:%s \n errstr:%s \n errfile:%s \n errline:%s \n", $strErrNo, $strErrStr, $strErrFile, $intErrLine);
        $this->objApp->make('log')->log($strLog, Config::get('const.Log.LOG_ERR'));
    }

    /**
     * 获取异常处理实例
     */
    protected function getHandleException() {
        return $this->objApp->make(ExceptionHandlerContract::class);
    }

}

<?php

namespace Framework\Service\Foundation\BootStrap;

use Exception;
use Framework\Service\Foundation\Application;
use Framework\Contract\Exception\ExceptionHandler as ExceptionHandlerContract;

class HandleExceptions {

    /**
     * 应用实例
     */
    protected $objApp;

    public function bootStrap(Application $objApp) {
        $this->objApp = $objApp;

        set_exception_handler([$this, 'handleException']);
    }

    /**
     * 处理未捕捉的异常
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
     * 获取异常处理实例
     */
    protected function getHandleException() {
        return $this->objApp->make(ExceptionHandlerContract::class);
    }

}

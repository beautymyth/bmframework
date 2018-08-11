<?php

namespace Framework\Service\Foundation;

use Framework\Facade\Config;
use Framework\Contract\Http\Request;
use Framework\Service\Foundation\Pipeline;
use Framework\Service\Foundation\Application;
use Framework\Service\Http\ResponseFactory;
use Framework\Service\Exception\ControllerException;

/**
 * 路由
 */
class Router {

    /**
     * 应用实例
     */
    protected $objApp;

    /**
     * 控制器命名空间
     */
    protected $strNameSpace = 'App\\Http\\Controller\\';

    /**
     * 默认执行的控制器方法
     */
    protected $strDefaultMethod = 'view';

    /**
     * 不需要重定向的uri
     * 1.api
     */
    protected $strNotRedirectPattren = '/^(api)\/.+$/i';

    /**
     * 创建路由实例
     */
    public function __construct(Application $objApp) {
        $this->objApp = $objApp;
    }

    /**
     * 运行路由
     */
    public function runRoute(Request $objRequest) {
        $arrMiddleware = $this->getMiddleware($objRequest);

        return (new Pipeline($this->objApp))
                        ->send($objRequest)
                        ->through($arrMiddleware)
                        ->then(function($objRequest) {
                            return $this->runController($objRequest);
                        });
    }

    /**
     * 获取中间件
     */
    protected function getMiddleware($objRequest) {
        $arrMiddleware = $this->objApp->make('config')->get('app.middleware.' . $objRequest->getSecondDir());
        //未配置则使用web的中间件
        if ($arrMiddleware === '') {
            $arrMiddleware = $this->objApp->make('config')->get('app.middleware.web');
        }
        return $arrMiddleware;
    }

    /**
     * 运行控制器
     */
    protected function runController($objRequest) {
        //获取控制器
        $strController = $this->findController($objRequest);
        $arrController = $this->resolveController($strController);

        //调用控制器方法
        //暂时不解析方法中的参数，如果需要注入服务，在类的构造方法中注入
        $objControllerInstance = $this->objApp->make($arrController[0]);
        $mixResponse = $objControllerInstance->callAction($arrController[1], $this->objApp, $objRequest);

        //生成响应
        return $this->toResponse($mixResponse);
    }

    /**
     * 生成响应
     */
    protected function toResponse($mixResponse) {
        return $this->objApp->make(ResponseFactory::class)->make($mixResponse);
    }

    /**
     * 查找控制器
     */
    protected function findController($objRequest) {
        //配置查找
        $strController = $this->findControllerConfig($objRequest);
        if (!empty($strController)) {
            return $strController;
        }

        //文件查找
        $strController = $this->findControllerFile($objRequest);
        if (!empty($strController)) {
            return $strController;
        }

        //抛出异常
        if ($objRequest->isAjax()) {
            //ajax，错误信息
            throw new ControllerException(json_encode(['err_msg' => '请求地址错误']));
        }
        if (preg_match($this->strNotRedirectPattren, $objRequest->getUri())) {
            //非ajax，不需要重定向
            throw new ControllerException(json_encode(['err_msg' => '请求地址错误']));
        }
        //非ajax，需要重定向
        throw new ControllerException();
    }

    /**
     * 解析控制器
     */
    protected function resolveController($strController) {
        $arrController = explode('@', $strController);
        //控制器为页面，添加控制器默认方法
        return count($arrController) >= 2 ? $arrController : [$strController, $this->strDefaultMethod];
    }

    /**
     * 从配置中获取控制器
     */
    protected function findControllerConfig($objRequest) {
        $strUri = $objRequest->getUri();
        if ($this->objApp->runningInConsole()) {
            $strController = Config::get('app.console_route.' . $strUri);
        } else {
            $strController = Config::get('app.route.' . $strUri);
        }
        if (!empty($strController)) {
            return $this->strNameSpace . $strController;
        }
        return '';
    }

    /**
     * 从文件中获取控制器
     */
    protected function findControllerFile($objRequest) {
        //控制器目录
        $strControllerDir = $this->objApp->make('path.app') . '/Http/Controller/';

        //uri的二级目录不是显式配置的，则添加web作为二级目录
        $strUri = $objRequest->getUri();
        if (!in_array($objRequest->getSecondDir(), $this->objApp->make('config')->get('app.second_dir'))) {
            $strUri = 'web/' . $strUri;
        }
        $arrUri = explode('/', $strUri);

        //路径首字母转为大写
        array_walk($arrUri, function(&$strValue) {
            $strValue = ucfirst($strValue);
        });

        //uri指向控制器方法，至少包含控制器与控制器方法
        if (count($arrUri) >= 2) {
            //控制器目录
            $strDirPath = $strControllerDir . implode('/', array_slice($arrUri, 0, count($arrUri) - 2));
            if (is_dir($strDirPath)) {
                $strControllerName = $arrUri[count($arrUri) - 2] . 'Controller.php';
                foreach (scandir($strDirPath) as $strFileName) {
                    if (strtolower($strControllerName) == strtolower($strFileName)) {
                        return $this->strNameSpace . implode('\\', array_slice($arrUri, 0, count($arrUri) - 2)) . '\\' . str_replace('.php', '', $strFileName) . '@' . $arrUri[count($arrUri) - 1];
                    }
                }
            }
        }

        //uri可为控制器的二级目录
        if (!in_array($objRequest->getSecondDir(), $this->objApp->make('config')->get('app.uri_resolve_rule'))) {
            //uri指向控制器，至少包含控制器
            if (count($arrUri) >= 1) {
                //控制器目录
                $strDirPath = $strControllerDir . implode('/', array_slice($arrUri, 0, count($arrUri) - 1));
                if (is_dir($strDirPath)) {
                    $strControllerName = $arrUri[count($arrUri) - 1] . 'Controller.php';
                    foreach (scandir($strDirPath) as $strFileName) {
                        if (strtolower($strControllerName) == strtolower($strFileName)) {
                            return $this->strNameSpace . implode('\\', array_slice($arrUri, 0, count($arrUri) - 1)) . '\\' . str_replace('.php', '', $strFileName);
                        }
                    }
                }
            }
        }

        //匹配不到
        return '';
    }

}

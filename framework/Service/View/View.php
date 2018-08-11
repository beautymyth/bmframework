<?php

namespace Framework\Service\View;

use Framework\Facade\Config;
use Framework\Facade\Request;
use Framework\Service\Foundation\Application;
use Framework\Service\Exception\ControllerException;

/**
 * 视图
 */
class View {

    /**
     * 应用实例
     */
    protected $objApp;

    /**
     * 创建视图实例
     */
    public function __construct(Application $objApp) {
        $this->objApp = $objApp;
    }

    /**
     * 生成视图
     */
    public function make($arrData) {
        $strViewPath = $this->getViewPath();
        $strtmp = file_get_contents($strViewPath);
        //todo:解析
        return $strtmp;
    }

    /**
     * 获取视图
     */
    protected function getViewPath() {
        //配置查找
        $strView = $this->getViewPathConfig();
        if (!empty($strView)) {
            return $strView;
        }

        //文件查找
        $strView = $this->getViewPathFile();
        if (!empty($strView)) {
            return $strView;
        }

        //抛出异常，需要重定向
        throw new ControllerException();
    }

    /**
     * 从配置中获取
     */
    protected function getViewPathConfig() {
        $strViewPath = Config::get('app.view.' . Request::getUri());
        if (!empty($strViewPath)) {
            $strFilePath = $this->objApp->make('path.resource') . '/view/' . $strViewPath . '.php';
            if (is_file($strFilePath)) {
                return $strFilePath;
            }
        }
        return '';
    }

    /**
     * 从文件中获取
     */
    protected function getViewPathFile() {
        $strUri = Request::getUri();
        if (!in_array(Request::getSecondDir(), Config::get('app.second_dir'))) {
            $strUri = 'web/' . $strUri;
        }
        $strFilePath = $this->objApp->make('path.resource') . '/view/' . $strUri . '.view.php';
        if (is_file($strFilePath)) {
            return $strFilePath;
        }
        return '';
    }

}

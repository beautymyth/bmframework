<?php

namespace Framework\Service\Http;

use Framework\Contract\Http\Request as RequestContract;

/**
 * http请求
 */
class HttpRequest implements RequestContract {

    /**
     * get，post
     */
    protected $arrParam = [];

    /**
     * cookie
     */
    protected $arrCookie = [];

    /**
     * file
     */
    protected $arrFile = [];

    /**
     * 创建请求实例
     */
    public function __construct() {
        $this->init();
    }

    /**
     * 初始化数据
     */
    protected function init() {
        $this->arrParam = array_merge((array) filter_input_array(INPUT_GET), (array) json_decode(file_get_contents('php://input'), true));
        $this->arrCookie = filter_input_array(INPUT_COOKIE);
        $this->arrFile = $_FILES;
    }

    /**
     * 获取单个参数
     * @param string $strParamName 参数名
     * @param string $strDefault 当获取不到参数时，返回的默认值
     */
    public function getParam($strParamName, $strDefault = '') {
        return isset($this->arrParam[$strParamName]) ? $this->arrParam[$strParamName] : $strDefault;
    }

    /**
     * 获取所有参数
     */
    public function getAllParam() {
        return $this->arrParam;
    }

    /**
     * 获取cookie
     * @param string $strCookieName cookie名
     */
    public function getCookie($strCookieName) {
        return isset($this->arrCookie[$strCookieName]) ? $this->arrCookie[$strCookieName] : '';
    }

    /**
     * 获取uri
     */
    public function getUri() {
        $strUri = $_SERVER['REQUEST_URI'];
        $strUri = trim($strUri, '/');
        $strUri = explode('?', $strUri)[0];
        return strtolower($strUri);
    }

    /**
     * 判断是否ajax请求
     */
    public function isAjax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
            return true;
        }
        return false;
    }

    /**
     * 获取请求的二级目录
     */
    public function getSecondDir() {
        return strtolower(explode('/', $this->getUri())[0]);
    }

    /**
     * 获取客户端ip
     */
    public function getClientIP() {
        $strIP = '';
        $arrApacheRequest = array();
        if (function_exists('apache_request_headers')) {
            $arrApacheRequest = apache_request_headers();
        }
        if (isset($arrApacheRequest['ns_clientip'])) {
            //netscaler上面将客户端IP存储到了ns_clientip中
            $strIP = $arrApacheRequest['ns_clientip'];
        } else {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arrIP = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($arrIP as $strIP) {
                    $strIP = trim($strIP);
                    if ('unknown' != $strIP) {
                        break;
                    }
                }
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $strIP = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $strIP = $_SERVER['REMOTE_ADDR'];
            } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
                $strIP = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $strIP = getenv('HTTP_CLIENT_IP');
            } elseif (getenv('REMOTE_ADDR')) {
                $strIP = getenv('REMOTE_ADDR');
            }
        }
        $arrIP = explode(',', $strIP);
        $strIP = trim(empty($arrIP[0]) ? $strIP : $arrIP[0]);
        return $strIP;
    }

    /**
     * 获取服务端ip
     */
    public function getServerIP() {
        $strIP = '';
        if (isset($_SERVER)) {
            if (isset($_SERVER['SERVER_ADDR'])) {
                $strIP = $_SERVER['SERVER_ADDR'];
            } else if (isset($_SERVER['LOCAL_ADDR'])) {
                $strIP = $_SERVER['LOCAL_ADDR'];
            }
        } else {
            $strIP = getenv('SERVER_ADDR');
        }
        return $strIP;
    }

}

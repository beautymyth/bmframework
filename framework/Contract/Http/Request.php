<?php

namespace Framework\Contract\Http;

/**
 * 响应接口
 */
interface Request {

    /**
     * 获取单个参数
     * @param string $strParamName 参数名
     * @param string $strDefault 当获取不到参数时，返回的默认值
     */
    public function getParam($strParamName, $strDefault = '');

    /**
     * 获取所有参数
     */
    public function getAllParam();

    /**
     * 获取cookie
     * @param string $strCookieName cookie名
     */
    public function getCookie($strCookieName);

    /**
     * 获取uri
     */
    public function getUri();

    /**
     * 判断是否ajax请求
     */
    public function isAjax();

    /**
     * 获取请求的二级目录
     */
    public function getSecondDir();

    /**
     * 获取客户端ip
     */
    public function getClientIP();

    /**
     * 获取服务端ip
     */
    public function getServerIP();

    /**
     * 获取请求标识id(guid)
     */
    public function setRequestID($strRequestID);

    /**
     * 获取请求标识id
     */
    public function getRequestID();
}

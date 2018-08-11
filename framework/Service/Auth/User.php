<?php

namespace Framework\Service\Auth;

/**
 * 用户
 */
class User {

    /**
     * 用户信息
     */
    protected $arrUserInfo = [];

    /**
     * 创建用户实例
     */
    public function __construct($arrUserInfo = []) {
        $this->arrUserInfo = $arrUserInfo;
    }

    /**
     * 检查用户信息完整性
     */
    public function check() {
        if (isset($this->arrUserInfo['user_id']) && !empty($this->arrUserInfo['user_id']) && isset($this->arrUserInfo['user_name']) && !empty($this->arrUserInfo['user_name'])) {
            return true;
        }
        return false;
    }

    /**
     * 获取用户Id
     */
    public function getUserId() {
        return isset($this->arrUserInfo['user_id']) ? $this->arrUserInfo['user_id'] : '';
    }

    /**
     * 获取用户名称
     */
    public function getUserName() {
        return isset($this->arrUserInfo['user_name']) ? $this->arrUserInfo['user_name'] : '';
    }

}

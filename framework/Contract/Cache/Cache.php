<?php

namespace Framework\Contract\Cache;

/**
 * 缓存接口
 */
interface Cache {

    /**
     * 获取值
     * @param string $strKey key
     * @return string or bool
     */
    public function get($strKey);

    /**
     * 设置值
     * @param string $strKey key 
     * @param string $strValue value
     * @param int $intTimeout 过期时间，默认不过期
     * @return bool
     */
    public function set($strKey, $strValue, $intTimeout = 0);
}

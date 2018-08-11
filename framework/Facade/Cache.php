<?php

namespace Framework\Facade;

use Framework\Contract\Cache\Cache as CacheContract;

/**
 * @method static string|bool get($strKey)
 * @method static bool set($strKey, $strValue, $intTimeout = 0)
 * @method static int del($mixKey)
 * 
 * @see \Framework\Service\Cache\CacheRedis
 */
class Cache extends Facade {

    /**
     * 获取外观名称
     */
    protected static function getFacadeAccessor() {
        return CacheContract::class;
    }

}

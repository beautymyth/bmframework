<?php

namespace Framework\Service\Cache;

use Exception;
use Framework\Facade\Log;
use Framework\Facade\Config;
use Framework\Contract\Cache\Cache as CacheContract;

/**
 * 缓存的redis实现
 */
class CacheRedis implements CacheContract {

    /**
     * 复用redis连接类
     */
    use RedisConnect;

    /**
     * 获取值
     * @param string $strKey key
     * @return string or bool
     */
    public function get($strKey) {
        try {
            $dateStartTime = getMicroTime();
            $objReadHander = $this->getReadHander();
            return is_null($objReadHander) ? false : $objReadHander->get($strKey);
        } catch (Exception $e) {
            $dateEndTime = getMicroTime();
            $strLog = sprintf("\n commond:%s \n key:%s \n memo:%s \n startdate:%s \n enddate:%s \n connectinfo:%s \n", 'get', $strKey, $e->getMessage(), $dateStartTime, $dateEndTime, json_encode($this->arrCurConnectInfo));
            Log::log($strLog, Config::get('const.Log.LOG_REDISERR'));
            return false;
        }
    }

    /**
     * 设置值
     * @param string $strKey key 
     * @param string $strValue value
     * @param int $intTimeout 过期时间
     * @return bool
     */
    public function set($strKey, $strValue, $intTimeout = 0) {
        try {
            $dateStartTime = getMicroTime();
            $objWriteHander = $this->getWriteHander();
            if ($intTimeout > 0) {
                return is_null($objWriteHander) ? false : $objWriteHander->set($strKey, $strValue, $intTimeout);
            } else {
                return is_null($objWriteHander) ? false : $objWriteHander->set($strKey, $strValue);
            }
        } catch (Exception $e) {
            $dateEndTime = getMicroTime();
            $strLog = sprintf("\n commond:%s \n key:%s \n value:%s \n memo:%s \n startdate:%s \n enddate:%s \n connectinfo:%s \n", 'set', $strKey, $strValue, $e->getMessage(), $dateStartTime, $dateEndTime, json_encode($this->arrCurConnectInfo));
            Log::log($strLog, Config::get('const.Log.LOG_REDISERR'));
            return false;
        }
    }

    /**
     * 删除值
     * @param string|array $mixKey key
     * @return int
     */
    public function del($mixKey) {
        try {
            $dateStartTime = getMicroTime();
            $objWriteHander = $this->getWriteHander();
            return is_null($objWriteHander) ? 0 : $objWriteHander->unlink($mixKey);
        } catch (Exception $e) {
            $dateEndTime = getMicroTime();
            $strLog = sprintf("\n commond:%s \n key:%s \n memo:%s \n startdate:%s \n enddate:%s \n connectinfo:%s \n", 'del', is_array($mixKey) ? json_encode($mixKey) : $mixKey, $e->getMessage(), $dateStartTime, $dateEndTime, json_encode($this->arrCurConnectInfo));
            Log::log($strLog, Config::get('const.Log.LOG_REDISERR'));
            return 0;
        }
    }

}

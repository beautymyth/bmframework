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
    public function get($strKey, $blnTry = false) {
        try {
            $dateStartTime = getMicroTime();
            $objReadHander = $this->getReadHander($blnTry);
            return is_null($objReadHander) ? false : $objReadHander->get($strKey);
        } catch (Exception $e) {
            //异常重试一次
            $strMsg = $e->getMessage();
            if ($blnTry == false) {
                return $this->get($strKey, true);
            }
            //日志记录
            $dateEndTime = getMicroTime();
            $strLog = sprintf("\n commond:%s \n key:%s \n memo:%s \n startdate:%s \n enddate:%s \n connectinfo:%s \n", 'get', $strKey, $strMsg, $dateStartTime, $dateEndTime, json_encode($this->arrCurConnectInfo));
            Log::log($strLog, Config::get('const.Log.LOG_REDISERR'));
            return false;
        }
    }

    /**
     * 批量获取值
     * @param array $arrKey keys
     * @return string or bool
     */
    public function mGet($arrKey, $blnTry = false) {
        try {
            $dateStartTime = getMicroTime();
            $objReadHander = $this->getReadHander($blnTry);
            return is_null($objReadHander) ? [] : $objReadHander->mGet($arrKey);
        } catch (Exception $e) {
            //异常重试一次
            $strMsg = $e->getMessage();
            if ($blnTry == false) {
                return $this->mGet($arrKey, true);
            }
            //日志记录
            $dateEndTime = getMicroTime();
            $strLog = sprintf("\n commond:%s \n key:%s \n memo:%s \n startdate:%s \n enddate:%s \n connectinfo:%s \n", 'mGet', json_encode($arrKey), $strMsg, $dateStartTime, $dateEndTime, json_encode($this->arrCurConnectInfo));
            Log::log($strLog, Config::get('const.Log.LOG_REDISERR'));
            return [];
        }
    }

    /**
     * 设置值
     * @param string $strKey key 
     * @param string $strValue value
     * @param int $intTimeout 过期时间
     * @return bool
     */
    public function set($strKey, $strValue, $intTimeout = 0, $blnTry = false) {
        try {
            $dateStartTime = getMicroTime();
            $objWriteHander = $this->getWriteHander($blnTry);
            if ($intTimeout > 0) {
                return is_null($objWriteHander) ? false : $objWriteHander->set($strKey, $strValue, $intTimeout);
            } else {
                return is_null($objWriteHander) ? false : $objWriteHander->set($strKey, $strValue);
            }
        } catch (Exception $e) {
            //异常重试一次
            $strMsg = $e->getMessage();
            if ($blnTry == false) {
                return $this->set($strKey, $strValue, $intTimeout, true);
            }
            //日志记录
            $dateEndTime = getMicroTime();
            $strLog = sprintf("\n commond:%s \n key:%s \n value:%s \n memo:%s \n startdate:%s \n enddate:%s \n connectinfo:%s \n", 'set', $strKey, $strValue, $strMsg, $dateStartTime, $dateEndTime, json_encode($this->arrCurConnectInfo));
            Log::log($strLog, Config::get('const.Log.LOG_REDISERR'));
            return false;
        }
    }

    /**
     * 删除值
     * @param string|array $mixKey key
     * @return int
     */
    public function del($mixKey, $blnTry = false) {
        try {
            $dateStartTime = getMicroTime();
            $objWriteHander = $this->getWriteHander($blnTry);
            return is_null($objWriteHander) ? 0 : $objWriteHander->unlink($mixKey);
        } catch (Exception $e) {
            //异常重试一次
            $strMsg = $e->getMessage();
            if ($blnTry == false) {
                return $this->del($mixKey, true);
            }
            //日志记录
            $dateEndTime = getMicroTime();
            $strLog = sprintf("\n commond:%s \n key:%s \n memo:%s \n startdate:%s \n enddate:%s \n connectinfo:%s \n", 'del', is_array($mixKey) ? json_encode($mixKey) : $mixKey, $strMsg, $dateStartTime, $dateEndTime, json_encode($this->arrCurConnectInfo));
            Log::log($strLog, Config::get('const.Log.LOG_REDISERR'));
            return 0;
        }
    }

}

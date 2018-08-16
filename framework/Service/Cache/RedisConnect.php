<?php

namespace Framework\Service\Cache;

use Redis;
use Exception;
use Framework\Facade\Log;
use Framework\Facade\Config;

/**
 * redis连接
 */
trait RedisConnect {

    /**
     * redis服务器
     */
    private $arrRedisServer = [];

    /**
     * redis写句柄，master服务器可写，可读
     */
    private $objWriteHander = null;

    /**
     * redis写句柄，服务器信息
     */
    private $arrWriteHanderInfo = [];

    /**
     * redis读句柄，slave服务器只读
     */
    private $objReadHander = null;

    /**
     * 是否管道处理
     */
    protected $blnMulti = false;

    /**
     * 当前连接信息
     */
    protected $arrCurConnectInfo = ['write' => [], 'read' => []];

    /**
     * 获取服务器信息
     */
    protected function getRedisServer() {
        if (empty($this->arrRedisServer)) {
            $this->arrRedisServer = Config::get('redis.server');
        }
        return $this->arrRedisServer;
    }

    /**
     * 获取写句柄
     */
    protected function getWriteHander($blnTry = false) {
        try {
            if ($blnTry || is_null($this->objWriteHander) || (!$this->blnMulti && $this->objWriteHander->ping() != '+PONG')) {
                $this->setRedisHanderWrite();
            }
        } catch (Exception $e) {
            $this->setRedisHanderWrite();
        } finally {
            return $this->objWriteHander;
        }
    }

    /**
     * 获取读句柄
     */
    protected function getReadHander($blnTry = false) {
        try {
            if ($blnTry || is_null($this->objReadHander) || (!$this->blnMulti && $this->objReadHander->ping() != '+PONG')) {
                $this->setRedisHanderRead();
                var_dump($this->arrCurConnectInfo);
            }
        } catch (Exception $e) {
            $this->setRedisHanderRead();
        } finally {
            return $this->objReadHander;
        }
    }

    /**
     * 设置redis写句柄
     */
    protected function setRedisHanderWrite() {
        //1.遍历redis服务器
        foreach ($this->getRedisServer() as $arrServer) {
            $objTmpHander = new Redis();
            $blnFlag = $objTmpHander->pconnect($arrServer['host'], $arrServer['port'], Config::get('redis.connect_timeout'), Config::get('redis.persistent_id'));
            if ($blnFlag) {
                $objTmpHanderinfo = $objTmpHander->info('replication');
                if (strtolower($objTmpHanderinfo['role']) == 'master') {
                    $objTmpHander->setOption(Redis::OPT_READ_TIMEOUT, Config::get('redis.read_timeout'));
                    $this->arrCurConnectInfo['write'] = $arrServer;

                    $this->objWriteHander = $objTmpHander;
                    $this->arrWriteHanderInfo = $objTmpHanderinfo;
                    $this->arrWriteHanderInfo['session_path'] = sprintf('tcp://%s:%s', $arrServer['host'], $arrServer['port']);
                    break;
                }
            } else {
                Log::log('redis-write连接失败：' . implode(',', $arrServer), Config::get('const.Log.LOG_REDISERR'));
            }
        }
        //2.检查是否能连接到写服务器
        if (is_null($this->objWriteHander)) {
            Log::log('redis-write句柄初始化失败', Config::get('const.Log.LOG_REDISERR'));
        }
    }

    /**
     * 设置redis读句柄
     * <br>随机获取一个有效的服务器连接
     */
    protected function setRedisHanderRead() {
        //1.随机获取redis服务器
        $intTryCount = 1;
        $intTotalCount = count($this->getRedisServer());
        $objTmpHander = new Redis();
        $arrRedisServer = $this->getRedisServer();
        while ($intTryCount <= $intTotalCount) {
            $strRandomKey = rand(0, count($arrRedisServer) - 1);
            $strRandomKey = array_keys($arrRedisServer)[$strRandomKey];
            $arrServer = $arrRedisServer[$strRandomKey];
            $blnFlag = $objTmpHander->pconnect($arrServer['host'], $arrServer['port'], Config::get('redis.connect_timeout'), Config::get('redis.persistent_id'));
            if ($blnFlag) {
                $objTmpHander->setOption(Redis::OPT_READ_TIMEOUT, Config::get('redis.read_timeout'));
                $this->arrCurConnectInfo['read'] = $arrServer;

                $this->objReadHander = $objTmpHander;
                break;
            } else {
                unset($arrRedisServer[$strRandomKey]);
                Log::log('redis-read连接失败：' . implode(',', $arrServer), Config::get('const.Log.LOG_REDISERR'));
            }
            $intTryCount++;
        }
        //2.检查是否能连接到读服务器
        if (is_null($this->objReadHander)) {
            Log::log('redis-read句柄初始化失败', Config::get('const.Log.LOG_REDISERR'));
        }
    }

}

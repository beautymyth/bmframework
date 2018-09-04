<?php

namespace App\Http\Model\Console;

use swoole_server;
use Framework\Facade\Log;
use Framework\Facade\Config;
use Framework\Service\Database\DB;
use Framework\Service\Foundation\Application;

class MysqlConnectPoolModel {

    /**
     * swoole服务端实例
     */
    private $objServer;

    /**
     * 应用实例
     */
    private $objApp;

    /**
     * 数据库实例
     */
    private $objDB;

    /**
     * 构造函数
     */
    public function __construct(Application $objApp, DB $objDB) {
        $this->objApp = $objApp;
        $this->objDB = $objDB;
    }

    /**
     * 有新的连接进入时
     */
    public function onConnect($server, $fd, $from_id) {
        
    }

    /**
     * 工作进程启动时
     */
    public function onWorkerStart($server, $worker_id) {
        
    }

    /**
     * 接收到数据时
     */
    public function onReceive($objServer, $fd, $reactor_id, $strData) {
        //1.接受到业务数据操作，分配给task执行
        $mixResult = $objServer->taskwait($strData, 3);
        if ($mixResult === false) {
            $mixResult = json_encode(['success' => 0, 'result' => [], 'err_msg' => 'task timeout']);
        }
        $blnFlag = $objServer->send($fd, $mixResult);
        if (!$blnFlag) {
            //记录日志
        }
    }

    /**
     * task任务完成时
     */
    public function onFinish($objServer, $task_id, $strData) {
        
    }

    /**
     * 处理投递的任务
     */
    public function onTask($objServer, $task_id, $src_worker_id, $strData) {
        //1.参数解析
        $strData = preg_replace('/\r\n/', '', $strData);
        $arrData = json_decode($strData, true);
        //2.执行数据操作
        $arrReturn = [];
        switch ($arrData['type']) {
            case 'select':
                $this->objDB->setMainTable($arrData['main_table']);
                $blnException = false;
                $arrTmp = $this->objDB->select($arrData['sql'], $arrData['param'], $arrData['sql'], $blnException);
                $arrReturn = ['success' => $blnException ? 0 : 1, 'result' => $arrTmp, 'err_msg' => ''];
                break;
            default:
                $arrReturn = ['success' => 0, 'result' => [], 'err_msg' => 'type类型错误'];
                break;
        }
        //数据返回
        return json_encode($arrReturn) . "\r\n";
    }

    /**
     * 准备服务
     */
    protected function prepare() {
        //实例化对象
        //swoole_get_local_ip()获取本机ip
        $this->objServer = new swoole_server(Config::get('database.business_info.devmanager.connect_pool.host'), Config::get('database.business_info.devmanager.connect_pool.port'));
        //设置运行参数
        $this->objServer->set(array(
            'daemonize' => 1, //以守护进程执行
            'max_request' => 10000, //worker进程在处理完n次请求后结束运行
            'worker_num' => Config::get('database.business_info.devmanager.connect_pool.worker_num'),
            'task_worker_num' => Config::get('database.business_info.devmanager.connect_pool.task_num'),
            "task_ipc_mode " => 3, //使用消息队列通信，并设置为争抢模式,
            'heartbeat_check_interval' => 5, //每隔多少秒检测一次，单位秒，Swoole会轮询所有TCP连接，将超过心跳时间的连接关闭掉
            'heartbeat_idle_time' => 10, //TCP连接的最大闲置时间，单位s , 如果某fd最后一次发包距离现在的时间超过则关闭
            'open_eof_split' => true,
            'package_eof' => "\r\n",
            "log_file" => $this->objApp->make('path.storage') . "\log\\" . Config::get('database.business_info.devmanager.connect_pool.log_file')
        ));
        //设置事件回调
        $this->objServer->on('Connect', array($this, 'onConnect'));
        $this->objServer->on('Receive', array($this, 'onReceive'));
        $this->objServer->on('Finish', array($this, 'onFinish'));
        $this->objServer->on('Task', array($this, 'onTask'));
        $this->objServer->on('WorkerStart', array($this, 'onWorkerStart'));
    }

    /**
     * 启动服务
     */
    protected function start() {
        $this->objServer->start();
    }

    /**
     * 运行
     */
    public function run() {
        $this->prepare();
        $this->start();
    }

}

<?php

namespace App\Http\Model\Console;

use swoole_server;
use Framework\Facade\Log;
use Framework\Facade\Config;
use App\Service\MessageQueue\SendWeChatMsg;
use Framework\Service\Foundation\Application;

class SendWeChatMsgModel {

    /**
     * swoole服务端实例
     */
    private $objServer;

    /**
     * 应用实例
     */
    private $objApp;

    /**
     * 消息消费者实例
     */
    private $objSendWeChatMsg;

    /**
     * 构造函数
     */
    public function __construct(Application $objApp, SendWeChatMsg $objSendWeChatMsg) {
        $this->objApp = $objApp;
        $this->objSendWeChatMsg = $objSendWeChatMsg;
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
        if ($this->objSendWeChatMsg->init($worker_id)) {
            $this->objSendWeChatMsg->run();
        }
    }

    /**
     * 接收到数据时
     */
    public function onReceive($server, $fd, $reactor_id, $strData) {
        
    }

    /**
     * task任务完成时
     */
    public function onFinish($serv, $task_id, $strData) {
        
    }

    /**
     * 处理投递的任务
     */
    public function onTask($serv, $task_id, $src_worker_id, $strData) {
        
    }

    /**
     * 准备服务
     */
    protected function prepare() {
        //实例化对象
        //swoole_get_local_ip()获取本机ip
        $this->objServer = new swoole_server(Config::get('messagequeue.send_wechat_msg_consumer.host'), Config::get('messagequeue.send_wechat_msg_consumer.port'));
        //设置运行参数
        $this->objServer->set(array(
            'daemonize' => 1, //以守护进程执行
            'max_request' => 10000, //worker进程在处理完n次请求后结束运行
            'worker_num' => Config::get('messagequeue.send_wechat_msg_consumer.worker_num'),
            "task_ipc_mode " => 3, //使用消息队列通信，并设置为争抢模式,
            'heartbeat_check_interval' => 5, //每隔多少秒检测一次，单位秒，Swoole会轮询所有TCP连接，将超过心跳时间的连接关闭掉
            'heartbeat_idle_time' => 10, //TCP连接的最大闲置时间，单位s , 如果某fd最后一次发包距离现在的时间超过则关闭
            'open_eof_split' => true,
            'package_eof' => "\r\n",
            "log_file" => $this->objApp->make('path.storage') . "\log\\" . Config::get('messagequeue.send_wechat_msg_consumer.log_file')
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

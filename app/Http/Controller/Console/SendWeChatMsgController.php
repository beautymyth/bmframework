<?php

namespace App\Http\Controller\Console;

use Framework\Facade\Config;
use Framework\Contract\Cache\Cache;
use App\Http\Model\Console\SendWeChatMsgModel;
use Framework\Service\Foundation\Controller as ControllerBase;

class SendWeChatMsgController extends ControllerBase {

    /**
     * 消息swoole实例
     */
    protected $objSendWeChatMsgModel;

    /**
     * 构造函数
     */
    public function __construct(SendWeChatMsgModel $objSendWeChatMsgModel) {
        $this->objSendWeChatMsgModel = $objSendWeChatMsgModel;
    }

    /**
     * 运行任务
     */
    public function run() {
        $this->objSendWeChatMsgModel->run();
    }

}

<?php

namespace App\Http\Controller\Api;

use App\Http\Middleware\Api\ApiLog;
use App\Http\Model\Api\MessageModel;
use Framework\Service\Foundation\Controller as ControllerBase;

class MessageController extends ControllerBase {

    /**
     * 消息发送实例
     */
    protected $objMessageModel;

    /**
     * 控制器方法对应的中间件
     * 方法名(小写):方法对应的中间件
     */
    protected $arrMiddleware = [
        'send' => [ApiLog::class]
    ];

    /**
     * 构造函数
     */
    public function __construct(MessageModel $objMessageModel) {
        $this->objMessageModel = $objMessageModel;
    }

    /**
     * 发送消息
     */
    public function send() {
        $strErrMsg = '';
        $blnFlag = $this->objMessageModel->sendMessage($intMsgCount, $strErrMsg);
        return ['success' => $blnFlag ? 1 : 0, 'err_msg' => $strErrMsg, 'msg_count' => $intMsgCount];
    }

}

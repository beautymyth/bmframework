<?php

namespace App\Http\Model\Api;

use Framework\Facade\Log;
use Framework\Facade\Config;
use Framework\Facade\Request;
use Framework\Service\WeChat\WeChat;
use Framework\Service\MessageQueue\QueueProducerBase;

class MessageModel extends QueueProducerBase {

    /**
     * 微信实例
     */
    protected $objWeChat;

    /**
     * 构造函数
     */
    public function __construct(WeChat $objWeChat) {
        $this->objWeChat = $objWeChat;
    }

    /**
     * 初始化连接
     */
    protected function init() {
        //设置初始化参数
        $arrInitParam = [
            'exchange_name' => Config::get('messagequeue.message.queue.exchange_name'),
            'exchange_type' => Config::get('messagequeue.message.queue.exchange_type'),
            'ae_exchange' => Config::get('messagequeue.message.queue.ae_exchange'),
            'queue_bind' => Config::get('messagequeue.message.queue.queue_bind')
        ];
        //调用父类构建方法
        return $this->build($arrInitParam);
    }

    /**
     * 推送消息到队列
     */
    public function sendMessage(&$intMsgCount = 0, &$strErrMsg) {
        $this->checkSendMessage($arrParam, $strErrMsg);
        if (!empty($strErrMsg)) {
            return false;
        } else {
            if ($this->init()) {
                $strExchangeName = Config::get('messagequeue.message.producer.exchange_send');
                $arrMessage = [];
                $intMsgCount = count($arrParam['message']);
                //生成消息
                foreach ($arrParam['message'] as $arrMsg) {
                    $arrMessage[] = ['message' => json_encode($arrMsg), 'route_key' => 'message.wechat'];
                }
                //消息发送
                $blnFlag = $this->send($strExchangeName, $arrMessage, $arrFailMessage, $intFailCount);
                if ($intFailCount == count($arrParam['message'])) {
                    $strErrMsg = '写入消息队列失败';
                    return false;
                } else {
                    if (!empty($arrFailMessage)) {
                        $strErrorMsg = sprintf("\n failmessage:%s \n", json_encode($arrFailMessage));
                        Log::log($strErrorMsg, Config::get('const.Log.LOG_MQERR'));
                    }
                    return true;
                }
            } else {
                $strErrMsg = '连接消息队列失败';
                return false;
            }
        }
    }

    /**
     * 信息检查
     */
    protected function checkSendMessage(&$arrParam = [], &$strErrMsg = '') {
        $strMessage = Request::getParam('message');

        if (empty($strMessage)) {
            $strErrMsg = 'message为空';
            return;
        }

        $arrMessage = json_decode($strMessage, true);
        if (!is_array($arrMessage)) {
            $strErrMsg = 'message格式错误';
            return;
        }

        $arrParam['message'] = $arrMessage;
    }

}

<?php

namespace App\Service\MessageQueue;

use Framework\Facade\Log;
use Framework\Facade\Config;
use Framework\Service\WeChat\WeChat;
use Framework\Service\MessageQueue\QueueConsumerBase;

class SendWeChatMsg extends QueueConsumerBase {

    /**
     * 微信实例
     */
    protected $objWeChat;

    public function __construct(WeChat $objWeChat) {
        $this->objWeChat = $objWeChat;
    }

    /**
     * 初始化连接
     */
    public function init($intWorkId) {
        $this->intWorkId = $intWorkId;
        //设置初始化参数
        $arrInitParam = [
            'exchange_name' => Config::get('messagequeue.message.queue.exchange_name'),
            'exchange_type' => Config::get('messagequeue.message.queue.exchange_type'),
            'ae_exchange' => Config::get('messagequeue.message.queue.ae_exchange'),
            'queue_bind' => Config::get('messagequeue.message.queue.queue_bind'),
            'queue_listen' => Config::get('messagequeue.message.wechat_consumer.queue_listen'),
            'is_requeue' => Config::get('messagequeue.message.wechat_consumer.is_requeue')
        ];
        //调用父类构建方法
        return $this->build($arrInitParam);
    }

    /**
     * 从队列接收消息，进行业务处理
     * 必须要返回true or false
     * @return boolean true：处理成功 false：处理失败
     */
    protected function receiveMessage($strMessage) {
        //为消息增加uid值，失败记录redis次数，当达到一定次数直接返回true，不进入队列再循环
        $arrMessage = json_decode($strMessage, true);
        if (is_array($arrMessage)) {
            //生成消息
            $arrWxMessage = [];
            $arrWxMessage['touser'] = $arrMessage['weixinno'];

            //customerid改成ghzkey
            $arrWxMessage['template_id'] = Config::get("wechat.template_msg.{$arrMessage['customerid']}.{$arrMessage['templatekey']}.template_id");
            $arrWxMessage['url'] = $arrMessage['url'];
            $arrWxMessage['data'] = $arrMessage['data'];

            //发送消息
            $arrRes = $this->objWeChat->sendMsg($arrMessage['customerid'], json_encode($arrWxMessage), $arrMessage['level']);

            //响应处理
            if ($arrRes['errmsg'] == 'ok' || ($arrRes['errmsg'] != 'ok' && in_array($arrRes['errcode'], Config::get('wechat.template_msg.ignore_err_code')))) {
                //消息成功，或为某些特定错误
                return true;
            } else {
                //需要重新发送
                return false;
            }
        } else {
            //消息格式不正确，返回确认，从队列删除
            return true;
        }
    }

}

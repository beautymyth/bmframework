<?php

namespace App\Http\Controller\Console;

use App\Http\Model\Console\MysqlConnectPoolModel;
use Framework\Service\Foundation\Controller as ControllerBase;

class MysqlConnectPoolController extends ControllerBase {

    /**
     * 连接池swoole实例
     */
    protected $objMysqlConnectPoolModel;

    /**
     * 构造函数
     */
    public function __construct(MysqlConnectPoolModel $objMysqlConnectPoolModel) {
        $this->objMysqlConnectPoolModel = $objMysqlConnectPoolModel;
    }

    /**
     * 运行任务
     */
    public function run() {
        $this->objMysqlConnectPoolModel->run();
    }

}

<?php

namespace App\Http\Model\Web\Common;

use Framework\Facade\Request;
use Framework\Service\Database\DB;

class LoginModel {

    /**
     * 数据库实例
     */
    protected $objDB;

    /**
     * 构造函数
     */
    public function __construct(DB $objDB) {
        $this->objDB = $objDB;
    }

    public function checkLogin() {
        echo 2/0;
        $this->objDB->setMainTable('test');
        $arrTmp=$this->objDB->select('select * from test where 1=1');
        var_dump($arrTmp);
    }

}

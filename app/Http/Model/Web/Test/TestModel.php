<?php

namespace App\Http\Model\Web\Test;

use Framework\Facade\App;
use Framework\Facade\Log;
use Framework\Facade\Des;
use Framework\Facade\Cache;
use Framework\Facade\Config;
use Framework\Facade\Request;
use Framework\Service\Database\DB;
use Framework\Service\Database\HashCacheDB;

class TestModel {

    /**
     * 数据库实例
     */
    protected $objDB;

    /**
     * 数据库实例
     */
    protected $objHashCacheDB;

    /**
     * 构造函数
     */
    public function __construct(DB $objDB, HashCacheDB $objHashCacheDB) {
        $this->objDB = $objDB;
        $this->objHashCacheDB = $objHashCacheDB;
    }

    public function testone() {
//        var_dump(Des::encrypt('123456'));
//        var_dump(Des::decrypt('4jqp5AzwjjNEC0rc7RyLELoLMG5HAHerBNR9XuvbqUaYCf5jO+eNSjRFmQMnQDH25rJ7VAeBb4ORsTq5AWU/sA=='));
        var_dump(Cache::exec('get','a'));
        var_dump($this->objDB->setMainTable('test')->select('select * from test where 1=1'));
    }

}

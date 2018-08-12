@@ -0,0 +1,46 @@
<?php
/**
 * web配置
 */
return [
    /**
     * js配置
     */
    'js' => [
        /**
         * 域名
         */
        'domain' => 'http://blog.beautymyth.cn/js/',
        /**
         * 版本号
         */
        'version' => '1',
        /**
         * 是否直接读取压缩的文件
         * 0:开发环境
         * 1:测试与线上环境
         */
        'read_only' => 0
    ],
    /**
     * css配置
     */
    'css' => [
        /**
         * 域名
         */
        'domain' => 'http://blog.beautymyth.cn/css/',
        /**
         * 版本号
         */
        'version' => '1',
        /**
         * 是否直接读取压缩的文件
         * 0:开发环境
         * 1:测试与线上环境
         */
        'read_only' => 0
    ],
];

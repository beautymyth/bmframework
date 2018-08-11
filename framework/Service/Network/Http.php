<?php

namespace Framework\Service\Network;

use Framework\Facade\Log;
use Framework\Facade\Config;

class Http {

    /**
     * 执行http请求
     * @param string $strUrl url
     * @param mix $mixPost post数据
     * @param int $intTimeout 访问超时时间
     * @param array $arrHttpHeader 请求头
     * @param string $strProxy 代理
     * @return boolean|object
     */
    public function curl($strUrl, $mixPost = null, $intTimeout = 10, $arrHttpHeader = [], $strProxy = '') {
        $objCurl = curl_init();
        curl_setopt($objCurl, CURLOPT_URL, $strUrl);
        curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($objCurl, CURLOPT_TIMEOUT, $intTimeout);

        //如果需要post参数的话
        if (isset($mixPost)) {
            curl_setopt($objCurl, CURLOPT_POST, true);
            curl_setopt($objCurl, CURLOPT_POSTFIELDS, $mixPost);
        }

        //设置请求头
        if (!empty($arrHttpHeader)) {
            curl_setopt($objCurl, CURLOPT_HTTPHEADER, $arrHttpHeader);
        }

        //设置代理
        if (!empty($strProxy)) {
            curl_setopt($objCurl, CURLOPT_PROXY, $strProxy);
        }

        //执行与返回结果
        $mixRes = curl_exec($objCurl);
        $intErrNo = curl_errno($objCurl);
        if ($intErrNo > 0) {
            curl_close($objCurl);
            $strLog = sprintf("\n url:%s \n post:%s \n errno:%s \n err:%s \n", $strUrl, (is_null($mixPost) ? '' : (is_array($mixPost) ? json_encode($mixPost) : $mixPost)), $intErrNo, curl_error($objCurl));
            Log::log($strLog, Config::get('const.Log.LOG_CURLEERR'));
            return false;
        } else {
            $intHttpCode = curl_getinfo($objCurl, CURLINFO_HTTP_CODE);
            if ($intHttpCode != 200) {
                curl_close($objCurl);
                $strLog = sprintf("\n url:%s \n post:%s \n httpcode:%s \n", $strUrl, (is_null($mixPost) ? '' : (is_array($mixPost) ? json_encode($mixPost) : $mixPost)), $intHttpCode);
                Log::log($strLog, Config::get('const.Log.LOG_CURLEERR'));
                return false;
            } else {
                curl_close($objCurl);
                return $mixRes;
            }
        }
    }

    /**
     * 从本地或远程读取文件
     * @param string $strFilePath 文件地址
     * @param int $intTimeout 超时时间
     * @param int $intTryCount 重试次数
     * @return boolean|string
     */
    public function fileGetContents($strFilePath, $intTimeout = 10, $intTryCount = 1) {
        //创建上下文对象
        $arrOption = [
            'http' => ['timeout' => $intTimeout]
        ];
        $objContext = stream_context_create($arrOption);

        //读取文件
        $intTryCountTmp = 0;
        $intTryCount = $intTryCount + 1;
        while ($intTryCountTmp < $intTryCount && ($mixRes = file_get_contents($strFilePath, false, $objContext)) === false) {
            $intTryCountTmp++;
        }
        return $mixRes;
    }

}

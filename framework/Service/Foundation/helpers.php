<?php

/*
 * 全局通用方法
 */

if (!function_exists('getMicroTime')) {

    /**
     * 获取当前格式化的毫秒时间
     * <br>2018-08-08 08:08:08.688
     */
    function getMicroTime() {
        list($intSec, $intUsec ) = explode(" ", microtime());
        $strDate = date('Y-m-d H:i:s', $intUsec);
        $intSec = round($intSec * 1000);
        $intSec = $intSec >= 1000 ? 999 : $intSec;
        $intSec = str_pad($intSec, 3, '0', STR_PAD_LEFT);
        return $strDate . '.' . $intSec;
    }

}

if (!function_exists('getGUID')) {

    /**
     * 获取guid
     */
    function getGUID() {
        mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
        $strCharId = strtoupper(md5(uniqid(rand(), true)));
        $strHyphen = chr(45); // "-"
        $strGuid = substr($strCharId, 0, 8) . $strHyphen
                . substr($strCharId, 8, 4) . $strHyphen
                . substr($strCharId, 12, 4) . $strHyphen
                . substr($strCharId, 16, 4) . $strHyphen
                . substr($strCharId, 20, 12);
        return $strGuid;
    }

}
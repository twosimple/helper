<?php
namespace yunqi\helper;

/**
 * funcitions
 * @author destiny
 */
class Funcs
{
    /**
     * post下单请求
     * @param [type] $params
     * @return void
     * @author destiny
     */
    public static function post($url,$params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // 不需要页面内容
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        // 不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 返回最后的Location
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //开启发送post请求选项
        curl_setopt($ch,CURLOPT_POST,true);
        //发送post的数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
        $result = curl_exec($ch);
        //4.返回返回值，关闭连接
        curl_close($ch);
        return json_decode($result,true);
    }

    /**
     * 获取/检查密钥合法性
     * @return void
     * @author destiny
     */
    public static function getKey($key,$type=0)
    {
        $key = $type?openssl_pkey_get_public($key):openssl_pkey_get_private($key);
        if(!$key){
            throw new \Exception("密钥无法使用", 203);
        }
        return $key;
    }

    /**
     * ksort 对数组排序
     * @param [type] $data
     * @return void
     * @author destiny
     */
    public static function ksortParams($data)
    {
        ksort($data);
        $buff = '';
        foreach ($data as $k => $v) {
            $buff.=$k.'='.$v.'&';
        }
        return trim($buff,'&');
    }
}

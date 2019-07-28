<?php
namespace yunqi\helper\encrypts;

use yunqi\helper\Funcs;

/**
 * RSA加密解密
 * @author destiny
 */
class RSA
{
    /**
     * 分段加密
     *
     * @param [type] $data
     * @param [type] $key
     * @param [type] $type 0 私钥加密 1公钥加密
     * @return void
     * @author destiny
     */
    public static function encrypt($data,$key,$type)
    {
        $key     = Funcs::getKey($key,$type);
        $str     = json_encode($data);
        $encrypt = '';
        foreach (str_split($str, 117) as $chunk)
        {
            if($type){
                openssl_public_encrypt($chunk,$encryptData,$key);
            }else{
                openssl_private_encrypt($chunk,$encryptData,$key);
            }
            $encrypt .= $encryptData;
        }
        openssl_free_key($key);
        return $encrypt;
    }

    /**
     * 分段解密
     *
     * @param [type] $str
     * @param [type] $key
     * @param [type] $type 0 私钥加密 1公钥加密
     * @return void
     * @author destiny
     */
    public static function decrypt($str,$key,$type)
    {
        $key     = Funcs::getKey($key,$type);
        $decrypt = '';
        foreach (str_split($str, 128) as $chunk)
        {
            if($type){
                openssl_public_decrypt($chunk,$decryptData,$key);
            }else{
                openssl_private_decrypt($chunk,$decryptData,$key);
            }
            $decrypt .= $decryptData;
        }
        openssl_free_key($key);
        return $decrypt?json_decode($decrypt,true):false;
        return $decrypt;
    }

    /**
     * 对数数据签名
     *
     * @param [type] $key
     * @param [type] $data
     * @return void
     * @author destiny
     */
    public static function sign($key,$data)
    {
        $key  = Funcs::getKey($key);
        $buff = Funcs::ksortParams($data);
        openssl_sign($buff, $sign,$key);
        openssl_free_key($key);
        return $sign;
    }

    /**
     * 验证签名
     * @param [type] $data
     * @param [type] $sign
     * @param [type] $key
     * @return void
     * @author destiny
     */
    public static function checkSign($data,$sign,$key)
    {
        $signStr = Funcs::ksortParams($data);
        $key     = openssl_pkey_get_public($key);
        $result  = openssl_verify($signStr, $sign,$key);
        openssl_free_key($key);
        return $result === 1 ? true : false;
    }
}
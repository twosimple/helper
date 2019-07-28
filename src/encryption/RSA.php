<?php
namespace yunqi\helper\encryption;
use yunqi\helper\Functions;

/**
 * RSA加密解密
 * @author destiny
 */
class RSA
{
    /**
     * 私钥分段加密
     * @param [type] $data
     * @param [type] $key
     * @return void
     * @author destiny
     */
    public static function Encrypt($str,$key)
    {
        $key = Functions::getKey($key);
        $encrypt = '';
        foreach (str_split($str, 117) as $chunk)
        {
            openssl_public_encrypt($chunk,$encryptData,$key);
            $encrypt .= $encryptData;
        }
        openssl_free_key($key);
        return $encrypt;
    }
}
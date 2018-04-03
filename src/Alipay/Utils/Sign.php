<?php

namespace Alipay\Utils;


class Sign
{
    //There two set of RSA keys,
    //and public key need to downloaded from Alipay to verified the response
    protected static $alipayPublicKey;
    //and the private key is generated by customer and then use private key to sign the data,
    //but also it need to upload the public key to Alipay for server to verify your request
    protected static $privateKey;

    // md5 key
    protected static $md5Key;

    /**
     * @return mixed
     */
    public static function getPrivateKey()
    {
        return self::$privateKey;
    }

    /**
     * @param $privateKey
     */
    public static function setPrivateKey($privateKey)
    {
        self::$privateKey = $privateKey;
    }

    /**
     * @return mixed
     */
    public static function getAlipayPublicKey()
    {
        return self::$alipayPublicKey;
    }

    /**
     * @param mixed $alipayPublicKey
     */
    public static function setAlipayPublicKey($alipayPublicKey)
    {
        self::$alipayPublicKey = $alipayPublicKey;
    }

    /**
     * @return mixed
     */
    public static function getMd5Key()
    {
        return self::$md5Key;
    }

    /**
     * @param mixed $alipayPublicKey
     */
    public static function setMd5Key($md5Key)
    {
        self::$md5Key = $md5Key;
    }

    /**
     * @param $data
     * @param $private_key
     *
     * @return string
     */
    public static function rsaSign($data, $signType = 'RSA')
    {
        if (Utility::checkEmpty(self::$privateKey)) {
            throw new \Exception('RSA private key is empty');
        }

        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
               wordwrap(self::$privateKey, 64, "\n", true) .
               "\n-----END RSA PRIVATE KEY-----";

        if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        } else {
            openssl_sign($data, $sign, $res);
        }

        //base64编码
        $sign = base64_encode($sign);

        return $sign;
    }

    /**
     * @param $data
     * @param $alipay_public_key
     * @param $sign
     *
     * @return bool
     */
    public static function rsaVerify($data, $sign, $signType = 'RSA')
    {
        if (Utility::checkEmpty(self::$alipayPublicKey)) {
            throw new \Exception('RSA public key is empty');
        }

        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
               wordwrap(self::$alipayPublicKey, 64, "\n", true) .
               "\n-----END RSA PRIVATE KEY-----";

        if ("RSA2" == $signType) {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        } else {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        }

        return $result;
    }

    /**
     * @param $data
     * @param $private_key
     *
     * @return string
     */
    public static function md5Sign($data)
    {
        if (Utility::checkEmpty(self::$md5Key)) {
            throw new \Exception('md5 key is empty');
        }

        return md5($data . self::$md5Key);
    }

    /**
     * @param $data
     * @param $alipay_public_key
     * @param $sign
     *
     * @return bool
     */
    public static function md5Verify($data, $sign)
    {
        if (Utility::checkEmpty(self::$md5Key)) {
            throw new \Exception('md5 key is empty');
        }

        return md5($data . self::$md5Key) === $sign;
    }


    /**
     * @param $data
     * @param $private_key
     *
     * @return string
     */
    public static function sign($data, $signType)
    {
        if (in_array(strtoupper($signType), ['RSA', 'RSA2'])) {
            return self::rsaSign($data, strtoupper($signType));
        } elseif (strtoupper($signType) == 'MD5') {
            return self::md5Sign($data);
        } else {
            throw new \Exception('Unsupported Sign: ' . $signType);
        }
    }

    /**
     * @param $data
     * @param $alipay_public_key
     * @param $sign
     *
     * @return bool
     */
    public static function verify($data, $sign, $signType)
    {
        if (in_array(strtoupper($signType), ['RSA', 'RSA2'])) {
            return self::rsaVerify($data, $sign, strtoupper($signType));
        } elseif (strtoupper($signType) == 'MD5') {
            return self::md5Verify($data, $sign);
        } else {
            throw new \Exception('Unsupported Sign: ' . $signType);
        }
    }

}
<?php

namespace Alipay\Utils;


class Config
{
    protected static $allConfig = [
        //use sandbox environment or not
        'sandbox'           => false,

        // md5 key
        'md5_key'           => '',

        //and the private key is generated by customer and then use private key to sign the data,
        //but also it need to upload the public key to Alipay for server to verify your request
        'private_key'       => '',
        //There two set of RSA keys,
        //and public key need to downloaded from Alipay to verified the response
        'alipay_public_key' => '',

        //UTF-8, GBK
        'charset'     => 'UTF-8',

        //DSA, RSA, RSA2, MD5
        'sign_type'         => 'MD5',

        //The Alipay account generated when signing with Alipay; its length is 16, and it begins with 2088
        'partner'           => '',

        'app_id' => ''
    ];

    public static function initConfig($configs)
    {
        foreach ($configs as $key => $value) {
            if (array_key_exists($key, self::$allConfig)) {
                self::$allConfig[$key] = $value;
            }
        }
    }

    /**
     * @return mixed
     */
    public static function getPrivateKey()
    {
        return self::$allConfig['private_key'];
    }

    /**
     * @param $privateKey
     */
    public static function setPrivateKey($privateKey)
    {
        self::$allConfig['private_key'] = $privateKey;
    }

    /**
     * @return mixed
     */
    public static function getAlipayPublicKey()
    {
        return self::$allConfig['alipay_public_key'];
    }

    /**
     * @param mixed $alipayPublicKey
     */
    public static function setAlipayPublicKey($alipayPublicKey)
    {
        self::$allConfig['alipay_public_key'] = $alipayPublicKey;
    }

    /**
     * @return mixed
     */
    public static function getMd5Key()
    {
        return self::$allConfig['md5_key'];
    }

    /**
     * @param mixed $alipayPublicKey
     */
    public static function setMd5Key($md5Key)
    {
        self::$allConfig['md5_key'] = $md5Key;
    }

    /**
     * @return mixed
     */
    public static function getSandbox()
    {
        return self::$allConfig['sandbox'];
    }

    /**
     * @param mixed $alipayPublicKey
     */
    public static function setSandbox($sandbox = true)
    {
        self::$allConfig['sandbox'] = $sandbox;
    }

    /**
     * @return mixed
     */
    public static function getPartner()
    {
        return self::$allConfig['partner'];
    }

    /**
     * @param mixed $alipayPublicKey
     */
    public static function setPartner($partner)
    {
        self::$allConfig['partner'] = $partner;
    }


    /**
     * @return mixed
     */
    public static function getCharset()
    {
        return self::$allConfig['charset'];
    }

    /**
     * @param mixed $alipayPublicKey
     */
    public static function setCharset($charset = 'UTF-8')
    {
        self::$allConfig['charset'] = $charset;
    }


    /**
     * @return mixed
     */
    public static function getSignType()
    {
        return self::$allConfig['sign_type'];
    }

    /**
     * @param mixed $alipayPublicKey
     */
    public static function setSignType($type = 'RSA')
    {
        self::$allConfig['sign_type'] = $type;
    }


    /**
     * @return mixed
     */
    public static function getAppId()
    {
        return self::$allConfig['app_id'];
    }

    /**
     * @param mixed $alipayPublicKey
     */
    public static function setAppId($app)
    {
        self::$allConfig['app_id'] = $app;
    }

}
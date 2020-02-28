<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/28 0028
 * Time: 上午 9:47
 */

/**
 * 对微信小程序用户加密数据的解密示例代码.
 *
 * @copyright Copyright (c) 1998-2014 Tencent Inc.
 */
namespace Org\Util;
//pkcs#7填充方法类
//解密处理类
class WXBizDataCrypt {
    private $appid;
    private $sessionKey;
    /**
     * 构造函数
     * @param $sessionKey string 用户在小程序登录后获取的会话密钥
     * @param $appid string 小程序的appid
     */
    public function __construct( $appid, $sessionKey)
    {
        $this->appid = $appid;
        $this->sessionKey = $sessionKey;
    }
    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptData( $encryptedData, $iv, &$data )
    {
        //如果不是24位，就是非法
        if (strlen($this->sessionKey) != 24) {
            return ErrorCode::$IllegalAesKey;
        }
        //sessionKey在传输前base64加密，所以要base64解密
        $aesKey=base64_decode($this->sessionKey);
        //如果不是24位，就是非法
        if (strlen($iv) != 24) {
            return ErrorCode::$IllegalIv;
        }
        //IV在传输前base64加密，所以要base64解密
        $aesIV=base64_decode($iv);
        //encryptedData在传输前base64加密，所以要base64解密
        $aesCipher=base64_decode($encryptedData);
        //用密钥aesKey,初始化AES类
        $pc = new Prpcrypt($aesKey);
        //用密文、初始向量执行解密，得到原文
        $result = $pc->decrypt($aesCipher,$aesIV);
        //如果结果不是0，表示不正常，返回错误代码
        if ($result[0] != 0) {
            return $result[0];
        }
        //把结果转换为数据对象
        $dataObj=json_decode( $result[1] );
        //如果错误结果为空，返回非法密文
        if( $dataObj  == NULL )
        {
            return ErrorCode::$IllegalBuffer;
        }
        //如果数据对象的appid不对，返回非法密文
        if( $dataObj->watermark->appid != $this->appid )
        {
            return ErrorCode::$IllegalBuffer;
        }
        //指针$data获取值
        $data = $result[1];
        //返回正确代码
        return ErrorCode::$OK;
    }
}

class PKCS7Encoder
{
    //块大小为16个字节
    public static $block_size = 16;
    /**
     * 对需要加密的明文进行填充补位
     * @param $text 需要进行填充补位操作的明文
     * @return 补齐明文字符串
     */
    function encode( $text )
    {
        $block_size = PKCS7Encoder::$block_size;
        $text_length = strlen( $text );
        //计算需要填充的位数
        $amount_to_pad = PKCS7Encoder::$block_size - ( $text_length % PKCS7Encoder::$block_size );
        if ( $amount_to_pad == 0 ) {
            $amount_to_pad = PKCS7Encoder::block_size;
        }
        //获得补位所用的字符
        $pad_chr = chr( $amount_to_pad );
        $tmp = "";
        for ( $index = 0; $index < $amount_to_pad; $index++ ) {
            $tmp .= $pad_chr;
        }
        return $text . $tmp;
    }
    /**【去除填充】**
     * 对解密后的明文进行补位删除
     * @param decrypted 解密后的明文
     * @return 删除填充补位后的明文
     */
    function decode($text)
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }
}
/**
 * error code 说明.
 * <ul>
 *    <li>-41001: encodingAesKey 非法</li>
 *    <li>-41003: aes 解密失败</li>
 *    <li>-41004: 解密后得到的buffer非法</li>
 *    <li>-41005: base64加密失败</li>
 *    <li>-41016: base64解密失败</li>
 * </ul>
 */
class ErrorCode
{
    public static $OK = 0;
    public static $IllegalAesKey = -41001;  //非法密钥
    public static $IllegalIv = -41002;      //非法初始向量
    public static $IllegalBuffer = -41003;  //非法密文
    public static $DecodeBase64Error = -41004;  //解码错误
}
/**
 * AES的解密**********************
 *
 * 用于encryptedData
 *
 **********************************/
class Prpcrypt
{
    public $key;
    //构造函数，用密钥初始化
    function Prpcrypt( $k )
    {
        $this->key = $k;
    }
    /**
     * 对密文进行解密
     * @param string $aesCipher 需要解密的密文
     * @param string $aesIV 解密的初始向量
     * @return string 解密得到的明文
     */
    public function decrypt( $aesCipher, $aesIV )
    {
        try {
            //设置为“128位、CBC模式的AES解密”
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            //用密钥key、初始化向量初始化
            mcrypt_generic_init($module, $this->key, $aesIV);
            //**执行解密**（得到带有PKCS#7填充的半原文，所以要去除填充）
            $decrypted = mdecrypt_generic($module, $aesCipher);
            //清理工作与关闭解密
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
        } catch (Exception $e) {
            print_r($e);
            return array(ErrorCode::$IllegalBuffer, null);
        }
        try {
            //去除补位字符（对半原文去除PKCS#7填充）
            $pkc_encoder = new PKCS7Encoder;
            //最终得到结果$result
            $result = $pkc_encoder->decode($decrypted);
        } catch (Exception $e) {
            print $e;
            return array(ErrorCode::$IllegalBuffer, null);
        }
        return array(0, $result);
    }
}
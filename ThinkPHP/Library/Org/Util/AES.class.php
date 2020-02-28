<?php
namespace Org\Util;
/**
* AES加密
*/
class AES
{
    private $key = '';
    private $iv = '';

    public function __construct() {
        $this->key = C('API.key');
        $this->iv = C('API.iv');
    }

    /**
     * 加密
     * @param $data
     * @return string
     */
    public function encrypt($data) {
        if (!is_string($data)) {
            $data = json_encode($data);
        }

        return base64_encode(openssl_encrypt($data, 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv));
    }

    /**
     * 解密
     * @param $data
     * @return bool|string
     */
    public function decrypt($data) {
        return trim(openssl_decrypt(base64_decode($data), 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv));
    }
}

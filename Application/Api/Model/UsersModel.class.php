<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 13:42
 */

namespace Api\Model;

use Think\Model;
use Firebase\JWT\JWT;

class UsersModel extends Model {
    private $AES;

    public function __construct() {
        parent::__construct();

        Vendor('Firebase.JWT');
        Vendor('Firebase.ExpiredException');

        $this->AES = new \Org\Util\AES();
    }

    /**
     * @TODO 获取token
     * @param $uid
     * @return string
     */
    public function getToken($uid) {
        $jwt_config = C('JWT');
        $token = array(
            'iss' => $jwt_config['iss'],
            'aud' => $jwt_config['aud'],
            'iat' => time(),
            'exp' => time() + $jwt_config['exp'],
            'uid' => variable_set('user.id', $uid),
        );

        try {
            return $this->AES->encrypt(JWT::encode($token, $jwt_config['key']));
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * @TODO 根据Auth获取用户UID
     * @param $auth
     * @return int
     */
    public function getUserID($auth) {
        $jwt_config = C('JWT');

        if (!$auth)     return 0;

        try {
            $auth = $this->AES->decrypt($auth);
            $decoded = JWT::decode($auth, $jwt_config['key'], array($jwt_config['type']));
            //print_r($decoded);exit;
            if ($decoded) {
                if (time() > $decoded->exp)     return 0;

                return intval(variable_get($decoded->uid));
            }
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
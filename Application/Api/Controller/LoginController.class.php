<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Api\Controller;

class LoginController extends BaseController {

    public static $OK = 0;
    public static $IllegalAesKey = -41001;
    public static $IllegalIv = -41002;
    public static $IllegalBuffer = -41003;
    public static $DecodeBase64Error = -41004;

    public function __construct() {
        parent::__construct();
    }

    /**
     * 登录
     */
    public function index() {



//        $username = I('post.userName');
//        $password = I('post.passWord');
//
//        if (!$username)             E('请输入用户名');
//        if (!$password)             E('请输入密码');
//
//        $m = D('SysUsers');
//        $user = $m->where(array('username' => $username, 'password' => md5(md5($password))))->find();
//        if (!$user)                 E('用户名或密码错误');
//        if ($user['status'] != 1)   E('该账户已被禁用');
//
//        $token = $m->getToken($user['uid']);
//        $m->where(array('uid' => $user['uid']))->save(array(
//            'last_time' => date('Y-m-d H:i:s'),
//            'last_ip' => get_client_ip()
//        ));
//
//        $this->response = array('status' => 'y', 'msg' => '登录成功', 'data' => array('token' => $token));

        $this->sendResponse();
    }

    public function getWechatOpenId() {
        if (!I('post.code'))        E('请授权微信登录');

        $code = I('post.code');

        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.C('WEIXIN.app_id').'&secret='.C('WEIXIN.app_secret').'&js_code='.$code.'&grant_type=authorization_code';
        $http = new \Org\Util\Http();
        $result = json_decode($http->request($url), true);
        if ($result) {
            $this->response = ['status' => 'y', 'data' => $result];
        }

        $this->sendResponse();
    }

    /**
     * 微信登录
     */
    public function wechat() {
        $openid = I('post.openid');
        $session_key = I('post.session_key');
        if (!$openid || !$session_key)        E('请授权微信登录');

        $m = D('Users');
        $uid = $m->where(['wx_openid' => $openid, 'status' => 1])->getField('user_id');
        $wechat = I('post.wechat');
        $type = I('post.type');
        $data = [];
        if (!$uid) {
            if ($type == 'wechat') {
                $data = [
                    'wx_openid' => $openid,
                    'nickname' => $wechat['nickName'],
                    'avatar' => str_replace('http', 'https', $wechat['avatarUrl']),
                    'county' => $wechat['county'],
                    'province' => $wechat['province'],
                    'city' => $wechat['city'],
                    'gender' => $wechat['gender'],
                    'status' => 1,
                    'reg_ip' => get_client_ip(),
                    'reg_time' => date('Y-m-d H:i:s')
                ];
            } else if ($type == 'mobile') {
                $err = $this->decryptData($wechat['encryptedData'], $wechat['iv'], $session_key, $mobile);
                if ($err != 0)      E('获取手机号码失败');
                $data = [
                    'wx_openid' => $openid,
                    'mobile' => $mobile['phoneNumber'],
                    'status' => 1,
                    'reg_ip' => get_client_ip(),
                    'reg_time' => date('Y-m-d H:i:s'),
                ];
            }

            $m->startTrans();
            $uid = $m->add($data);
            if ($uid) {
                $m->commit();
            } else {
                $m->rollback();
                E('出错了');
            }
        } else {
            if ($type == 'wechat') {
                $data = [
                    'nickname' => $wechat['nickName'],
                    'avatar' => str_replace('http', 'https', $wechat['avatarUrl']),
                    'county' => $wechat['county'],
                    'province' => $wechat['province'],
                    'city' => $wechat['city'],
                    'gender' => $wechat['gender'],
                    'last_ip' => get_client_ip(),
                    'last_time' => date('Y-m-d H:i:s')
                ];
            } else if ($type == 'mobile') {
                $err = $this->decryptData($wechat['encryptedData'], $wechat['iv'], $session_key, $mobile);
                if ($err != 0)      E('获取手机号码失败');

                $data = [
                    'mobile' => $mobile['phoneNumber'],
                    'last_ip' => get_client_ip(),
                    'last_time' => date('Y-m-d H:i:s')
                ];
            }
            $m->startTrans();
            if ($m->where(['user_id' => $uid])->save($data)) {
                $m->commit();
            } else {
                $m->rollback();
                E('出错了');
            }
        }

        if (I('post.pcToken')) {
            $pc_token = I('post.pcToken');
            M('users_token')
                ->where(['token' => $pc_token])
                ->save(['status' => 1, 'user_id' => $uid, 'mtime' => date('Y-m-d H:i:s')]);
        }

        $token = $m->getToken($uid);
        $this->response = ['status' => 'y', 'data' => $token];

        $this->sendResponse();
    }

    // 小程序解密
    public function decryptData($encryptedData, $iv, $sessionKey, &$data){
        if (strlen($sessionKey) != 24) {
            return self::$IllegalAesKey;
        }
        $aesKey = base64_decode($sessionKey);

        if (strlen($iv) != 24) {
            return self::$IllegalIv;
        }
        $aesIV = base64_decode($iv);

        $aesCipher = base64_decode($encryptedData);


        $result = openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj = json_decode( $result);

        if( $dataObj  == NULL ) {
            return self::$IllegalBuffer;
        }
        if( $dataObj->watermark->appid != C('WEIXIN.app_id')) {
            return self::$IllegalBuffer;
        }
        $data = json_decode($result, true);
        return self::$OK;
    }

}
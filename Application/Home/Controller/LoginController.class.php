<?php
/**
 * Login
 */
namespace Home\Controller;

use Think\Exception;

class LoginController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $redirect = urldecode(I('get.redirect'));
        if (!$redirect) {
            $redirect = '/';
        }
        session('wx_redirect_url', $redirect);

        redirect('https://open.weixin.qq.com/connect/qrconnect?appid='.C('OPEN_WECHAT.APP_ID').'&redirect_uri='.urlencode('https://www.squirreal.cn/login/wechat').'&response_type=code&scope=snsapi_login&state=login#wechat_redirect');
    }

    public function wechat() {
        $redirect = session('wx_redirect_url') ? session('wx_redirect_url') : '/';
        try {
            $code = I('get.code');
            $http = new \Org\Util\Http();
            $token = $http->request('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.C('OPEN_WECHAT.APP_ID').'&secret='.C('OPEN_WECHAT.APP_SECRET').'&code='.$code.'&grant_type=authorization_code');
            $token = json_decode($token, true);
            //print_r($token);exit;
            if (!$token || !$token['access_token'])      E('获取token失败');

            $userinfo = $http->request('https://api.weixin.qq.com/sns/userinfo?access_token='.$token['access_token'].'&openid='.$token['openid']);
            $userinfo = json_decode($userinfo, true);
            //print_r($userinfo);exit;
            if (!$userinfo)                             E('获取用户信息失败');

            $m = D('Users');
            $user_id = $m->where(['wx_openid' => $userinfo['openid'], 'status' => 1])->getField('user_id');
            if (!$user_id) {
                $data = [
                    'wx_openid' => $userinfo['openid'],
                    'nickname' => $userinfo['nickname'],
                    'avatar' => str_replace('http://', 'https://', $userinfo['headimgurl']),
                    'county' => $userinfo['county'],
                    'province' => $userinfo['province'],
                    'city' => $userinfo['city'],
                    'gender' => $userinfo['sex'],
                    'status' => 1,
                    'reg_ip' => get_client_ip(),
                    'reg_time' => date('Y-m-d H:i:s')
                ];
                $m->startTrans();
                $user_id = $m->add($data);
                if ($user_id) {
                    $m->commit();
                } else {
                    $m->rollback();
                    E('出错了');
                }
            } else {
                $data = [
                    'nickname' => $userinfo['nickname'],
                    'avatar' => str_replace('http://', 'https://', $userinfo['headimgurl']),
                    'county' => $userinfo['county'],
                    'province' => $userinfo['province'],
                    'city' => $userinfo['city'],
                    'gender' => $userinfo['sex'],
                    'last_ip' => get_client_ip(),
                    'last_time' => date('Y-m-d H:i:s')
                ];
                $m->startTrans();
                if ($m->where(['user_id' => $user_id])->save($data)) {
                    $m->commit();
                } else {
                    $m->rollback();
                    E('出错了');
                }
            }
            $userinfo = M('users')->where(['user_id' => $user_id])->find();
            session('userinfo', $userinfo);
        } catch (\Think\Exception $e) {
            //echo $e->getMessage();
        }
        redirect($redirect);
    }
}
<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Admin\Controller;

class LoginController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 登录
     */
    public function index() {
        $username = I('post.userName');
        $password = I('post.passWord');

        if (!$username)             E('请输入用户名');
        if (!$password)             E('请输入密码');

        $m = D('SysUsers');
        $user = $m->where(array('username' => $username, 'password' => md5(md5($password))))->find();
        if (!$user)                 E('用户名或密码错误');
        if ($user['status'] != 1)   E('该账户已被禁用');

        $token = $m->getToken($user['uid']);
        $m->where(array('uid' => $user['uid']))->save(array(
            'last_time' => date('Y-m-d H:i:s'),
            'last_ip' => get_client_ip()
        ));

        $this->response = array('status' => 'y', 'msg' => '登录成功', 'data' => array('token' => $token));

        $this->sendResponse();
    }


}
<?php

/**
 * Base
 */

namespace Admin\Controller;
use Think\Controller;

abstract class BaseController extends Controller {
    protected $response = ['status' => 'n', 'errcode' => 0, 'msg' => '数据错误!'];
	protected $data = [];
	protected $userinfo;    //用户信息
	protected $uid;         //用户UID

	public function __construct() {
		parent::__construct();

        //入口错误, 禁止从URL访问
        defined('API_ENGINE')	||	$this->setError('非法的访问入口');

        $this->uid = D('SysUsers')->getUserID(I('server.HTTP_X_AUTHORIZATION'));
	}

    /**
     * Check Login
     */
	final protected function checkLogin() {
	    if ($this->uid == 0)    $this->setError('请登录', 401);

	    $this->userinfo = D('SysUsers')->where(['uid' => $this->uid])->find();
	    if (!$this->userinfo || $this->userinfo['status'] != 1) {
            $this->setError('当前账户已失效', 401);
        }

        $this->userinfo['privileges'] = explode(',', M('sys_groups')->where(['group_id' => $this->userinfo['group_id']])->getField('privileges'));

    }

    /**
     * 权限验证
     * @param $priv
     * @param bool $return
     * @return bool
     */
    final protected function userCan($priv, $return = false) {
        if (in_array($priv, $this->userinfo['privileges']))    return true;
        if (!$return) {
            $this->setError('很抱歉, 你没有权限操作模块'.$priv.'！');
        }
        return false;
    }

    /**
     * @TODO Set Error
     * @param string $msg
     * @param int $errcode
     */
    final protected function setError($msg, $errcode = 0) {
        $this->response['status'] = 'n';
        $this->response['errcode'] = $errcode;
        $this->response['msg'] = $msg;
        $this->sendResponse();
    }

    /**
     * @TODO send response
     */
    final protected function sendResponse() {
        if ($this->response['status'] == 'y' && !isset($this->response['msg'])) {
            $this->response['msg'] = '操作成功';
        }
        send_json($this->response);
    }
}

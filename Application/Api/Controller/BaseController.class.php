<?php

/**
 * Base
 */

namespace Api\Controller;

use Think\Controller;

abstract class BaseController extends Controller {
    protected $response = array('status' => 'n', 'errcode' => 0, 'msg' => '数据错误!');
	protected $data = array();
	protected $lang = 'cn';
	protected $userinfo;    //用户信息
	protected $uid;         //用户UID
    protected $weblogic;

	public function __construct() {
		parent::__construct();

        //入口错误, 禁止从URL访问
        defined('Api_ENGINE')	||	$this->setError('非法的访问入口!');

        $this->getLang();
        $this->uid = D('Users')->getUserID(I('server.HTTP_X_AUTHORIZATION'));

        $this->weblogic = D('Weblogic');
        $this->weblogic->setLang($this->lang);
	}

	private function getLang() {
	    if (I('server.HTTP_X_LANG')) {
	        $lang = strtolower(I('server.HTTP_X_LANG'));
	        if (strpos($lang, 'zh') === 0) {
	            $lang = 'cn';
            } else {
	            $lang = 'en';
            }
            //$lang = 'en';
            $this->lang = $lang;
        }
    }

    /**
     * Check Login
     */
    final protected function checkLogin() {
        if ($this->uid == 0)    $this->setError('请登录', 401);

        $this->userinfo = D('Users')->where(['user_id' => $this->uid])->find();
        if (!$this->userinfo || $this->userinfo['status'] != 1) {
            $this->setError('当前账户已失效', 401);
        }
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

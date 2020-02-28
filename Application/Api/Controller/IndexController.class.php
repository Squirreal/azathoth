<?php
/**
 * Api
 */
namespace Api\Controller;

class IndexController {
    private $response = array('status' => 'n', 'errcode' => 0, 'msg' => '数据错误!');

    public function __construct() {

    }

    /**
     * Api 入口
     */
    public function index() {
        try {
            /** Api 安全验证 */
            if (!isset($_SERVER['HTTP_X_REQ_TIME']))        E('非法的请求');
            if (!isset($_SERVER['HTTP_X_REQ_KEY']))         E('非法的请求');

            $req_time = $_SERVER['HTTP_X_REQ_TIME'];
            $req_key = $_SERVER['HTTP_X_REQ_KEY'];
            $decrypted = openssl_decrypt($req_key, 'AES-128-CBC', C('JSApi.key'), OPENSSL_ZERO_PADDING, C('JSApi.iv'));

            if ($req_time - (intval($decrypted) + 2048) != 0)       E('非法的请求');
            //客户端时间与服务器时间差5分钟，禁止请求
            if (abs(intval(microtime(true) * 1000) - $req_time) > 300 * 1000)    E('当前请求已过期，请登录');

            $_POST = json_decode(file_get_contents('php://input'), true);

            $service = I('post.service');
            if (!$service)                                  E('未知的服务');

            define('Api_ENGINE', true);

            $router = explode('.', $service);
            $controller = A($router[0]);
            if (!$controller)                               E('未知的服务:'.$router[0]);

            $action = !isset($router[1]) ? C('DEFAULT_ACTION') : $router[1];

            if (!method_exists($controller, $action))       E('未知的操作:'.$action);

            $controller->$action();
        } catch (\Think\Exception $e) {
            $this->setError($e->getMessage());
        }
    }

    /**
     * Set Error
     * @param string $msg
     * @param int $errcode
     */
    private function setError($msg, $errcode = 0) {
        $this->response['status'] = 'n';
        $this->response['errcode'] = $errcode;
        $this->response['msg'] = $msg;

        send_json($this->response);
    }
}
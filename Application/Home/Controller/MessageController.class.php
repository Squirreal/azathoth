<?php
/**
 * Message
 */
namespace Home\Controller;

use Think\Exception;

class MessageController extends BaseController {

    private $m;

    public function __construct() {
        parent::__construct();

        $this->m = M('message');
    }

    public function index() {
        $response = ['status' => 'n', 'msg' => '数据错误'];

        $type = absint(I('post.type'));
        $id = variable_get(I('post.id'));
        $tel = I('post.tel');
        $msg = I('post.msg');

        try {
            if (!$type || !$id)             E('数据错误');
            if (!$tel)                      E($this->data['lang']['WEB_MESSAGE_TIP_TEL']);
            if (!$msg)                      E($this->data['lang']['WEB_MESSAGE_TIP_MSG']);

            $data = [
                'type' => $type,
                'target_id' => $id,
                'tel' => $tel,
                'message' => $msg,
                'ip' => get_client_ip(),
            ];

            $this->m->startTrans();
            if ($this->m->add($data)) {
                $this->m->commit();
                $response = ['status' => 'y', 'msg' => $this->data['lang']['WEB_MESSAGE_SUBMIT_SUCCESS']];
            } else {
                $this->m->rollback();
                E($this->data['lang']['WEB_MESSAGE_SUBMIT_FAIL']);
            }

        } catch (Exception $e) {
            $response['msg'] = $e->getMessage();
        }

        send_json($response);
    }
}
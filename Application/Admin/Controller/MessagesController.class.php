<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Admin\Controller;

class MessagesController extends BaseController {
    const TAG = 'Messages';
    private $m;

    public function __construct() {
        parent::__construct();

        $this->checkLogin();
        $this->m = M('message');
    }

    public function __call($action, $arguments) {
        //权限控制
        $this->userCan($action != 'index' ? self::TAG.'_'.ucfirst($action) : self::TAG);
        if (!method_exists($this, $action))     $this->setError('未授权页面！');
        $this->$action($arguments);
    }

    /**
     * @TODO 消息列表
     */
    private function index() {
        $page = absint(I('post.page'));
        $page = $page < 1 ? 1 : $page;
        $page_size = absint(I('post.pageSize'));
        $page_size = $page_size < 1 ? 9999 : $page_size;

        $search = I('post.search');
        $where = ['status' => 1];

        if ($search) {
            if ($search['type']) {
                $where['type'] = $search['type'];
            }
            if ($search['page']) {
                $page = absint($search['page']);
            }
            if ($search['pageSize']) {
                $page_size = absint($search['pageSize']);
            }
        }

        $total = $this->m->where($where)->count();

        $messages = $this->m
            ->where($where)
            ->order('msg_id DESC')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        $type_arr = ['1' => '楼盘', '2' => '楼花'];
        if ($messages) {
            $m_buildings = M('buildings');
            $m_presales = M('presales');
            foreach ($messages as $k => $v) {
                $messages[$k]['id'] = variable_set('msg.id', $v['msg_id']);
                $messages[$k]['type'] = $type_arr[$v['type']];
                if ($v['type'] == 1) {
                    $messages[$k]['name'] = $m_buildings->where(['building_id' => $v['target_id']])->getField('name_cn');
                } else if ($v['type'] == 1) {
                    $messages[$k]['name'] = $m_presales->where(['presale_id' => $v['target_id']])->getField('name_cn');
                }

                unset($messages[$k]['msg_id']);
                unset($messages[$k]['target_id']);
            }
        }
        $this->response = [
            'status' => 'y',
            'data' => [
                'data' => $messages,
                'total' => intval($total),
                'size' => $page_size,
            ]
        ];
        $this->sendResponse();
    }

    /**
     * @TODO 删除客户
     */
    private function remove() {
        $id = variable_get(I('post.id'));

        $this->m->where(['msg_id' => $id])->save(array(
            'status' => -1,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ));

        $this->response = array('status' => 'y');
        $this->sendResponse();
    }
}
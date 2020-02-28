<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Admin\Controller;

class CustomersController extends BaseController {
    const TAG = 'Customers';
    private $m;

    public function __construct() {
        parent::__construct();

        $this->checkLogin();
        $this->m = M('users');
    }

    public function __call($action, $arguments) {
        //权限控制
        $this->userCan($action != 'index' ? self::TAG.'_'.ucfirst($action) : self::TAG);
        if (!method_exists($this, $action))     $this->setError('未授权页面！');
        $this->$action($arguments);
    }

    /**
     * @TODO 客户列表
     */
    private function index() {
        $page = absint(I('post.page'));
        $page = $page < 1 ? 1 : $page;
        $page_size = absint(I('post.pageSize'));
        $page_size = $page_size < 1 ? 9999 : $page_size;

        $search = I('post.search');
        $where = ['status' => ['EGT', 0]];

        if ($search) {
            if ($search['nickname']) {
                $where['nickname'] = ['LIKE', '%'.$search['nickname'].'%'];
            }
            if ($search['mobile']) {
                $where['mobile'] = ['LIKE', '%'.$search['mobile'].'%'];
            }
            if ($search['page']) {
                $page = absint($search['page']);
            }
            if ($search['pageSize']) {
                $page_size = absint($search['pageSize']);
            }
        }

        $total = $this->m->where($where)->count();

        $customers = $this->m
            ->where($where)
            ->order('user_id DESC')
            ->field('user_id AS id,nickname,mobile,avatar,gender,city,province,county,status,reg_ip,reg_time,last_ip,last_time')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($customers) {
            foreach ($customers as $k => $v) {
                $customers[$k]['id'] = variable_set('user.id', $v['id']);
            }
        }
        $this->response = [
            'status' => 'y',
            'data' => [
                'data' => $customers,
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

        $this->m->where(['user_id' => $id])->save(array(
            'status' => -1,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ));

        $this->response = array('status' => 'y');
        $this->sendResponse();
    }
}
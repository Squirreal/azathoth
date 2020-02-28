<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Admin\Controller;

class BrokersController extends BaseController {
    const TAG = 'Brokers';
    private $m;

    public function __construct() {
        parent::__construct();

        $this->checkLogin();
        $this->m = M('brokers');
    }

    public function __call($action, $arguments) {
        //权限控制
        $this->userCan($action != 'index' ? self::TAG.'_'.ucfirst($action) : self::TAG);
        if (!method_exists($this, $action))     $this->setError('未知操作！');
        $this->$action($arguments);
    }

    /**
     * @TODO 经纪人列表
     */
    private function index() {
        $page = absint(I('post.page'));
        $page = $page < 1 ? 1 : $page;
        $page_size = absint(I('post.pageSize'));
        $page_size = $page_size < 1 ? 9999 : $page_size;

        $search = I('post.search');
        $where = ['status' => 1];

        if ($search) {
            if ($search['name_cn']) {
                $where['name_cn'] = ['LIKE', '%'.$search['name_cn'].'%'];
            }
            if ($search['name_en']) {
                $where['name_en'] = ['LIKE', '%'.$search['name_en'].'%'];
            }
            if ($search['page']) {
                $page = absint($search['page']);
            }
            if ($search['pageSize']) {
                $page_size = absint($search['pageSize']);
            }
        }

        $total = $this->m->where($where)->count();

        $brokers = $this->m
            ->where($where)
            ->order('broker_id DESC')
            ->field('broker_id AS id,name_cn,name_en,certificate_cn AS certificate,languages_cn AS languages,birthday,avatar,created_time AS time,tel')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($brokers) {
            foreach ($brokers as $k => $v) {
                $brokers[$k]['id'] = variable_set('broker.id', $v['id']);
                $brokers[$k]['avatar'] = $v['avatar'] ? C('FILES_SERVER').$v['avatar'] : '';
            }
        }
        $this->response = [
            'status' => 'y',
            'data' => [
                'data' => $brokers,
                'total' => intval($total),
                'size' => $page_size,
            ]
        ];
        $this->sendResponse();
    }

    /**
     * @TODO 添加经纪人
     */
    private function add() {
        $data = [
            'avatar' => I('post.avatar')['file'],
            'name_cn' => I('post.name_cn'),
            'name_en' => I('post.name_en'),
            'certificate_cn' => I('post.certificate_cn'),
            'certificate_en' => I('post.certificate_en'),
            'languages_cn' => I('post.languages_cn'),
            'languages_en' => I('post.languages_en'),
            'experience_cn' => I('post.experience_cn'),
            'experience_en' => I('post.experience_en'),
            'education_cn' => I('post.education_cn'),
            'education_en' => I('post.education_en'),
            'birthday' => I('post.birthday') ? date('Y-m-d', strtotime(I('post.birthday'))) : null,
            'tel' => I('post.tel'),
            'status' => 1,
            'created_by' => $this->uid,
            'created_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['name_cn'])          E('请输入中文姓名');
        if (!$data['name_en'])          E('请输入英文姓名');

        $check = $this->m->where(['name_cn' => $data['name_cn'], 'name_en' => $data['name_en'], 'status' => 1])->getField('broker_id');
        if ($check)                     E('已经添加过了');

        $this->m->startTrans();
        if ($this->m->add($data)) {
            $this->m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $this->m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 编辑经纪人
     */
    private function modify() {
        $id = variable_get(I('post.id'));

        if (!$id)               E('请选择需要更新的经纪人');

        $broker = $this->m->where(['broker_id' => $id, 'status' => 1])->find();
        if (!$broker)           E('数据不存在或已被删除');

        $data = [
            'avatar' => I('post.avatar')['file'],
            'name_cn' => I('post.name_cn'),
            'name_en' => I('post.name_en'),
            'certificate_cn' => I('post.certificate_cn'),
            'certificate_en' => I('post.certificate_en'),
            'languages_cn' => I('post.languages_cn'),
            'languages_en' => I('post.languages_en'),
            'experience_cn' => I('post.experience_cn'),
            'experience_en' => I('post.experience_en'),
            'education_cn' => I('post.education_cn'),
            'education_en' => I('post.education_en'),
            'birthday' => I('post.birthday') ? date('Y-m-d', strtotime(I('post.birthday'))) : null,
            'tel' => I('post.tel'),
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['name_cn'])          E('请输入中文姓名');
        if (!$data['name_en'])          E('请输入英文姓名');

        $check = $this->m->where(['name_cn' => $data['name_cn'], 'name_en' => $data['name_en'], 'status' => 1, 'broker_id' => ['NEQ', $id]])->getField('broker_id');
        if ($check)                     E('该经纪人已存在');

        $this->m->startTrans();
        $update = $this->m->where(['broker_id' => $id])->save($data);
        if ($update) {
            $this->m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $this->m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 删除经纪人
     */
    private function remove() {
        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择需要删除的经纪人');

        $broker = $this->m->where(['broker_id' => $id, 'status' => 1])->find();
        if (!$broker)          E('数据不存在或已被删除');

        $this->m->startTrans();
        $update = $this->m->where(['broker_id' => $id])->save([
            'status' => -1,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ]);
        if ($update) {
            $this->m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $this->m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 经纪人信息
     */
    public function info() {
        $this->userCan(self::TAG);

        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择经纪人');

        $broker = $this->m
            ->where(['broker_id' => $id, 'status' => 1])
            ->field('broker_id AS id,avatar,name_cn,name_en,certificate_cn,certificate_en,languages_cn,languages_en,experience_cn,experience_en,education_cn,education_en,birthday,tel')
            ->find();
        if (!$broker)          E('数据不存在或已被删除');

        foreach ($broker as $k => $v) {
            $broker[$k] = htmlspecialchars_decode($v, ENT_QUOTES);
        }

        $broker['id'] = I('post.id');
        $broker['avatar'] = [
            'url' => $broker['avatar'] ? C('FILES_SERVER').$broker['avatar'] : '',
            'file' => $broker['avatar']
        ];

        $this->response = ['status' => 'y', 'data' => $broker];

        $this->sendResponse();
    }
}
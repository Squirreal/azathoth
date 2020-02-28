<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Admin\Controller;

class BuildingsController extends BaseController {
    const TAG = 'Buildings';
    private $m;

    public function __construct() {
        parent::__construct();

        $this->checkLogin();
        $this->m = M('buildings');
    }

    public function __call($action, $arguments) {
        //权限控制
        $this->userCan($action != 'index' ? self::TAG.'_'.ucfirst($action) : self::TAG);
        if (!method_exists($this, $action))     $this->setError('未知操作！');
        $this->$action($arguments);
    }

    /**
     * @TODO 楼盘列表
     */
    private function index() {
        $page = absint(I('post.page'));
        $page = $page < 1 ? 1 : $page;
        $page_size = absint(I('post.pageSize'));
        $page_size = $page_size < 1 ? 9999 : $page_size;

        $search = I('post.search');
        $where = ['b.status' => 1];

        if ($search) {
            if ($search['country_id']) {
                $where['b.country_id'] = variable_get($search['country_id']);
            }
            if ($search['city_id']) {
                $where['b.city_id'] = variable_get($search['city_id']);
            }
            if ($search['broker_id']) {
                $where['b.broker_id'] = variable_get($search['broker_id']);
            }
            if (isset($search['is_hot']) && $search['is_hot'] !== '') {
                $where['b.is_hot'] = $search['is_hot'];
            }
            if ($search['name_cn']) {
                $where['b.name_cn'] = ['LIKE', '%'.$search['name_cn'].'%'];
            }
            if ($search['name_en']) {
                $where['b.name_en'] = ['LIKE', '%'.$search['name_en'].'%'];
            }
            if ($search['page']) {
                $page = absint($search['page']);
            }
            if ($search['pageSize']) {
                $page_size = absint($search['pageSize']);
            }
        }

        $total = $this->m
            ->alias('b')
            ->where($where)
            ->count();

        $buildings = $this->m
            ->alias('b')
            ->join('LEFT JOIN __COUNTRY__ co ON b.country_id=co.country_id')
            ->join('LEFT JOIN __CITY__ ci ON b.city_id=ci.city_id')
            ->join('LEFT JOIN __BROKERS__ br ON b.broker_id=br.broker_id')
            ->where($where)
            ->order('b.sort DESC,b.building_id DESC')
            ->field('b.building_id AS id,b.name_cn,b.name_en,b.delivery_time_cn AS delivery_time,b.property_years,b.project_status,co.name_cn AS country,ci.name_cn AS city,br.name_cn AS broker,b.is_hot,b.created_time AS time,b.sort')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($buildings) {
            foreach ($buildings as $k => $v) {
                $buildings[$k]['ID'] = $v['id'];
                $buildings[$k]['id'] = variable_set('building.id', $v['id']);
                $buildings[$k]['project_status'] = C('ENUM.PROJECT_STATUS_CN')[$v['project_status']];
            }
        }
        $this->response = [
            'status' => 'y',
            'data' => [
                'data' => $buildings,
                'total' => intval($total),
                'size' => $page_size,
            ]
        ];
        $this->sendResponse();
    }

    /**
     * @TODO 添加楼盘
     */
    private function add() {
        $data = [
            'country_id' => variable_get(I('post.country_id')),
            'city_id' => variable_get(I('post.city_id')),
            'broker_id' => variable_get(I('post.broker_id')),
            'name_cn' => I('post.name_cn'),
            'name_en' => I('post.name_en'),
            'address_cn' => I('post.address_cn'),
            'address_en' => I('post.address_en'),
            'delivery_time_cn' => I('post.delivery_time_cn'),
            'delivery_time_en' => I('post.delivery_time_en'),
            'property_years' => intval(I('post.property_years')),
            'project_status' => absint(I('post.project_status')),
            'loans_cn' => I('post.loans_cn'),
            'loans_en' => I('post.loans_en'),
            'sort' => I('post.sort'),
//            'assignment_cn' => I('post.assignment_cn'),
//            'assignment_en' => I('post.assignment_en'),
            'status' => 1,
            'created_by' => $this->uid,
            'created_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['country_id'])       E('请选择国家');
        if (!$data['city_id'])          E('请选择城市');
        if (!$data['broker_id'])        E('请选择经纪人');
        if (!$data['name_cn'])          E('请输入中文名称');
        if (!$data['name_en'])          E('请输入英文名称');

        $check = $this->m->where([
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id'],
            'name_cn' => $data['name_cn'], 
            'name_en' => $data['name_en'], 
            'status' => 1
        ])->getField('building_id');
        if ($check)                     E('已经添加过了');

        if (!$data['sort'])             $data['sort'] = $this->m->where('1=1')->max('sort') + 1;

        $this->m->startTrans();
        $bulding_id = $this->m->add($data);
        if ($bulding_id) {
            $this->m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $this->m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 编辑楼盘
     */
    private function modify() {
        $id = variable_get(I('post.id'));
        $act = I('post.act');

        if (!$id)               E('请选择需要更新的楼盘');

        $building = $this->m->where(['building_id' => $id, 'status' => 1])->find();
        if (!$building)           E('数据不存在或已被删除');

        if ($act == 'hot') {
            $data['is_hot'] = !$building['is_hot'];
            $data['modified_by'] = $this->uid;
            $data['modified_time'] = date('Y-m-d H:i:s');
        } else {
            $data = [
                'country_id' => variable_get(I('post.country_id')),
                'city_id' => variable_get(I('post.city_id')),
                'broker_id' => variable_get(I('post.broker_id')),
                'name_cn' => I('post.name_cn'),
                'name_en' => I('post.name_en'),
                'address_cn' => I('post.address_cn'),
                'address_en' => I('post.address_en'),
                'delivery_time_cn' => I('post.delivery_time_cn'),
                'delivery_time_en' => I('post.delivery_time_en'),
                'property_years' => intval(I('post.property_years')),
                'project_status' => absint(I('post.project_status')),
                'loans_cn' => I('post.loans_cn'),
                'loans_en' => I('post.loans_en'),
                'sort' => intval(I('post.sort')),
//                'assignment_cn' => I('post.assignment_cn'),
//                'assignment_en' => I('post.assignment_en'),
                'modified_by' => $this->uid,
                'modified_time' => date('Y-m-d H:i:s'),
            ];

            if (!$data['country_id'])       E('请选择国家');
            if (!$data['city_id'])          E('请选择城市');
            if (!$data['broker_id'])        E('请选择经纪人');
            if (!$data['name_cn'])          E('请输入中文名称');
            if (!$data['name_en'])          E('请输入英文名称');

            $check = $this->m->where([
                'country_id' => $data['country_id'],
                'city_id' => $data['city_id'],
                'name_cn' => $data['name_cn'],
                'name_en' => $data['name_en'],
                'building_id' => ['NEQ', $id],
                'status' => 1
            ])->getField('building_id');
            if ($check)                     E('该楼盘已存在');

            if (!$data['sort'])             $data['sort'] = $this->m->where('1=1')->max('sort') + 1;
        }

        $this->m->startTrans();
        $update = $this->m->where(['building_id' => $id])->save($data);
        if ($update) {
            $this->m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $this->m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 删除楼盘
     */
    private function remove() {
        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择需要删除的楼盘');

        $building = $this->m->where(['building_id' => $id, 'status' => 1])->find();
        if (!$building)          E('数据不存在或已被删除');

        $this->m->startTrans();
        $update = $this->m->where(['building_id' => $id])->save([
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
     * @TODO 楼盘信息
     */
    public function info() {
        $this->userCan(self::TAG);

        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择楼盘');

        $building = $this->m
            ->where(['building_id' => $id, 'status' => 1])
            ->field('building_id AS id,country_id,city_id,broker_id,name_cn,name_en,delivery_time_cn,delivery_time_en,property_years,project_status,loans_cn,loans_en,address_cn,address_en,assignment_cn,assignment_en,sort')
            ->find();
        if (!$building)          E('数据不存在或已被删除');

        foreach ($building as $k => $v) {
            $building[$k] = htmlspecialchars_decode($v, ENT_QUOTES);
        }

        $building['id'] = I('post.id');
        $building['country_id'] = variable_set('country.id', $building['country_id']);
        $building['city_id'] = variable_set('city.id', $building['city_id']);
        $building['broker_id'] = variable_set('broker.id', $building['broker_id']);

        $this->response = ['status' => 'y', 'data' => $building];

        $this->sendResponse();
    }

    /**
     * @TODO 户型列表
     */
    public function apartments() {
        $this->userCan(self::TAG);

        $building_id = variable_get(I('post.building_id'));

        $apartments = M('buildings_apartment')
            ->where(['building_id' => $building_id, 'status' => 1])
            ->order('aid ASC')
            ->field('aid AS id,name_cn,name_en,area_cn,area_en,price_cn,price_en')
            ->select();
        if ($apartments) {
            foreach ($apartments as $k => $v) {
                $apartments[$k]['id'] = variable_set('apartment.id', $v['id']);
                $apartments[$k]['building_id'] = I('post.building_id');
            }
        }

        $this->response = ['status' => 'y', 'data' => $apartments];

        $this->sendResponse();
    }

    /**
     * @TODO 添加户型
     */
    public function apartmentAdd() {
        $this->userCan(self::TAG.'_Add');

        $data = [
            'building_id' => variable_get(I('post.building_id')),
            'name_cn' => I('post.name_cn'),
            'name_en' => I('post.name_en'),
            'area_cn' => I('post.area_cn'),
            'area_en' => I('post.area_en'),
            'price_cn' => I('post.price_cn'),
            'price_en' => I('post.price_en'),
            'status' => 1
        ];

        if (!$data['building_id'])      E('请选择楼盘');
        if (!$data['name_cn'])          E('请输入中文名称');
        if (!$data['name_en'])          E('请输入英文名称');

        $m = M('buildings_apartment');
        $check = $m->where(['building_id' => $data['building_id'], 'name_cn' => $data['name_cn']])->getField('aid');
        if ($check)                     E('已经添加过了');

        $m->startTrans();
        if ($m->add($data)) {
            $m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $m->rollback();
        }
        $this->sendResponse();
    }

    /**
     * @TODO 编辑户型
     */
    public function apartmentModify() {
        $this->userCan(self::TAG.'_Modify');

        $id = variable_get(I('post.id'));
        if (!$id)                       E('请选择需要删除的户型');

        $m = M('buildings_apartment');
        $apartment = $m->where(['aid' => $id, 'status' => 1])->find();
        if (!$apartment)                E('数据不存在或已被删除');

        $data = [
            'building_id' => variable_get(I('post.building_id')),
            'name_cn' => I('post.name_cn'),
            'name_en' => I('post.name_en'),
            'area_cn' => I('post.area_cn'),
            'area_en' => I('post.area_en'),
            'price_cn' => I('post.price_cn'),
            'price_en' => I('post.price_en'),
        ];

        if (!$data['building_id'])      E('请选择楼盘');
        if (!$data['name_cn'])          E('请输入中文名称');
        if (!$data['name_en'])          E('请输入英文名称');

        $m = M('buildings_apartment');
        $check = $m->where(['building_id' => $data['building_id'], 'name_cn' => $data['name_cn'], 'aid' => ['NEQ', $id]])->getField('aid');
        if ($check)                     E('该户型已经存在');

        $m->startTrans();
        $update = $m->where(['aid' => $id])->save($data);
        if ($update) {
            $m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $m->rollback();
        }
        $this->sendResponse();
    }

    /**
     * @TODO 删除户型
     */
    public function apartmentRemove() {
        $this->userCan(self::TAG.'_Remove');

        $id = variable_get(I('post.id'));
        if (!$id)                       E('请选择需要删除的户型');

        $m = M('buildings_apartment');
        $apartment = $m->where(['aid' => $id, 'status' => 1])->find();
        if (!$apartment)                E('数据不存在或已被删除');

        $m->startTrans();
        $update = $m->where(['aid' => $id])->save([
            'status' => -1,
        ]);
        if ($update) {
            $m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $m->rollback();
        }

        $this->sendResponse();
    }
}
<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Admin\Controller;

class PresalesController extends BaseController {
    const TAG = 'Presales';
    private $m;

    public function __construct() {
        parent::__construct();

        $this->checkLogin();
        $this->m = M('presales');
    }

    public function __call($action, $arguments) {
        //权限控制
        $this->userCan($action != 'index' ? self::TAG.'_'.ucfirst($action) : self::TAG);
        if (!method_exists($this, $action))     $this->setError('未知操作！');
        $this->$action($arguments);
    }

    /**
     * @TODO 楼花列表
     */
    private function index() {
        $page = absint(I('post.page'));
        $page = $page < 1 ? 1 : $page;
        $page_size = absint(I('post.pageSize'));
        $page_size = $page_size < 1 ? 9999 : $page_size;

        $search = I('post.search');
        $where = ['p.status' => 1];

        if ($search) {
            if ($search['country_id']) {
                $where['p.country_id'] = variable_get($search['country_id']);
            }
            if ($search['city_id']) {
                $where['p.city_id'] = variable_get($search['city_id']);
            }
            if ($search['broker_id']) {
                $where['p.broker_id'] = variable_get($search['broker_id']);
            }
            if (isset($search['type']) && $search['type'] !== '') {
                $where['p.type'] = $search['type'];
            }
            if ($search['name_cn']) {
                $where['p.name_cn'] = ['LIKE', '%'.$search['name_cn'].'%'];
            }
            if ($search['name_en']) {
                $where['p.name_en'] = ['LIKE', '%'.$search['name_en'].'%'];
            }
            if ($search['page']) {
                $page = absint($search['page']);
            }
            if ($search['pageSize']) {
                $page_size = absint($search['pageSize']);
            }
        }

        $total = $this->m
            ->alias('p')
            ->where($where)
            ->count();

        $presales = $this->m
            ->alias('p')
            ->join('LEFT JOIN __COUNTRY__ co ON p.country_id=co.country_id')
            ->join('LEFT JOIN __CITY__ ci ON p.city_id=ci.city_id')
            ->join('LEFT JOIN __BROKERS__ br ON p.broker_id=br.broker_id')
            ->where($where)
            ->order('p.presale_id DESC')
            ->field('p.presale_id AS id,p.name_cn,p.name_en,p.delivery_time_cn AS delivery_time,p.property_years,p.project_status,co.name_cn AS country,ci.name_cn AS city,br.name_cn AS broker,p.is_hot,p.type,p.floor_cn AS floor,p.room_cn AS room,p.layout_cn AS layout,p.area_cn AS area,p.balcony_area_cn AS balcony_area,p.price_cn AS price,p.created_time AS time,p.sort')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($presales) {
            foreach ($presales as $k => $v) {
                $presales[$k]['ID'] = $v['id'];
                $presales[$k]['id'] = variable_set('presale.id', $v['id']);
                $presales[$k]['project_status'] = C('ENUM.PROJECT_STATUS_CN')[$v['project_status']];
                $presales[$k]['type'] = C('ENUM.PRESALE_TYPE_CN')[$v['type']];
            }
        }
        $this->response = [
            'status' => 'y',
            'data' => [
                'data' => $presales,
                'total' => intval($total),
                'size' => $page_size,
            ]
        ];
        $this->sendResponse();
    }

    /**
     * @TODO 添加楼花
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
            'type' => absint(I('post.type')),
            'floor_cn' => absint(I('post.floor_cn')),
            'floor_en' => absint(I('post.floor_en')),
            'layout_cn' => I('post.layout_cn'),
            'layout_en' => I('post.layout_en'),
            'room_cn' => I('post.room_cn'),
            'room_en' => I('post.room_en'),
            'area_cn' => I('post.area_cn'),
            'area_en' => I('post.area_en'),
            'balcony_area_cn' => I('post.balcony_area_cn'),
            'balcony_area_en' => I('post.balcony_area_en'),
            'price_cn' => I('post.price_cn'),
            'price_en' => I('post.price_en'),
            'sort' => I('post.sort'),
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
        ])->getField('presale_id');
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
     * @TODO 编辑楼花
     */
    private function modify() {
        $id = variable_get(I('post.id'));
        $act = I('post.act');

        if (!$id)               E('请选择需要更新的楼花');

        $presale = $this->m->where(['presale_id' => $id, 'status' => 1])->find();
        if (!$presale)           E('数据不存在或已被删除');

        if ($act == 'hot') {
            $data['is_hot'] = !$presale['is_hot'];
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
                'type' => absint(I('post.type')),
                'floor_cn' => absint(I('post.floor_cn')),
                'floor_en' => absint(I('post.floor_en')),
                'layout_cn' => I('post.layout_cn'),
                'layout_en' => I('post.layout_en'),
                'room_cn' => I('post.room_cn'),
                'room_en' => I('post.room_en'),
                'area_cn' => I('post.area_cn'),
                'area_en' => I('post.area_en'),
                'balcony_area_cn' => I('post.balcony_area_cn'),
                'balcony_area_en' => I('post.balcony_area_en'),
                'price_cn' => I('post.price_cn'),
                'price_en' => I('post.price_en'),
                'sort' => intval(I('post.sort')),
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
                'presale_id' => ['NEQ', $id],
                'status' => 1
            ])->getField('presale_id');
            if ($check)                     E('该楼花已存在');

            if (!$data['sort'])             $data['sort'] = $this->m->where('1=1')->max('sort') + 1;
        }

        $this->m->startTrans();
        $update = $this->m->where(['presale_id' => $id])->save($data);
        if ($update) {
            $this->m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $this->m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 删除楼花
     */
    private function remove() {
        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择需要删除的楼花');

        $presale = $this->m->where(['presale_id' => $id, 'status' => 1])->find();
        if (!$presale)          E('数据不存在或已被删除');

        $this->m->startTrans();
        $update = $this->m->where(['presale_id' => $id])->save([
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
     * @TODO 楼花信息
     */
    public function info() {
        $this->userCan(self::TAG);

        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择楼花');

        $presale = $this->m
            ->where(['presale_id' => $id, 'status' => 1])
            ->field('presale_id AS id,country_id,city_id,broker_id,name_cn,name_en,delivery_time_cn,delivery_time_en,property_years,project_status,address_cn,address_en,type,floor_cn,floor_en,layout_cn,layout_en,room_cn,room_en,area_cn,area_en,balcony_area_cn,balcony_area_en,price_cn,price_en,sort')
            ->find();
        if (!$presale)          E('数据不存在或已被删除');

        foreach ($presale as $k => $v) {
            $presale[$k] = htmlspecialchars_decode($v, ENT_QUOTES);
        }

        $presale['id'] = I('post.id');
        $presale['country_id'] = variable_set('country.id', $presale['country_id']);
        $presale['city_id'] = variable_set('city.id', $presale['city_id']);
        $presale['broker_id'] = variable_set('broker.id', $presale['broker_id']);

        $this->response = ['status' => 'y', 'data' => $presale];

        $this->sendResponse();
    }
}
<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Admin\Controller;

class DataController extends BaseController {
    const TAG = 'Data';

    public function __construct() {
        parent::__construct();

        $this->checkLogin();
    }

    public function __call($action, $arguments) {
        //权限控制
        $this->userCan($action != 'index' ? self::TAG.'_'.ucfirst($action) : self::TAG);
        if (!method_exists($this, $action))     $this->setError('未知操作！');
        $this->$action($arguments);
    }

    /**
     * @TODO 国家列表
     */
    private function country() {
        $m = M('country');
        $page = absint(I('post.page'));
        $page = $page < 1 ? 1 : $page;
        $page_size = absint(I('post.pageSize'));
        $page_size = $page_size < 1 ? 9999 : $page_size;

        $search = I('post.search');
        $where = ['status' => 1];

        if ($search) {
            if ($search['abbr']) {
                $where['abbr'] = $search['abbr'];
            }
            if ($search['name_cn']) {
                $where['name_cn'] = ['LIKE', '%'.$search['name_cn'].'%'];
            }
            if ($search['name_en']) {
                $where['name_en'] = ['LIKE', '%'.$search['name_en'].'%'];
            }
            if (isset($search['is_hot']) && $search['is_hot'] !== '') {
                $where['is_hot'] = $search['is_hot'];
            }
            if (isset($search['is_immigrant']) && $search['is_immigrant'] !== '') {
                $where['is_immigrant'] = $search['is_immigrant'];
            }
            if ($search['page']) {
                $page = absint($search['page']);
            }
            if ($search['pageSize']) {
                $page_size = absint($search['pageSize']);
            }
        }

        $total = $m->where($where)->count();

        $country = $m
            ->where($where)
            ->order('sort DESC,country_id DESC')
            ->field('country_id AS id,abbr,name_cn,name_en,population_cn AS population,area_cn AS area,gdp_cn AS gdp,gdp_per_capita_cn AS gdp_per_capita,gdp_growth_cn AS gdp_growth,national_flag,currency_cn AS currency,exchange_rate_cn AS exchange_rate,is_hot,is_immigrant,lending_rate,created_time AS time,sort')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($country) {
            foreach ($country as $k => $v) {
                $country[$k]['ID'] = $v['id'];
                $country[$k]['id'] = variable_set('country.id', $v['id']);
                $country[$k]['national_flag'] = $v['national_flag'] ? C('FILES_SERVER').$v['national_flag'] : '';
            }
        }
        $this->response = [
            'status' => 'y',
            'data' => [
                'data' => $country,
                'total' => intval($total),
                'size' => $page_size,
            ]
        ];
        $this->sendResponse();
    }

    /**
     * @TODO 添加国家
     */
    private function countryAdd() {
        $data = [
            'abbr' => strtoupper(I('post.abbr')),
            'name_cn' => I('post.name_cn'),
            'name_en' => I('post.name_en'),
            'intro_cn' => I('post.intro_cn'),
            'intro_en' => I('post.intro_en'),
            'population_cn' => I('post.population_cn'),
            'population_en' => I('post.population_en'),
            'area_cn' => I('post.area_cn'),
            'area_en' => I('post.area_en'),
            'gdp_cn' => I('post.gdp_cn'),
            'gdp_en' => I('post.gdp_en'),
            'gdp_per_capita_cn' => I('post.gdp_per_capita_cn'),
            'gdp_per_capita_en' => I('post.gdp_per_capita_en'),
            'gdp_growth_cn' => I('post.gdp_growth_cn'),
            'gdp_growth_en' => I('post.gdp_growth_en'),
            'currency_cn' => I('post.currency_cn'),
            'currency_en' => I('post.currency_en'),
            'exchange_rate_cn' => I('post.exchange_rate_cn'),
            'exchange_rate_en' => I('post.exchange_rate_en'),
            'security_ranking' => I('post.security_ranking'),
            'map' => I('post.map'),
            'national_flag' => I('post.national_flag')['file'],
            'web_cover_img' => I('post.web_cover_img')['file'],
            'is_immigrant' => absint(I('post.is_immigrant')),
            'feature_cn' => I('post.feature_cn'),
            'feature_en' => I('post.feature_en'),
            'immigration_cn' => I('post.immigration_cn'),
            'immigration_en' => I('post.immigration_en'),
            'lending_rate' => floatval(I('post.lending_rate')),
            'sort' => I('post.sort'),
            'status' => 1,
            'created_by' => $this->uid,
            'created_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['abbr'])             E('请输入国家缩写');
        if (!$data['national_flag'])    E('请上传国旗');
        if (!$data['name_cn'])          E('请输入国家中文名称');
        if (!$data['name_en'])          E('请输入国家英文名称');

        $m = M('country');
        $check = $m->where(['abbr' => $data['abbr'], 'status' => 1])->getField('country_id');
        if ($check)                     E('已经添加过了');

        if (!$data['sort'])             $data['sort'] = $m->where('1=1')->max('sort') + 1;

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
     * @TODO 编辑国家
     */
    private function countryModify() {
        $id = variable_get(I('post.id'));
        $act = I('post.act');

        if (!$id)               E('请选择需要更新的国家');
        $m = M('country');

        $country = $m->where(['country_id' => $id, 'status' => 1])->find();
        if (!$country)          E('数据不存在或已被删除');

        if ($act == 'hot') {
            $data['is_hot'] = !$country['is_hot'];
            $data['modified_by'] = $this->uid;
            $data['modified_time'] = date('Y-m-d H:i:s');
        } else {
            $data = [
                'abbr' => strtoupper(I('post.abbr')),
                'name_cn' => I('post.name_cn'),
                'name_en' => I('post.name_en'),
                'intro_cn' => I('post.intro_cn'),
                'intro_en' => I('post.intro_en'),
                'population_cn' => I('post.population_cn'),
                'population_en' => I('post.population_en'),
                'area_cn' => I('post.area_cn'),
                'area_en' => I('post.area_en'),
                'gdp_cn' => I('post.gdp_cn'),
                'gdp_en' => I('post.gdp_en'),
                'gdp_per_capita_cn' => I('post.gdp_per_capita_cn'),
                'gdp_per_capita_en' => I('post.gdp_per_capita_en'),
                'gdp_growth_cn' => I('post.gdp_growth_cn'),
                'gdp_growth_en' => I('post.gdp_growth_en'),
                'currency_cn' => I('post.currency_cn'),
                'currency_en' => I('post.currency_en'),
                'exchange_rate_cn' => I('post.exchange_rate_cn'),
                'exchange_rate_en' => I('post.exchange_rate_en'),
                'security_ranking' => I('post.security_ranking'),
                'map' => I('post.map'),
                'national_flag' => I('post.national_flag')['file'],
                'web_cover_img' => I('post.web_cover_img')['file'],
                'is_immigrant' => absint(I('post.is_immigrant')),
                'feature_cn' => I('post.feature_cn'),
                'feature_en' => I('post.feature_en'),
                'immigration_cn' => I('post.immigration_cn'),
                'immigration_en' => I('post.immigration_en'),
                'lending_rate' => floatval(I('post.lending_rate')),
                'sort' => intval(I('post.sort')),
                'modified_by' => $this->uid,
                'modified_time' => date('Y-m-d H:i:s'),
            ];

            if (!$data['abbr'])             E('请输入国家缩写');
            if (!$data['national_flag'])    E('请上传国旗');
            if (!$data['name_cn'])          E('请输入国家中文名称');
            if (!$data['name_en'])          E('请输入国家英文名称');

            $check = $m->where(['abbr' => $data['abbr'], 'status' => 1, 'country_id' => ['NEQ', $id]])->getField('country_id');
            if ($check)                     E('该国家已存在');

            if (!$data['sort'])             $data['sort'] = $m->where('1=1')->max('sort') + 1;
        }

        $m->startTrans();
        $update = $m->where(['country_id' => $id])->save($data);
        if ($update) {
            $m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 删除国家
     */
    private function countryRemove() {
        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择需要删除的国家');
        $m = M('country');

        $country = $m->where(['country_id' => $id, 'status' => 1])->find();
        if (!$country)          E('数据不存在或已被删除');

        //检查城市
        $city_count = M('city')->where(['country_id' => $id, 'status' => 1])->count();
        if ($city_count > 0)    E('该国家下面还有城市数据，请先删除城市');

        $m->startTrans();
        $update = $m->where(['country_id' => $id])->save([
            'status' => -1,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ]);
        if ($update) {
            $m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 国家信息
     */
    public function countryInfo() {
        $this->userCan(self::TAG.'_Country');

        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择国家');
        $m = M('country');

        $country = $m
            ->where(['country_id' => $id, 'status' => 1])
            ->field('country_id AS id,abbr,name_cn,name_en,population_cn,population_en,area_cn,area_en,gdp_cn,gdp_en,gdp_per_capita_cn,gdp_per_capita_en,gdp_growth_cn,gdp_growth_en,national_flag,web_cover_img,currency_cn,currency_en,exchange_rate_cn,exchange_rate_en,is_hot,is_immigrant,feature_cn,feature_en,immigration_cn,immigration_en,map,security_ranking,lending_rate,intro_cn,intro_en,sort')
            ->find();
        if (!$country)          E('数据不存在或已被删除');

        foreach ($country as $k => $v) {
            $country[$k] = htmlspecialchars_decode($v, ENT_QUOTES);
        }

        $country['id'] = I('post.id');
        $country['national_flag'] = [
            'url' => $country['national_flag'] ? C('FILES_SERVER').$country['national_flag'] : '',
            'file' => $country['national_flag']
        ];
        $country['web_cover_img'] = [
            'url' => $country['web_cover_img'] ? C('FILES_SERVER').$country['web_cover_img'] : '',
            'file' => $country['web_cover_img']
        ];

        $this->response = ['status' => 'y', 'data' => $country];

        $this->sendResponse();
    }

    /**
     * @TODO 城市列表
     */
    private function city() {
        $m = M('city c');
        $page = absint(I('post.page'));
        $page = $page < 1 ? 1 : $page;
        $page_size = absint(I('post.pageSize'));
        $page_size = $page_size < 1 ? 9999 : $page_size;

        $search = I('post.search');
        $where = ['c.status' => 1];

        if ($search) {
            if ($search['country_id']) {
                $where['c.country_id'] = variable_get($search['country_id']);
            }
            if ($search['abbr']) {
                $where['c.abbr'] = ['LIKE', '%'.$search['abbr'].'%'];
            }
            if ($search['name_cn']) {
                $where['c.name_cn'] = ['LIKE', '%'.$search['name_cn'].'%'];
            }
            if ($search['name_en']) {
                $where['c.name_en'] = ['LIKE', '%'.$search['name_en'].'%'];
            }
            if (isset($search['is_hot']) && $search['is_hot'] !== '') {
                $where['c.is_hot'] = $search['is_hot'];
            }
            if ($search['page']) {
                $page = absint($search['page']);
            }
            if ($search['pageSize']) {
                $page_size = absint($search['pageSize']);
            }
        }

        $total = $m->where($where)->count();

        $city = $m
            ->join('LEFT JOIN __COUNTRY__ c1 ON c1.country_id=c.country_id')
            ->where($where)
            ->order('sort DESC,city_id DESC')
            ->field('c1.name_cn AS country_name,c.city_id AS id,c.abbr,c.name_cn,c.name_en,c.climate_cn AS climate,c.area_cn AS area,c.feature_cn AS feature,c.livable_rank,c.cover,c.is_hot,c.created_time AS time,c.sort')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($city) {
            foreach ($city as $k => $v) {
                $city[$k]['ID'] = $v['id'];
                $city[$k]['id'] = variable_set('city.id', $v['id']);
                $city[$k]['cover'] = $v['cover'] ? C('FILES_SERVER').$v['cover'] : '';
            }
        }
        $this->response = [
            'status' => 'y',
            'data' => [
                'data' => $city,
                'total' => intval($total),
                'size' => $page_size,
            ]
        ];
        $this->sendResponse();
    }


    /**
     * @TODO 添加城市
     */
    private function cityAdd() {
        $data = [
            'country_id' => variable_get(I('post.country_id')),
            'abbr' => strtoupper(I('post.abbr')),
            'name_cn' => I('post.name_cn'),
            'name_en' => I('post.name_en'),
            'area_cn' => I('post.area_cn'),
            'area_en' => I('post.area_en'),
            'climate_cn' => I('post.climate_cn'),
            'climate_en' => I('post.climate_en'),
            'feature_cn' => I('post.feature_cn'),
            'feature_en' => I('post.feature_en'),
            'building_intro_cn' => I('post.building_intro_cn'),
            'building_intro_en' => I('post.building_intro_en'),
            'livable_rank' => I('post.livable_rank'),
            'cover' => I('post.cover')['file'],
            'web_cover_img' => I('post.web_cover_img')['file'],
            'sort' => I('post.sort'),
            'status' => 1,
            'created_by' => $this->uid,
            'created_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['country_id'])           E('请选择国家');
        if (!$data['name_cn'])          	E('请输入城市中文名称');
        if (!$data['name_en'])          	E('请输入城市英文名称');

        $m = M('city');
        $check = $m->where([
            'country_id' => $data['country_id'],
            'name_cn' => $data['name_cn'],
            'name_en' => $data['name_en'],
            'status' => 1
        ])->getField('city_id');
        if ($check)                     E('已经添加过了');

        if (!$data['sort'])             $data['sort'] = $m->where('1=1')->max('sort') + 1;

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
     * @TODO 编辑城市
     */
    private function cityModify() {
        $id = variable_get(I('post.id'));
        $act = I('post.act');

        if (!$id)               E('请选择需要更新的城市');
        $m = M('city');

        $city = $m->where(['city_id' => $id, 'status' => 1])->find();
        if (!$city)          E('数据不存在或已被删除');

        if ($act == 'hot') {
            $data['is_hot'] = !$city['is_hot'];
            $data['modified_by'] = $this->uid;
            $data['modified_time'] = date('Y-m-d H:i:s');
        } else {
            $data = [
                'country_id' => variable_get(I('post.country_id')),
                'abbr' => strtoupper(I('post.abbr')),
                'name_cn' => I('post.name_cn'),
                'name_en' => I('post.name_en'),
                'area_cn' => I('post.area_cn'),
                'area_en' => I('post.area_en'),
                'climate_cn' => I('post.climate_cn'),
                'climate_en' => I('post.climate_en'),
                'feature_cn' => I('post.feature_cn'),
                'feature_en' => I('post.feature_en'),
                'building_intro_cn' => I('post.building_intro_cn'),
                'building_intro_en' => I('post.building_intro_en'),
                'livable_rank' => I('post.livable_rank'),
                'cover' => I('post.cover')['file'],
                'web_cover_img' => I('post.web_cover_img')['file'],
                'sort' => intval(I('post.sort')),
                'modified_by' => $this->uid,
                'modified_time' => date('Y-m-d H:i:s'),
            ];

            if (!$data['country_id'])           E('请选择国家');
            if (!$data['name_cn'])              E('请输入城市中文名称');
            if (!$data['name_en'])              E('请输入城市英文名称');

            if (!$data['sort'])             $data['sort'] = $m->where('1=1')->max('sort') + 1;

            $check = $m->where([
                'country_id' => $data['country_id'],
                'name_cn' => $data['name_cn'],
                'name_en' => $data['name_en'],
                'status' => 1,
                'city_id' => ['NEQ', $id]
            ])->getField('city_id');
            if ($check)                         E('该城市已存在');
        }

        $m->startTrans();
        $update = $m->where(['city_id' => $id])->save($data);
        if ($update) {
            $m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 删除城市
     */
    private function cityRemove() {
        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择需要删除的城市');
        $m = M('city');

        $city = $m->where(['city_id' => $id, 'status' => 1])->find();
        if (!$city)             E('数据不存在或已被删除');

        $check = M('buildings')->where(['city_id' => $id, 'status' => 1])->count();
        if ($check > 0)         E('该城市下面尚有楼盘数据，请删除楼盘');

        $m->startTrans();
        $update = $m->where(['city_id' => $id])->save([
            'status' => -1,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ]);
        if ($update) {
            $m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 城市信息
     */
    public function cityInfo() {
        $this->userCan(self::TAG.'_City');

        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择城市');
        $m = M('city');

        $city = $m
            ->where(['city_id' => $id, 'status' => 1])
            ->field('country_id,abbr,name_cn,name_en,area_cn,area_en,climate_cn,climate_en,feature_cn,feature_en,building_intro_cn,building_intro_en,livable_rank,cover,web_cover_img,is_hot,sort')
            ->find();
        if (!$city)          E('数据不存在或已被删除');

        foreach ($city as $k => $v) {
            $city[$k] = htmlspecialchars_decode($v, ENT_QUOTES);
        }

        $city['id'] = I('post.id');
        $city['country_id'] = variable_set('country.id', $city['country_id']);
        $city['cover'] = [
            'url' => $city['cover'] ? C('FILES_SERVER').$city['cover'] : '',
            'file' => $city['cover']
        ];
        $city['web_cover_img'] = [
            'url' => $city['web_cover_img'] ? C('FILES_SERVER').$city['web_cover_img'] : '',
            'file' => $city['web_cover_img']
        ];

        $this->response = ['status' => 'y', 'data' => $city];

        $this->sendResponse();
    }

    /**
     * @TODO 学校列表
     */
    public function school() {
        $this->userCan(self::TAG.'_City');

        $city_id = variable_get(I('post.city_id'));

        $school = M('school')
            ->where(['city_id' => $city_id, 'status' => 1])
            ->order('school_id ASC')
            ->field('school_id AS id,name_cn,name_en')
            ->select();
        if ($school) {
            foreach ($school as $k => $v) {
                $school[$k]['id'] = variable_set('school.id', $v['id']);
                $school[$k]['city_id'] = I('post.city_id');
            }
        }

        $this->response = ['status' => 'y', 'data' => $school];

        $this->sendResponse();
    }

    /**
     * @TODO 添加学校
     */
    public function schoolAdd() {
        $this->userCan(self::TAG.'_CityAdd');

        $data = [
            'city_id' => variable_get(I('post.city_id')),
            'name_cn' => I('post.name_cn'),
            'name_en' => I('post.name_en'),
            'status' => 1,
            'created_by' => $this->uid,
            'created_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['city_id'])      	E('请选择城市');
        if (!$data['name_cn'])          E('请输入中文名称');
        if (!$data['name_en'])          E('请输入英文名称');

        $m = M('school');
        $check = $m->where(['city_id' => $data['city_id'], 'name_cn' => $data['name_cn'], 'status' => 1])->getField('school_id');
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
     * @TODO 编辑学校
     */
    public function schoolModify() {
        $this->userCan(self::TAG.'_CityModify');

        $id = variable_get(I('post.id'));
        if (!$id)                       E('请选择需要删除的学校');

        $m = M('school');
        $school = $m->where(['school_id' => $id, 'status' => 1])->find();
        if (!$school)                E('数据不存在或已被删除');

        $data = [
            'city_id' => variable_get(I('post.city_id')),
            'name_cn' => I('post.name_cn'),
            'name_en' => I('post.name_en'),
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['city_id'])      	E('请选择城市');
        if (!$data['name_cn'])          E('请输入中文名称');
        if (!$data['name_en'])          E('请输入英文名称');

        $m = M('school');
        $check = $m->where(['city_id' => $data['city_id'], 'status' => 1, 'name_cn' => $data['name_cn'], 'school_id' => ['NEQ', $id]])->getField('school_id');
        if ($check)                     E('该学校已经存在');

        $m->startTrans();
        $update = $m->where(['school_id' => $id])->save($data);
        if ($update) {
            $m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $m->rollback();
        }
        $this->sendResponse();
    }

    /**
     * @TODO 删除学校
     */
    public function schoolRemove() {
        $this->userCan(self::TAG.'_CityRemove');

        $id = variable_get(I('post.id'));
        if (!$id)                       E('请选择需要删除的学校');

        $m = M('school');
        $school = $m->where(['school_id' => $id, 'status' => 1])->find();
        if (!$school)                E('数据不存在或已被删除');

        $m->startTrans();
        $update = $m->where(['school_id' => $id])->save([
            'status' => -1,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s'),
        ]);
        if ($update) {
            $m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $m->rollback();
        }

        $this->sendResponse();
    }


    /**
     * @TODO 语言列表
     */
    private function lang() {
        $m = M('common_lang');
        $page = absint(I('post.page'));
        $page = $page < 1 ? 1 : $page;
        $page_size = absint(I('post.pageSize'));
        $page_size = $page_size < 1 ? 9999 : $page_size;

        $search = I('post.search');
        $where = ['status' => 1];

        if ($search) {
            if ($search['lkey']) {
                $where['lkey'] = ['LIKE', '%'.$search['lkey'].'%'];
            }
            if ($search['cn']) {
                $where['cn'] = ['LIKE', '%'.$search['cn'].'%'];
            }
            if ($search['en']) {
                $where['en'] = ['LIKE', '%'.$search['en'].'%'];
            }
            if ($search['page']) {
                $page = absint($search['page']);
            }
            if ($search['pageSize']) {
                $page_size = absint($search['pageSize']);
            }
        }

        $total = $m->where($where)->count();

        $lang = $m
            ->where($where)
            ->order('lang_id DESC')
            ->field('lang_id AS id,lkey,cn,en,created_time AS time')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($lang) {
            foreach ($lang as $k => $v) {
                $lang[$k]['id'] = variable_set('lang.id', $v['id']);
            }
        }
        $this->response = [
            'status' => 'y',
            'data' => [
                'data' => $lang,
                'total' => intval($total),
                'size' => $page_size,
            ]
        ];
        $this->sendResponse();
    }

    /**
     * @TODO 添加语言
     */
    private function langAdd() {
        $data = [
            'cn' => I('post.cn'),
            'en' => I('post.en'),
            'lkey' => strtoupper(I('post.lkey')),
            'status' => 1,
            'created_by' => $this->uid,
            'created_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['lkey'])             E('请输入KEY');
        if (!$data['cn'])          		E('请输入中文');
        if (!$data['en'])          		E('请输入英文');

        $m = M('common_lang');
        $check = $m->where(['lkey' => $data['lkey'], 'status' => 1])->getField('lang_id');
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
     * @TODO 编辑语言
     */
    private function langModify() {
        $id = variable_get(I('post.id'));

        if (!$id)               		E('请选择需要更新的语言');
        $m = M('common_lang');

        $tag = $m->where(['lang_id' => $id, 'status' => 1])->find();
        if (!$tag)          		E('数据不存在或已被删除');

        $data = [
            'cn' => I('post.cn'),
            'en' => I('post.en'),
            'lkey' => strtoupper(I('post.lkey')),
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s'),
        ];

        if (!$data['lkey'])             E('请输入KEY');
        if (!$data['cn'])          		E('请输入中文');
        if (!$data['en'])          		E('请输入英文');

        $check = $check = $m->where(['lkey' => $data['lkey'], 'status' => 1, 'lang_id' => ['NEQ', $id]])->getField('lang_id');
        if ($check)                     E('KEY已存在');

        $m->startTrans();
        $update = $m->where(['lang_id' => $id])->save($data);
        if ($update) {
            $m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 删除语言
     */
    private function langRemove() {
        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择需要删除的语言');
        $m = M('common_lang');

        $tag = $m->where(['lang_id' => $id, 'status' => 1])->find();
        if (!$tag)          E('数据不存在或已被删除');

        $m->startTrans();
        $update = $m->where(['lang_id' => $id])->save([
            'status' => -1,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
        ]);
        if ($update) {
            $m->commit();
            $this->response = ['status' => 'y'];
        } else {
            $m->rollback();
        }

        $this->sendResponse();
    }

    /**
     * @TODO 媒体资源列表
     */
    private function media() {
        $mtype = absint(I('post.mtype'));
        $source_id = variable_get(I('post.sourceId'));

        $media = M('media')
            ->where(['mtype' => $mtype, 'source_id' => $source_id, 'status' => 1])
            ->order('sort DESC, media_id ASC')
            ->field('media_id AS id, type, name, file, link_type, link_url, sort,created_time AS time')
            ->select();
        if ($media) {
            foreach ($media as $k => $v) {
                $media[$k]['id'] = variable_set('media.id', $v['id']);
                $media[$k]['type_txt'] = C('ENUM.MEDIA_TYPE')[$v['type']];
                $media[$k]['file'] = C('FILES_SERVER').$v['file'];
            }
        }

        $this->response = ['status' => 'y', 'data' => $media];
        $this->sendResponse();
    }

    /**
     * @TODO 添加媒体
     */
    private function mediaAdd() {
        $mtype = absint(I('post.mtype'));
        $source_id = variable_get(I('post.sourceId'));
        $file = I('post.file');
        $name = I('post.name');

        if (!$file)             E('请上传文件');

        $file_type = strtolower(substr($file, strrpos($file, '.') + 1));
        $type = 1;
        if ($file_type == 'mp4') {
            $type = 2;
        } else if ($file_type == 'pdf') {
            $type = 3;
        }

        $m = M('media');

        $data = [
            'type' => $type,
            'mtype' => $mtype,
            'source_id' => $source_id,
            'name' => $name,
            'file' => $file,
            'sort' => $m->where(['mtype' => $mtype, 'source_id' => $source_id, 'status' => 1])->count() + 1,
            'status' => 1,
            'created_by' => $this->uid,
            'created_time' => date('Y-m-d H:i:s')
        ];

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
     * @TODO 更新媒体
     */
    private function mediaModify() {
        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择需要删除的媒体');
        $m = M('media');

        $media = $m->where(['media_id' => $id, 'status' => 1])->find();
        if (!$media)          E('数据不存在或已被删除');

        $act = I('post.act');
        $data = [];

        if ($act == 'link') {
            $data['link_url'] = I('post.link_url');
            $data['link_type'] = absint(I('post.link_type'));
        } else if ($act == 'sort') {
            $data['sort'] = absint(I('post.sort'));
        }

        if ($data) {
            $m->startTrans();
            $update = $m->where(['media_id' => $id])->save($data);
            if ($update) {
                $m->commit();
                $this->response = ['status' => 'y'];
            } else {
                $m->rollback();
            }
        }

        $this->sendResponse();
    }

    /**
     * @TODO 删除媒体
     */
    private function mediaRemove() {
        $id = variable_get(I('post.id'));
        if (!$id)               E('请选择需要删除的媒体');
        $m = M('media');

        $media = $m->where(['media_id' => $id, 'status' => 1])->find();
        if (!$media)          E('数据不存在或已被删除');

        $m->startTrans();
        $update = $m->where(['media_id' => $id])->save([
            'status' => -1,
            'modified_by' => $this->uid,
            'modified_time' => date('Y-m-d H:i:s')
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
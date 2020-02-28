<?php
namespace Common\Model;

class WeblogicModel {
    private $lang;

    public function service($service, $args) {
        $router = explode('.', $service);
        $action = strtolower($router[0]).ucfirst($router[1]);

        return method_exists($this, $action) ? $this->$action($args) : [];
    }

    /**
     * @param mixed $lang
     */
    public function setLang($lang) {
        $this->lang = $lang;
    }

    /**
     * Home->index
     * @param $args
     * @return mixed
     */
    private function homeIndex($args) {
        //热门国家
        $hot_country = M('country')
            ->where(['status' => 1, 'is_hot' => 1])
            ->field('country_id AS id,name_'.$this->lang.' AS name,abbr,national_flag AS cover,web_cover_img,is_immigrant,intro_'.$this->lang.' AS intro')
            ->order('sort DESC,country_id DESC')
            ->limit(20)
            ->select();
        if ($hot_country) {
            foreach ($hot_country as $k => $v) {
                $hot_country[$k]['id'] = variable_set('country.id', $v['id']);
                $hot_country[$k]['cover'] = get_oss_image($v['cover']);
                $hot_country[$k]['web_cover_img'] = get_oss_image($v['web_cover_img'], 502, 316);
                $hot_country[$k]['is_immigrant'] = boolval($v['is_immigrant']);
                $hot_country[$k]['full_name'] = $v['name'];
                if ($this->lang != 'cn') {
                    $hot_country[$k]['name'] = $v['abbr'];
                }
                unset($hot_country[$k]['abbr']);
            }
        }

        //热门城市
        $hot_city = M('city ci')
            ->join('LEFT JOIN __COUNTRY__ co ON co.country_id=ci.country_id')
            ->where(['ci.status' => 1, 'ci.is_hot' => 1])
            ->field('ci.city_id AS id,ci.name_'.$this->lang.' AS name,co.name_'.$this->lang.' AS country_name,ci.abbr,ci.cover,ci.web_cover_img')
            ->order('ci.sort DESC,ci.city_id DESC')
            ->limit(20)
            ->select();
        if ($hot_city) {
            foreach ($hot_city as $k => $v) {
                $hot_city[$k]['id'] = variable_set('city.id', $v['id']);
                $hot_city[$k]['cover'] = get_oss_image($v['cover']);
                $hot_city[$k]['web_cover_img'] = get_oss_image($v['web_cover_img'], 502, 316);
                $hot_city[$k]['full_name'] = $v['name'];
                if ($this->lang != 'cn') {
                    $hot_city[$k]['name'] = $v['abbr'];
                }
                unset($hot_city[$k]['abbr']);
            }
        }

        $data['banner'] = $this->getBanner(7, 0);
        $data['hot_country'] = $hot_country;
        $data['hot_city'] = $hot_city;

        return $data;
    }

    /**
     * Home->hotBuildings
     * @param $args
     * @return mixed
     */
    private function homeHotBuildings($args) {
        $page = $args['page'];
        $page = $page < 1 ? 1 : $page;
        $page_size = 20;
        $hot_buildings = M('buildings b')
            ->join('LEFT JOIN __COUNTRY__ co ON co.country_id=b.country_id')
            ->join('LEFT JOIN __CITY__ ci ON ci.city_id=b.city_id')
            ->field('b.building_id AS id, b.name_'.$this->lang.' AS name, co.name_'.$this->lang.' AS country_name, ci.name_'.$this->lang.' AS city_name')
            ->where(['b.status' => 1, 'b.is_hot' => 1])
            ->order('b.sort DESC,b.building_id DESC')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($hot_buildings) {
            $m_apartment = M('buildings_apartment');
            $m_media = M('media');
            $m_tags = M('common_tags');
            foreach ($hot_buildings as $k => $v) {
                $hot_buildings[$k]['location'] = $v['country_name'].'·'.$v['city_name'];
                $hot_buildings[$k]['tag'] = $m_tags->where(['type' => 1, 'source_id' => $v['id'], 'status' => 1])->order('tag_id ASC')->getField('name_'.$this->lang);
                $min_price = $m_apartment
                    ->where(['building_id' => $v['id'], 'status' => 1])
                    ->order('price_'.$this->lang.' ASC')
                    ->getField('price_'.$this->lang);
//                $max_price = $m_apartment
//                    ->where(['building_id' => $v['id'], 'status' => 1])
//                    ->order('price_'.$this->lang.' DESC')
//                    ->getField('price_'.$this->lang);
                $hot_buildings[$k]['price'] = $min_price;
                $cover = $m_media
                    ->where(['source_id' => $v['id'], 'type' => 1, 'mtype' => '3', 'status' => 1])
                    ->order('sort ASC')
                    ->getField('file');
                $hot_buildings[$k]['cover'] = get_oss_image($cover, 492, 440);
                $hot_buildings[$k]['id'] = variable_set('building.id', $v['id']);
            }
        }

        return $hot_buildings;
    }

    /**
     * Home->presales
     * @param $args
     * @return mixed
     */
    private function homePresales($args) {
        $page = absint($args['page']);
        $page = $page < 1 ? 1 : $page;
        $page_size = absint($args['pageSize']);
        $page_size = $page_size < 1 ? 20 : $page_size;
        $presales = M('presales p')
            ->join('LEFT JOIN __COUNTRY__ co ON co.country_id=p.country_id')
            ->join('LEFT JOIN __CITY__ ci ON ci.city_id=p.city_id')
            ->field('p.presale_id AS id, p.type, p.name_'.$this->lang.' AS name, p.type, p.floor_'.$this->lang.' AS floor, p.room_'.$this->lang.' AS room, p.layout_'.$this->lang.' AS layout, p.area_'.$this->lang.' AS area, p.balcony_area_'.$this->lang.' AS balcony_area, p.price_'.$this->lang.' AS price, co.name_'.$this->lang.' AS country_name, ci.name_'.$this->lang.' AS city_name')
            ->where(['p.status' => 1, 'p.is_hot' => 1])
            ->order('p.sort DESC,p.presale_id DESC')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($presales) {
            $m_media = M('media');
            foreach ($presales as $k => $v) {
                $cover = $m_media
                    ->where(['source_id' => $v['id'], 'type' => 1, 'mtype' => '8', 'status' => 1])
                    ->field('file')
                    ->order('sort ASC')
                    ->limit(1, 1)
                    ->select();
                $presales[$k]['cover'] = get_oss_image($cover ? $cover[0]['file'] : '', 492, 440);
                $presales[$k]['id'] = variable_set('presale.id', $v['id']);
                $presales[$k]['type'] = C('ENUM.PRESALE_TYPE_'.strtoupper($this->lang))[$v['type']];
            }
        }

        return $presales;
    }

    /**
     * Country->index
     * @param $args
     * @return array
     */
    private function countryIndex($args) {
        $id = variable_get($args['id']);

        $country = M('country')
            ->where(['status' => 1, 'country_id' => $id])
            ->find();

        if (!$country)      E('数据不存在！');

        $data = [];
        $info['name'] = $country['name_'.$this->lang];
        $info['abbr'] = $country['abbr'];
        $info['population'] = $country['population_'.$this->lang];
        $info['area'] = $country['area_'.$this->lang];
        $info['gdp'] = $country['gdp_'.$this->lang];
        $info['gdp_per_capita'] = $country['gdp_per_capita_'.$this->lang];
        $info['gdp_growth'] = $country['gdp_growth_'.$this->lang];
        $info['currency'] = $country['currency_'.$this->lang];
        $info['exchange_rate'] = $country['exchange_rate_'.$this->lang];
        $info['security_ranking'] = $country['security_ranking'];
        $info['map'] = $country['map'];
        $info['national_flag'] = $country['national_flag'] ? C('FILES_SERVER').$country['national_flag'] : '';
        $info['is_hot'] = $country['is_hot'];
        $info['feature'] = htmlspecialchars_decode($country['feature_'.$this->lang], ENT_QUOTES);
        $info['immigration'] = htmlspecialchars_decode($country['immigration_'.$this->lang], ENT_QUOTES);

        $data['info'] = $info;
        $data['banner'] = $this->getBanner(1, $id);

        //热门城市
        $hot_city = M('city')
            ->where(['status' => 1, 'is_hot' => 1, 'country_id' => $id])
            ->field('city_id AS id,name_'.$this->lang.' AS name,abbr,cover,web_cover_img')
            ->order('sort DESC,city_id DESC')
            ->limit(20)
            ->select();
        if ($hot_city) {
            foreach ($hot_city as $k => $v) {
                $hot_city[$k]['id'] = variable_set('city.id', $v['id']);
                $hot_city[$k]['cover'] = get_oss_image($v['cover']);
                $hot_city[$k]['web_cover_img'] = get_oss_image($v['web_cover_img'], 502, 316);
                $hot_city[$k]['full_name'] = $v['name'];
                if ($this->lang != 'cn') {
                    $hot_city[$k]['name'] = $v['abbr'];
                }
                unset($hot_city[$k]['abbr']);
            }
        }
        $data['hot_city'] = $hot_city;

        return $data;
    }

    /**
     * Country->buildings
     * @param $args
     * @return mixed
     */
    private function countryBuildings($args) {
        $id = variable_get($args['id']);
        $page = absint($args['page']);
        $page = $page < 1 ? 1 : $page;
        $page_size = 20;
        $buildings = M('buildings b')
            ->join('LEFT JOIN __COUNTRY__ co ON co.country_id=b.country_id')
            ->join('LEFT JOIN __CITY__ ci ON ci.city_id=b.city_id')
            ->field('b.building_id AS id, b.name_'.$this->lang.' AS name, co.name_'.$this->lang.' AS country_name, ci.name_'.$this->lang.' AS city_name')
            ->where(['b.status' => 1, 'b.country_id' => $id])
            ->order('b.sort DESC,b.building_id DESC')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($buildings) {
            $m_apartment = M('buildings_apartment');
            $m_media = M('media');
            $m_tags = M('common_tags');
            foreach ($buildings as $k => $v) {
                $buildings[$k]['location'] = $v['country_name'].'·'.$v['city_name'];
                $buildings[$k]['tag'] = $m_tags->where(['type' => 1, 'source_id' => $v['id'], 'status' => 1])->order('tag_id ASC')->getField('name_'.$this->lang);
                $min_price = $m_apartment
                    ->where(['building_id' => $v['id'], 'status' => 1])
                    ->order('price_'.$this->lang.' ASC')
                    ->getField('price_'.$this->lang);
//                $max_price = $m_apartment
//                    ->where(['building_id' => $v['id'], 'status' => 1])
//                    ->order('price_'.$this->lang.' DESC')
//                    ->getField('price_'.$this->lang);
                $buildings[$k]['price'] = $min_price;
                $cover = $m_media
                    ->where(['source_id' => $v['id'], 'type' => 1, 'mtype' => '3', 'status' => 1])
                    ->order('sort ASC')
                    ->getField('file');
                $buildings[$k]['cover'] = get_oss_image($cover, 492, 440);
                $buildings[$k]['id'] = variable_set('building.id', $v['id']);
            }
        }

        return $buildings;
    }

    /**
     * Country->presales
     * @param $args
     * @return mixed
     */
    private function countryPresales($args) {
        $id = variable_get($args['id']);
        $page = absint($args['page']);
        $page = $page < 1 ? 1 : $page;
        $page_size = absint($args['pageSize']);
        $page_size = $page_size < 1 ? 20 : $page_size;
        $presales = M('presales p')
            ->join('LEFT JOIN __COUNTRY__ co ON co.country_id=p.country_id')
            ->join('LEFT JOIN __CITY__ ci ON ci.city_id=p.city_id')
            ->field('p.presale_id AS id, p.type, p.name_'.$this->lang.' AS name, p.type, p.floor_'.$this->lang.' AS floor, p.room_'.$this->lang.' AS room, p.layout_'.$this->lang.' AS layout, p.area_'.$this->lang.' AS area, p.balcony_area_'.$this->lang.' AS balcony_area, p.price_'.$this->lang.' AS price, co.name_'.$this->lang.' AS country_name, ci.name_'.$this->lang.' AS city_name')
            ->where(['p.status' => 1, 'co.country_id' => $id])
            ->order('p.sort DESC,p.presale_id DESC')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($presales) {
            $m_media = M('media');
            foreach ($presales as $k => $v) {
                $cover = $m_media
                    ->where(['source_id' => $v['id'], 'type' => 1, 'mtype' => '8', 'status' => 1])
                    ->field('file')
                    ->order('sort ASC')
                    ->limit(1, 1)
                    ->select();
                $presales[$k]['cover'] = get_oss_image($cover ? $cover[0]['file'] : '', 492, 440);
                $presales[$k]['id'] = variable_set('presale.id', $v['id']);
                $presales[$k]['type'] = C('ENUM.PRESALE_TYPE_'.strtoupper($this->lang))[$v['type']];
            }
        }

        return $presales;
    }

    /**
     * City->index
     * @param $args
     * @return array
     */
    private function cityIndex($args) {
        $id = variable_get($args['id']);

        $city = M('city ci')
            ->join('LEFT JOIN __COUNTRY__ co ON co.country_id=ci.country_id')
            ->field('ci.*,co.name_'.$this->lang.' AS country_name,co.country_id,co.currency_'.$this->lang.' AS currency,co.exchange_rate_'.$this->lang.' AS exchange_rate')
            ->where(['ci.status' => 1, 'ci.city_id' => $id])
            ->find();

        if (!$city)      E('数据不存在！');

        $data = [];
        $info['name'] = $city['name_'.$this->lang];
        $info['abbr'] = $city['abbr'];
        $info['area'] = $city['area_'.$this->lang];
        $info['climate'] = htmlspecialchars_decode($city['climate_'.$this->lang], ENT_QUOTES);
        $info['feature'] = htmlspecialchars_decode($city['feature_'.$this->lang], ENT_QUOTES);
        $info['building_intro'] = htmlspecialchars_decode($city['building_intro_'.$this->lang], ENT_QUOTES);
        $info['livable_rank'] = $city['livable_rank'];
        $info['cover'] = $city['cover'] ? C('FILES_SERVER').$city['cover'] : '';
        $info['is_hot'] = $city['is_hot'];
        $info['country_name'] = $city['country_name'];
        $info['country_id'] = variable_set('country.id', $city['country_id']);
        $info['currency'] = $city['currency'];
        $info['exchange_rate'] = $city['exchange_rate'];


        $school = M('school')
            ->where(['status' => 1, 'city_id' => $id])
            ->getField('name_'.$this->lang, true);
        $info['school'] = $school;
        $data['info'] = $info;
        $data['banner'] = $this->getBanner(2, $id);

        return $data;
    }

    /**
     * City->buildings
     * @param $args
     * @return mixed
     */
    private function cityBuildings($args) {
        $id = variable_get($args['id']);
        $page = absint($args['page']);
        $page = $page < 1 ? 1 : $page;
        $page_size = absint($args['pageSize']);
        $page_size = $page_size < 1 ? 20 : $page_size;
        $buildings = M('buildings b')
            ->join('LEFT JOIN __COUNTRY__ co ON co.country_id=b.country_id')
            ->join('LEFT JOIN __CITY__ ci ON ci.city_id=b.city_id')
            ->field('b.building_id AS id, b.name_'.$this->lang.' AS name, co.name_'.$this->lang.' AS country_name, ci.name_'.$this->lang.' AS city_name')
            ->where(['b.status' => 1, 'b.city_id' => $id])
            ->order('b.sort DESC,b.building_id DESC')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($buildings) {
            $m_apartment = M('buildings_apartment');
            $m_media = M('media');
            $m_tags = M('common_tags');
            foreach ($buildings as $k => $v) {
                $buildings[$k]['location'] = $v['country_name'].'·'.$v['city_name'];
                $buildings[$k]['tag'] = $m_tags->where(['type' => 1, 'source_id' => $v['id'], 'status' => 1])->order('tag_id ASC')->getField('name_'.$this->lang);
                $min_price = $m_apartment
                    ->where(['building_id' => $v['id'], 'status' => 1])
//                    ->order('price_'.$this->lang.' ASC')
                    ->getField('price_'.$this->lang);
//                $max_price = $m_apartment
//                    ->where(['building_id' => $v['id'], 'status' => 1])
//                    ->order('price_'.$this->lang.' DESC')
//                    ->getField('price_'.$this->lang);
                $buildings[$k]['price'] = $min_price;
                $cover = $m_media
                    ->where(['source_id' => $v['id'], 'type' => 1, 'mtype' => '3', 'status' => 1])
                    ->order('sort ASC')
                    ->getField('file');
                $buildings[$k]['cover'] = get_oss_image($cover, 492, 440);
                $buildings[$k]['id'] = variable_set('building.id', $v['id']);
            }
        }

        return $buildings;
    }

    /**
     * City->presales
     * @param $args
     * @return mixed
     */
    private function cityPresales($args) {
        $id = variable_get($args['id']);
        $page = absint($args['page']);
        $page = $page < 1 ? 1 : $page;
        $page_size = absint($args['pageSize']);
        $page_size = $page_size < 1 ? 20 : $page_size;
        $presales = M('presales p')
            ->join('LEFT JOIN __COUNTRY__ co ON co.country_id=p.country_id')
            ->join('LEFT JOIN __CITY__ ci ON ci.city_id=p.city_id')
            ->field('p.presale_id AS id, p.type, p.name_'.$this->lang.' AS name, p.type, p.floor_'.$this->lang.' AS floor, p.room_'.$this->lang.' AS room, p.layout_'.$this->lang.' AS layout, p.area_'.$this->lang.' AS area, p.balcony_area_'.$this->lang.' AS balcony_area, p.price_'.$this->lang.' AS price, co.name_'.$this->lang.' AS country_name, ci.name_'.$this->lang.' AS city_name')
            ->where(['p.status' => 1, 'p.city_id' => $id])
            ->order('p.sort DESC,p.presale_id DESC')
            ->limit(($page - 1) * $page_size, $page_size)
            ->select();
        if ($presales) {
            $m_media = M('media');
            foreach ($presales as $k => $v) {
                $cover = $m_media
                    ->where(['source_id' => $v['id'], 'type' => 1, 'mtype' => '8', 'status' => 1])
                    ->field('file')
                    ->order('sort ASC')
                    ->limit(1, 1)
                    ->select();
                $presales[$k]['cover'] = get_oss_image($cover ? $cover[0]['file'] : '', 492, 440);
                $presales[$k]['id'] = variable_set('presale.id', $v['id']);
                $presales[$k]['type'] = C('ENUM.PRESALE_TYPE_'.strtoupper($this->lang))[$v['type']];
            }
        }

        return $presales;
    }

    /**
     * Building->index
     * @param $args
     * @return array
     */
    private function buildingIndex($args) {
        $id = variable_get($args['id']);

        $building = M('buildings b')
            ->join('LEFT JOIN __COUNTRY__ co ON co.country_id=b.country_id')
            ->join('LEFT JOIN __CITY__ ci ON ci.city_id=b.city_id')
            ->field('b.*,co.name_'.$this->lang.' AS country_name,co.country_id,co.lending_rate AS lending_rate,ci.name_'.$this->lang.' AS city_name,ci.city_id')
            ->where(['b.status' => 1, 'b.building_id' => $id])
            ->find();

        if (!$building)      E('数据不存在！');

        $data = [];

        //楼盘信息
        $info['name'] = $building['name_'.$this->lang];
        $info['location'] = $building['country_name'].'·'.$building['city_name'].'·'.$building['address_'.$this->lang];
        $info['delivery_time'] = $building['delivery_time_'.$this->lang];
        $info['property_years'] = intval($building['property_years']);
        $info['project_status'] = C('ENUM.PROJECT_STATUS_'.strtoupper($this->lang))[$building['project_status']];
        $info['loans'] = htmlspecialchars_decode($building['loans_'.$this->lang], ENT_QUOTES);
        $info['lending_rate'] = $building['lending_rate'];
        $info['is_hot'] = $building['is_hot'];
        $info['payment_ratio'] = 35;
        $info['country_name'] = $building['country_name'];
        $info['country_id'] = variable_set('country_id', $building['country_id']);
        $info['city_name'] = $building['city_name'];
        $info['city_id'] = variable_set('city_id', $building['city_id']);

        //pdf
        $pdf = $media = M('media')
            ->where(['mtype' => $this->lang == 'cn' ? 5 : 6, 'status' => 1, 'source_id' => $id])
            ->order('sort ASC, media_id ASC')
            ->getField('file');
        $info['pdf']  = $pdf ? C('FILES_SERVER').$pdf : '';


        $data['info'] = $info;

        //banner
        $data['banner'] = $this->getBanner(3, $id);

        //经纪人
        $broker = M('brokers')
            ->where(['status' => 1, 'broker_id' => $building['broker_id']])
            ->field('name_'.$this->lang.' AS name,certificate_'.$this->lang.' AS certificate,languages_'.$this->lang.' AS languages,experience_'.$this->lang.' AS experience,education_'.$this->lang.' AS education,avatar,birthday,tel')
            ->find();
        $broker['age'] = $broker['birthday'] ? ceil((time() - strtotime($broker['birthday'])) / (86400*365)) : 0;
        //隐藏年龄
        $broker['age'] = 0;

        unset($broker['birthday']);
        $broker['avatar'] = $broker['avatar'] ? C('FILES_SERVER').$broker['avatar'] : '';
        $data['broker'] = $broker;

        //房型
        $apartments = M('buildings_apartment')
            ->where(['status' => 1, 'building_id' => $id])
            ->order('aid ASC')
            ->field('name_'.$this->lang.' AS name,area_'.$this->lang.' AS area,price_'.$this->lang.' AS price')
            ->select();
        $data['apartments'] = $apartments;

        //标签
        $tags = [];
        $tag_page = 1;
        while (true) {
            $tag_list = M('common_tags')
                ->where(['status' => 1, 'type' => 1, 'source_id' => $id])
                ->order('tag_id ASC')
                ->field('name_'.$this->lang.' AS name, intro_'.$this->lang.' AS intro, icon')
                ->limit((($tag_page - 1) * 4).',4')
                ->select();
            if (!$tag_list)     break;
            $tag_page++;

            foreach ($tag_list as $k => $v) {
                if ($k == 0) {
                    $tag_list[$k]['active'] = 'active';
                }
                $tag_list[$k]['icon'] = $v['icon'] ? C('FILES_SERVER').$v['icon'] : '';
            }
            $tags[] = $tag_list;
        }

        $data['tags'] = $tags;

        //购房流程
        $media = M('media')
            ->where(['mtype' => 4, 'status' => 1, 'source_id' => $id])
            ->field('type,mtype,link_type,link_url,file')
            ->order('sort ASC, media_id ASC')
            ->select();
        $process = [];
        if ($media) {
            $link_type_arr = [
                '0' => '',
                '1' => 'country',
                '2' => 'city',
                '3' => 'building',
            ];
            foreach ($media as $k => $v) {
                $target_id = '';
                if ($v['link_type'] == 1) {
                    $target_id = variable_set('country.id', $v['link_url']);
                } else if ($v['link_type'] == 2) {
                    $target_id = variable_set('city.id', $v['link_url']);
                } else if ($v['link_type'] == 3) {
                    $target_id = variable_set('building.id', $v['link_url']);
                }
                $process[] = [
                    'type' => $v['type'],
                    'file' => C('FILES_SERVER').$v['file'],
                    'target' => $link_type_arr[$v['link_type']],
                    'targetId' => $target_id
                ];
            }
        }
        $data['process'] = $process;

        $data['loan_year'] = $this->getLoanYear();

        return $data;
    }

    /**
     * Presale->index
     * @param $args
     * @return array
     */
    private function presaleIndex($args) {
        $id = variable_get($args['id']);

        $presale = M('presales p')
            ->join('LEFT JOIN __COUNTRY__ co ON co.country_id=p.country_id')
            ->join('LEFT JOIN __CITY__ ci ON ci.city_id=p.city_id')
            ->field('p.*,co.name_'.$this->lang.' AS country_name,co.country_id,co.lending_rate AS lending_rate,ci.name_'.$this->lang.' AS city_name,ci.city_id')
            ->where(['p.status' => 1, 'p.presale_id' => $id])
            ->find();

        if (!$presale)      E('数据不存在！');

        $data = [];

        //楼盘信息
        $info['name'] = $presale['name_'.$this->lang];
        $info['location'] = $presale['country_name'].'·'.$presale['city_name'].'·'.$presale['address_'.$this->lang];
        $info['delivery_time'] = $presale['delivery_time_'.$this->lang];
        $info['property_years'] = intval($presale['property_years']);
        $info['project_status'] = C('ENUM.PROJECT_STATUS_'.strtoupper($this->lang))[$presale['project_status']];
        $info['type'] = C('ENUM.PRESALE_TYPE_'.strtoupper($this->lang))[$presale['type']];
        $info['floor'] = $presale['floor_'.$this->lang];
        $info['area'] = $presale['area_'.$this->lang];
        $info['balcony_area'] = $presale['balcony_'.$this->lang];
        $info['room'] = $presale['room_'.$this->lang];
        $info['price'] = $presale['price_'.$this->lang];
        $info['layout'] = $presale['layout_'.$this->lang];
        $info['lending_rate'] = $presale['lending_rate'];
        $info['is_hot'] = $presale['is_hot'];
        $info['payment_ratio'] = 35;
        $info['country_name'] = $presale['country_name'];
        $info['country_id'] = variable_set('country_id', $presale['country_id']);
        $info['city_name'] = $presale['city_name'];
        $info['city_id'] = variable_set('city_id', $presale['city_id']);

        $data['info'] = $info;

        //banner
        $data['banner'] = $this->getBanner(8, $id);

        //经纪人
        $broker = M('brokers')
            ->where(['status' => 1, 'broker_id' => $presale['broker_id']])
            ->field('name_'.$this->lang.' AS name,certificate_'.$this->lang.' AS certificate,languages_'.$this->lang.' AS languages,experience_'.$this->lang.' AS experience,education_'.$this->lang.' AS education,avatar,birthday,tel')
            ->find();
        $broker['age'] = $broker['birthday'] ? ceil((time() - strtotime($broker['birthday'])) / (86400*365)) : 0;
        //隐藏年龄
        $broker['age'] = 0;
        unset($broker['birthday']);
        $broker['avatar'] = $broker['avatar'] ? C('FILES_SERVER').$broker['avatar'] : '';
        $data['broker'] = $broker;

        //标签
        $tags = [];
        $tag_page = 1;
        while (true) {
            $tag_list = M('common_tags')
                ->where(['status' => 1, 'type' => 2, 'source_id' => $id])
                ->order('tag_id ASC')
                ->field('name_'.$this->lang.' AS name, intro_'.$this->lang.' AS intro, icon')
                ->limit((($tag_page - 1) * 4).',4')
                ->select();
            if (!$tag_list)     break;
            $tag_page++;

            foreach ($tag_list as $k => $v) {
                if ($k == 0) {
                    $tag_list[$k]['active'] = 'active';
                }
                $tag_list[$k]['icon'] = $v['icon'] ? C('FILES_SERVER').$v['icon'] : '';
            }
            $tags[] = $tag_list;
        }

        $data['tags'] = $tags;

        //交易流程
        $media = M('media')
            ->where(['mtype' => 9, 'status' => 1, 'source_id' => $id])
            ->field('type,mtype,link_type,link_url,file')
            ->order('sort ASC, media_id ASC')
            ->select();
        $process = [];
        if ($media) {
            $link_type_arr = [
                '0' => '',
                '1' => 'country',
                '2' => 'city',
                '3' => 'building',
            ];
            foreach ($media as $k => $v) {
                $target_id = '';
                if ($v['link_type'] == 1) {
                    $target_id = variable_set('country.id', $v['link_url']);
                } else if ($v['link_type'] == 2) {
                    $target_id = variable_set('city.id', $v['link_url']);
                } else if ($v['link_type'] == 3) {
                    $target_id = variable_set('building.id', $v['link_url']);
                }
                $process[] = [
                    'type' => $v['type'],
                    'file' => C('FILES_SERVER').$v['file'],
                    'target' => $link_type_arr[$v['link_type']],
                    'targetId' => $target_id
                ];
            }
        }
        $data['process'] = $process;

        $data['loan_year'] = $this->getLoanYear();

        return $data;
    }

    /**
     * @TODO 轮播图
     * @param $mtype
     * @param $souce_id
     * @return array
     */
    private function getBanner($mtype, $souce_id) {
        $media = M('media')
            ->where(['mtype' => $mtype, 'status' => 1, 'source_id' => $souce_id])
            ->field('type,mtype,link_type,link_url,file')
            ->order('sort ASC, media_id ASC')
            ->select();
        $banner = [];
        if ($media) {
            $link_type_arr = [
                '0' => '',
                '1' => 'country',
                '2' => 'city',
                '3' => 'building',
                '4' => 'presale',
            ];
            foreach ($media as $k => $v) {
                $target_id = '';
                if ($v['link_type'] == 1) {
                    $target_id = variable_set('country.id', $v['link_url']);
                } else if ($v['link_type'] == 2) {
                    $target_id = variable_set('city.id', $v['link_url']);
                } else if ($v['link_type'] == 3) {
                    $target_id = variable_set('building.id', $v['link_url']);
                } else if ($v['link_type'] == 4) {
                    $target_id = variable_set('presale.id', $v['link_url']);
                }
                $banner[] = [
                    'type' => $v['type'],
                    'file' => C('FILES_SERVER').$v['file'],
                    'target' => $link_type_arr[$v['link_type']],
                    'targetId' => $target_id
                ];
            }
        }
        return $banner;
    }

    /**
     * @TODO 获取贷款年限
     * @return array
     */
    private function getLoanYear() {
        $data = [];
        $lang_year = M('common_lang')->where(['lkey' => 'YEAR'])->getField($this->lang);
        for ($i = 1; $i <= 30; $i++) {
            $data[] = [
                'name' => $i.$lang_year,
                'year' => $i
            ];
        }
        return $data;
    }

}
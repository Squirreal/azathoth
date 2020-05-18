<?php
/**
 * Home
 */
namespace Home\Controller;

class IndexController extends BaseController {
    private static $TAG = 'home';

    public function __construct() {
        parent::__construct();

        $this->data['body_class'] = 'home';
        $this->data['js_module'] = 'home';
    }

    public function index() {
        $data = $this->weblogic->service(self::$TAG.'.index', []);

        $data['keywords'] = "squirreal,海外房产,海外投资,海外买房,海外买房移民,买房移民,资产增值,资产回报,资产保值增值率,资产回报率";
        $data['description'] = "松鼠国际房产(www.squirreal.cn)是一个精品国际房地产资产配置平台, 为您提供最专业, 最优质的服务。";
        $this->data = array_merge($this->data, $data);

        //热门楼盘
        $this->data['hot_buildings'] = $this
            ->weblogic
            ->service(self::$TAG.'.hotBuildings', []);

        //楼花转让
        $this->data['presales'] = $this
            ->weblogic
            ->service(
                self::$TAG.'.presales',
                [
                    'pageSize' => 8
                ]
            );

//        print_r($this->data);

        $this->assign('data', $this->data);
        $this->display(__FUNCTION__);
    }
}
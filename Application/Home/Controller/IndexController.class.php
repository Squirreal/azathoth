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
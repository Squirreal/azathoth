<?php

namespace Api\Controller;

class HomeController extends BaseController {
    private static $TAG = 'home';

    public function __construct() {
        parent::__construct();
    }

    /**
     * @TODO 获取首页banner，热门国家，热门城市
     */
    public function index() {
        $this->response = [
            'status' => 'y',
            'data' => $this->weblogic->service(self::$TAG.'.'.__FUNCTION__)
        ];
        $this->sendResponse();
    }

    /**
     * @TODO 热门楼盘
     */
    public function hotBuildings() {
        $this->response = [
            'status' => 'y',
            'data' => $this->weblogic->service(self::$TAG.'.'.__FUNCTION__, ['page' => absint(I('post.page'))])
        ];

        $this->sendResponse();
    }
}
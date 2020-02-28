<?php

namespace Api\Controller;

class CityController extends BaseController {
    private static $TAG = 'city';

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->response = [
            'status' => 'y',
            'data' => $this->weblogic->service(self::$TAG.'.'.__FUNCTION__, ['id' => I('post.id')])
        ];
        $this->sendResponse();
    }

    /**
     * 合作楼盘
     */
    public function buildings() {
        $this->response = [
            'status' => 'y',
            'data' => $this
                ->weblogic
                ->service(
                    self::$TAG.'.'.__FUNCTION__,
                    [
                        'id' => I('post.id'),
                        'page' => I('post.page'),
                        'pageSize' => I('post.pageSize'),
                    ]
                )
        ];

        $this->sendResponse();
    }

    /**
     * 楼花列表
     */
    public function presales() {
        $this->response = [
            'status' => 'y',
            'data' => $this
                ->weblogic
                ->service(
                    self::$TAG.'.'.__FUNCTION__,
                    [
                        'id' => I('post.id'),
                        'page' => I('post.page'),
                        'pageSize' => I('post.pageSize'),
                    ]
                )
        ];

        $this->sendResponse();
    }
}
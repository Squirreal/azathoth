<?php

namespace Api\Controller;

class CountryController extends BaseController {
    private static $TAG = 'country';

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
}
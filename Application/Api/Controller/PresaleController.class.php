<?php

namespace Api\Controller;

class PresaleController extends BaseController {
    private static $TAG = 'presale';

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
}
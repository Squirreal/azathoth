<?php

namespace Api\Controller;

class UserController extends BaseController {

    public function __construct() {
        parent::__construct();

        $this->checkLogin();
    }

    public function index() {
        $this->sendResponse();
    }

    public function getInfo() {
        $this->response = [
            'status' => 'y',
            'data' => [
                'nickname' => $this->userinfo['nickname'],
                'avatar' => $this->userinfo['avatar'],
            ]
        ];
        $this->sendResponse();
    }
}
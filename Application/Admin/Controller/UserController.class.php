<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Admin\Controller;

class UserController extends BaseController {

    public function __construct() {
        parent::__construct();

        $this->checkLogin();
    }

    public function index() {

        $this->sendResponse();
    }

    public function getInfo() {
        $privileges = $this->userinfo['privileges'];
        $privileges[] = 'Home';
        $this->response = array('status' => 'y', 'data' => array(
            'username' => $this->userinfo['username'],
            'nickname' => $this->userinfo['name'],
            'avatar' => $this->userinfo['avatar'],
            'roles' => $privileges
        ));
        $this->sendResponse();
    }

    public function getStatistics() {
        $data['countryCount'] = intval(M('country')->where(['status' => 1])->count());
        $data['cityCount'] = intval(M('city')->where(['status' => 1])->count());
        $data['buildingsCount'] = intval(M('buildings')->where(['status' => 1])->count());
        $data['brokersCount'] = intval(M('brokers')->where(['status' => 1])->count());
        $data['customerCount'] = intval(M('users')->where(['status' => 1])->count());
        $data['presalesCount'] = intval(M('presales')->where(['status' => 1])->count());

        $this->response = ['status' => 'y', 'data' => $data];

        $this->sendResponse();
    }
}
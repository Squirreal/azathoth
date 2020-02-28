<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Admin\Controller;

class CommonController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 获取全局变量
     */
    public function constants() {
        $data = ['PROJECT_STATUS' => []];
        foreach (C('ENUM.PROJECT_STATUS_CN') as $k => $v) {
            $data['PROJECT_STATUS'][] = ['title' => $v, 'value' => (string)$k];
        }

        $this->response = ['status' => 'y', 'data' => $data];
        $this->sendResponse();
    }
}
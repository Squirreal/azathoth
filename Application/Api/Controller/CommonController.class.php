<?php
/**
 * User: chrisz
 * Date: 2019/5/26
 * Time: 14:31
 */

namespace Api\Controller;

class CommonController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 获取全局变量
     */
    public function constants() {
        $data = [];

        $this->response = ['status' => 'y', 'data' => $data];
        $this->sendResponse();
    }

    /**
     * 语言
     */
    public function lang() {
        $data = [];

        $lang = M('common_lang')
            ->field('lkey,'.$this->lang)
            ->where(['status' => 1])
            ->order('lkey ASC')
            ->select();
        if ($lang) {
            foreach ($lang as $k => $v) {
                $data[$v['lkey']] = $v[$this->lang];
            }
        }

        $this->response = ['status' => 'y', 'data' => $data];
        $this->sendResponse();
    }
}
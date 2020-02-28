<?php
/**
 * Page
 */
namespace Home\Controller;

class PageController extends BaseController {

    public function __construct() {
        parent::__construct();

        $this->data['body_class'] = 'page';
    }

    /**
     * 关于我们
     */
    public function about() {

        $this->setTitle($this->data['lang']['ABOUT_US']);
        $this->assign('data', $this->data);
        $this->display(__FUNCTION__);
    }

    /**
     * 用户协议
     */
    public function agreement() {

        $this->setTitle($this->data['lang']['AGREEMENT']);
        $this->assign('data', $this->data);
        $this->display(__FUNCTION__);
    }

    /**
     * 法律声明和隐私政策
     */
    public function privacy() {

        $this->setTitle($this->data['lang']['PRIVACY']);
        $this->assign('data', $this->data);
        $this->display(__FUNCTION__);
    }
}
<?php

/**
 * Base
 */

namespace Home\Controller;
use Think\Controller;

abstract class BaseController extends Controller {
    protected $data = [];
    protected $lang = 'en';
    protected $weblogic;

	public function __construct() {
		parent::__construct();

		$this->lang = $this->getLang();

		$this->data['lang'] = $this->getLangSettings();
		$this->data['current_lang'] = $this->lang;
        $this->data['current_lang_name'] = C('ENUM.LANG')[strtolower($this->lang)];
        $this->data['title'] = $this->data['lang']['SQUIRREAL'];
        $this->data['keywords'] = $this->data['lang']['PROGRAM_INTRO'];
        $this->data['description'] = $this->data['lang']['WEBSITE_FEATURE'];
        $this->data['userinfo'] = session('userinfo');
        if ($this->isMobile()) {
            $this->data['css'] = ['style_m.css'];
            $this->data['js'] = ['fastclick.min.js', 'layer.m.js','functions_m.js'];
        } else {
            $this->data['css'] = ['style.css'];
            $this->data['js'] = ['functions.js'];
        }

        $this->weblogic = D('Weblogic');
        $this->weblogic->setLang($this->lang);
	}

    /**
     * @TODO set title
     * @param $title
     * @return string
     */
    final protected function setTitle($title) {
         $this->data['title'] = $title.' - '.$this->data['title'];
        //return $this->data['title'];
    }

	private function getLang() {
        if (I('get.lang') && in_array(I('get.lang'), array_keys(C('ENUM.LANG')))) {
            return I('get.lang');
        }

        $lang = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        if ($lang && strpos($lang[0], 'zh') === 0) {
            return 'cn';
        } else {
            return 'en';
        }
    }

    /**
     * @return array
     */
    private function getLangSettings() {
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
        return $data;
    }

    /**
     * @return bool
     */
    private function isMobile() {
        if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
            $is_mobile = false;
        } elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
            $is_mobile = false;
        } elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }
        return $is_mobile;
    }

    /**
     * @param string $tpl
     * @return string
     */
    protected function display($tpl) {
        if ($this->isMobile()) {
            $tpl .= '_m';
        }
        parent::display($tpl);
    }
}

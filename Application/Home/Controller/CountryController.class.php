<?php
/**
 * Country
 */
namespace Home\Controller;

class CountryController extends BaseController {
    private static $TAG = 'country';

    public function __construct() {
        parent::__construct();

        $this->data['body_class'] = 'country';
        $this->data['js_module'] = 'country';
    }

    public function index() {
        $id = I('get.id');
        $data = $this->weblogic->service(self::$TAG.'.'.__FUNCTION__, ['id' => $id]);
        $data['keywords'] = "{$data['info']['name']}房产,{$data['info']['name']}投资,{$data['info']['name']}买房,{$data['info']['name']}买房移民";
        $data['description'] = "松鼠国际房产(www.squirreal.cn)是一个精品国际房地产资产配置平台, 为您提供最专业, 最优质的服务。";
        if ($data['banner']) {
            $banner_video = '';
            $banner_images = [];
            foreach ($data['banner'] as $k => $v) {
                if ($v['type'] == 1) {
                    $banner_images[] = $v;
                } else if ($v['type'] == 2) {
                    $banner_video = $v['file'];
                }
            }
            $data['banner_video'] = $banner_video;
            $data['banner_images'] = $banner_images;
        }
        $this->data = array_merge($this->data, $data);
        $this->data['buildings'] = $this
            ->weblogic
            ->service(
                self::$TAG.'.buildings',
                [
                    'id' => $id,
                    'page' => 1
                ]
            );

        //楼花转让
        $this->data['presales'] = $this
            ->weblogic
            ->service(
                self::$TAG.'.presales',
                [
                    'id' => $id,
                    'pageSize' => 8
                ]
            );

        $this->data['id'] = $id;


//        print_r($this->data);
        $this->data['shareUrl'] = 'type=country&id='.$id;
        $this->setTitle($this->data['info']['name']);
        $this->assign('data', $this->data);
        $this->display(__FUNCTION__);
    }
}
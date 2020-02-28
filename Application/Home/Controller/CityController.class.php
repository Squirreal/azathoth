<?php
/**
 * City
 */
namespace Home\Controller;

class CityController extends BaseController {
    private static $TAG = 'city';

    public function __construct() {
        parent::__construct();

        $this->data['body_class'] = 'city';
        $this->data['js_module'] = 'city';
    }

    public function index() {
        $id = I('get.id');
        $data = $this->weblogic->service(self::$TAG.'.'.__FUNCTION__, ['id' => $id]);
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
        $this->data['presales'] = $this
            ->weblogic
            ->service(
                self::$TAG.'.presales',
                [
                    'id' => $id,
                    'pageSize' => 5
                ]
            );
        $this->data['id'] = $id;

//        print_r($this->data);

        $this->data['shareUrl'] = 'type=city&id='.$id;
        $this->setTitle($this->data['info']['name']);
        $this->assign('data', $this->data);
        $this->display(__FUNCTION__);
    }

    public function presales() {
        $id = I('get.id');
        $page = absint(I('post.p'));
        $page = $page < 1 ? 1 : $page;
        $page_size = 20;

        $data = $this->weblogic->service(self::$TAG.'.index', ['id' => $id]);
        $this->data = array_merge($this->data, $data);
        $this->data['presales'] = $this->weblogic->service(self::$TAG.'.'.__FUNCTION__, ['id' => $id, 'page' => $page, 'pageSize' => $page_size]);

        $total = M('presales')->where(['city_id' => $id, 'status' => 1])->count();
        $_page = new \Org\Util\Page($total, $page_size);
        $this->data['pager'] = $_page->show();

        $this->data['shareUrl'] = 'type=presales&id='.$id;
        $this->data['css'][] = 'vendor/font-awesome/css/font-awesome.min.css';
        $this->setTitle($this->data['lang']['PRESALES_LIST']);
        $this->assign('data', $this->data);
        $this->display(__FUNCTION__);
    }

    public function buildings() {
        $id = I('get.id');
        $page = absint(I('post.p'));
        $page = $page < 1 ? 1 : $page;
        $page_size = 20;

        $data = $this->weblogic->service(self::$TAG.'.index', ['id' => $id]);
        $this->data = array_merge($this->data, $data);
        $this->data['buildings'] = $this->weblogic->service(self::$TAG.'.'.__FUNCTION__, ['id' => $id, 'page' => $page, 'pageSize' => $page_size]);
        $this->data['id'] = $id;

        $total = M('buildings')->where(['city_id' => $id, 'status' => 1])->count();
        $_page = new \Org\Util\Page($total, $page_size);
        $this->data['pager'] = $_page->show();

        $this->data['shareUrl'] = 'type=cityBuildings&id='.$id;
        $this->data['css'][] = 'vendor/font-awesome/css/font-awesome.min.css';
        $this->setTitle($this->data['lang']['RELATED_BUILDINGS']);
        $this->assign('data', $this->data);
        $this->display(__FUNCTION__);
    }
}
<?php
/**
 * Building
 */
namespace Home\Controller;

class BuildingController extends BaseController {
    private static $TAG = 'building';

    public function __construct() {
        parent::__construct();

        $this->data['body_class'] = 'building';
        $this->data['js_module'] = 'building';
        $this->data['css'][] = 'smartphoto.min.css';
        $this->data['js'][] = 'jquery-smartphoto.min.js';
    }

    public function index() {
        if (I('post.calc')) {
            $response = ['status' => 'n'];

            try {
                $amount = absint(I('post.amount'));
                $year = absint(I('post.year'));
                $payment_ratio = absint(I('post.paymentRatio'));
                $rate = abs(floatval(I('post.rate')));

                if ($amount == 0)               E($this->data['lang']['PLEASE_ENTER_PURCHASE_AMOUNT']);
                if ($payment_ratio == 0)        E($this->data['lang']['PLEASE_ENTER_PAYMENT_RATIO']);
                if ($rate == 0)                 E($this->data['lang']['PLEASE_ENTER_INTEREST_RATE']);

                //贷款金额
                $loan_amount = $amount - $amount * $payment_ratio * 0.01;

                //月利率
                $monthly_rate = $rate * 0.01 / 12;

                //月
                $month = $year * 12;

                //月还款
                //每月应还利息=贷款本金×月利率×〔(1+月利率)^还款月数-(1+月利率)^(还款月序号-1)〕÷〔(1+月利率)^还款月数-1〕
                $monthly_payment = ($loan_amount * $monthly_rate * pow((1 + $monthly_rate), $month)) / (pow((1 + $monthly_rate), $month) - 1);

                $response = [
                    'status' => 'y',
                    'data' => [
                        'loanAmount' => amount_format($loan_amount),
                        'monthlyPayment' => amount_format(round($monthly_payment)),
                        'yearlyPayment' => amount_format(round($monthly_payment * 12)),
                    ]
                ];

            } catch (\Think\Exception $e) {
                $response['msg'] = $e->getMessage();
            }

            send_json($response);
        }

        $id = I('get.id');
        $this->data['id'] = $id;
        $data = $this->weblogic->service(self::$TAG.'.'.__FUNCTION__, ['id' => $id]);

        $data['keywords'] = "{$data['info']['name']}项目";

        foreach ($data['tags'][0] as $k => $v) {
            $data['keywords'] .= ",".$v['name'];
        }
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

//        print_r($this->data);

        $this->data['shareUrl'] = 'type=building&id='.$id;
        $this->setTitle($this->data['info']['name']);
        $this->assign('data', $this->data);
        $this->display(__FUNCTION__);
    }
}
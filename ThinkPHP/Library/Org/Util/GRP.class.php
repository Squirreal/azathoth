<?php
/**
 * 集团接口
 * User: chrisz
 * Date: 2019/8/8
 * Time: 13:03
 */

namespace Org\Util;

class GRP {
    private static $jwtToken = null;

    const HOST = [
        'sandbox' => 'http://svc-gateway.sit.noahgrouptest.com/',
        'prod' => 'http://svc-gateway.i.noahgroup.com/',
    ];

    const GATEWAY_USER = [
        'sandbox' => ['wna-nccp-mid', '6WUH9RZk/XezcUQc/yPukw=='],
        'prod' => ['ques_zuul', 'ciRocVSpgvRjRrzRSWf6WxthxBxgL+XO15ytytVDZZQ='],
    ];

    const REMOTE_URL = [
        'accessToken' => 'api/login',
        'queryGroupNumByMobile' => 'nccp-api/api/cust/account/info/bymobile/fullQuery_if',
    ];

    public function __construct() {
        self::accessToken();
    }

    /**
     * @desc 获取网关token
     */
    public static function accessToken () {
        if (self::$jwtToken !== null) {
            return self::$jwtToken;
        }

        $key = 'NoahJwtToken';
        if (apcu_exists($key)) {
            self::$jwtToken = apcu_fetch($key);
        } else {
            $result = self::_request([
                "username" => self::GATEWAY_USER[ENV][0],
                "password" => self::GATEWAY_USER[ENV][1],
            ], __FUNCTION__);
            self::$jwtToken = $result['data'] ?? '';
            if (!empty(self::$jwtToken)) {
                apcu_add($key, self::$jwtToken, 3000);
            }
        }
        return self::$jwtToken;
    }

    /**
     * 根据手机号码获取集团号
     * @param string $mobile 非加密明文手机号
     * @return array boolean
     */
    public function queryGroupNumByMobile($mobile = '') {
		$mobile = kmsHandle($mobile, 'encrypt', 'nccp');
        return self::_request([
            "mobilePhone" => $mobile,
        ], __FUNCTION__);
    }

    /**
     * @desc 远程请求处理
     * @param array $params
     * @param string $func
     * @return mixed
     */
    private static function _request ($params = [], $func = '') {
        $curl = curl_init();
        $header = [
            'Content-type:application/json;charset=utf-8',
            'Authorization:'.self::$jwtToken,
        ];
        curl_setopt($curl, CURLOPT_URL, self::HOST[ENV] . self::REMOTE_URL[$func]);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT_MS,3000);
        $output = curl_exec($curl);
        curl_close($curl);

        return json_decode($output, true);
    }
}
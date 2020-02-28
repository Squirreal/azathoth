<?php

/**
 * Weixin
 */

namespace Common\Model;

class WeixinModel {
	private $wx_appid = '';
	private $wx_secret = '';
	private $access_token = '';
	const API_HOST = 'https://api.weixin.qq.com';
	const MEDIA_HOST = 'http://file.api.weixin.qq.com';
	const TOKEN_LIFE_TIME = 3600;
	public $http = null;
	public $json = null;

	public function __construct() {
		$this->wx_appid = C('WEIXIN.app_id');
		$this->wx_secret = C('WEIXIN.app_secret');
		
		$this->http = new \Org\Util\Http();
		$this->json = new \Org\Util\Json();

		$this->getAccessToken();
	}

    /**
     * 获取token
     * @return mixed
     */
    public function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents(DATA_PATH . "/access_token.json"));
        if ($data->expire_time < time()) {
            // 如果是企业号用以下URL获取access_token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->wx_appid&secret=$this->wx_secret";
            $res = json_decode($this->http->request($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen(DATA_PATH . "/access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data->access_token;
        }
        $this->access_token = $access_token;
        return $access_token;
    }
	
	/**
	 * 
	 * @param type $params
	 * @return type
	 */
	public function message($params){
		$response = $this->sendRequest('message/send', 'post', $params);
		$response = @$this->json->decode($response);
		if(isset($response->errcode) && $response->errcode === 0){
			return array('status' => 'y');
		}else{
			return array('status' => 'n', 'msg' => "微信操作失败 ".$this->json->encode($response));
		}
	}
	
	/**
	 * media
	 * @param type $act
	 * @param type $params
	 */
	public function media($act, $params = array()){
		if($act == 'download'){
			$request_url = self::MEDIA_HOST.'/cgi-bin/media/get?access_token='.$this->access_token.'&media_id='.$params['serverId'];
			$headers = get_headers($request_url, 1);
			
			if(strpos($headers['Content-Type'], 'image') === 0 && $headers['Content-Length'] > 0){
				$filename = substr(md5(md5($params['serverId'].microtime())), 8, 16).'.jpg';
				$upload_dir = ROOT_PATH.'/public/uploads/'.$params['dir'];
				if(!file_exists($upload_dir))	@mkdir($upload_dir);
				$upload_dir = $upload_dir.'/'.date('Y');
				if(!file_exists($upload_dir))	@mkdir($upload_dir);
				$upload_dir = $upload_dir.'/'.date('m');
				if(!file_exists($upload_dir))	@mkdir($upload_dir);

				$img_content = $this->http->request($request_url, 'GET');
				
				if(strlen($img_content) == $headers['Content-Length']){
					file_put_contents($upload_dir.'/'.$filename, $img_content);
					return array('status' => 'y', 'file' => $params['dir'].'/'.date('Y').'/'.date('m').'/'.$filename);
				}else{
					$ret_json = @json_decode($img_content, true);
					if($ret_json['errcode'] == 40001){
						$this->getAccessToken(true);
					}
					return array('status' => 'n', 'msg' => $img_content);
				}
			}else{
				update_option('wx_token_update', 0);
				return array('status' => 'n', 'msg' => "微信操作失败 ".$this->http->request($request_url, 'GET'));
			}
		}elseif($act == 'preview'){
			return self::MEDIA_HOST.'/cgi-bin/media/get?access_token='.$this->access_token.'&media_id=';
		}
	}
	
	
	/**
	 * 
	 * @param type $redirect
	 * @return type
	 */
	public function getAuthorizationUrl($redirect){
		return 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->wx_appid.'&redirect_uri='.urlencode($redirect).'&response_type=code&scope=snsapi_userinfo&state=logined#wechat_redirect';
	}
	
	/**
	 * get userinfo by openid
	 */
	public function getUserInfo($code){
		$url = self::API_HOST.'/sns/oauth2/access_token?appid='.$this->wx_appid.'&secret='.$this->wx_secret.'&code='.$code.'&grant_type=authorization_code';
		$data = json_decode($this->http->request($url, 'GET'));
		echo $url;
		print_r($data);
		if(isset($data->openid)){
			$url = self::API_HOST.'/sns/userinfo?access_token='.$data->access_token.'&openid='.$data->openid.'&lang=zh_CN';

            return json_decode($this->http->request($url, 'GET'), true);
		}
		
		return false;
	}

	public function getUsers() {
        $url = self::API_HOST.'/cgi-bin/user/get?access_token='.$this->access_token;
        return json_decode($this->http->request($url, 'GET'));
    }
	
	/**
	 * set error
	 * @param type $msg
	 */
	protected function setError($msg) {
		if(IS_AJAX){
			send_json(array('status' => 'n', 'msg' => $msg));
		}else{
			die($msg);
		}
	}
	
	/**
	 * send request
	 * @param type $url
	 * @param type $type
	 * @param type $params
	 */
	private function sendRequest($url, $type, $params) {
		//return json_encode(array('errcode' => 0));	//for test
		if($type == 'post'){
			$params = $this->json->encode($params);
			$this->http->headers = array('Content-Type: application/json', 'Content-Length: '.mb_strlen($params));
		}

		return $this->http->request(
					self::API_HOST.'/'.$url.'?access_token='.$this->access_token, 
					$type, 
					$params
				);
	}

	/**
     * @TODO 发送模板消息
     */
	public function sendTemplateMessage($params) {
		$once_params = $params;

		$params = urldecode(json_encode($params));
		$response = $this->http->request(
			'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->access_token,
			'post',
			$params
		);
		$response = @$this->json->decode($response);

	
		if(isset($response->errcode) && $response->errcode === 0){
			return array('status' => 'y');
		}elseif($response->errcode === 40001){
			$this->getAccessToken(true);
			return $this->sendTemplateMessage($once_params);
		}else{
			return array('status' => 'n', 'msg' => "微信操作失败 ".$this->json->encode($response));
		}
	}


    /**
     * @TOOD 生成场景二维码
     * @param $scene_str
     * @return mixed|string
     */
	public function buildSceneQrcode($scene_str) {
        $token = json_decode($this->http->request(
            "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->wx_appid}&secret={$this->wx_secret}",
            'GET'),
            true);

        $access_token =  $token['access_token'];

        $data = array(
            'action_name' => 'QR_LIMIT_STR_SCENE',
            'action_info' => array('scene' => array('scene_str' => $scene_str))
        );
        $qrcode = json_decode($this->http->request('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token, 'POST', json_encode($data)), true);


        return $this->http->request('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$qrcode['ticket']);
    }


    /**
     * @TODO 是否关注公众号
     * @param $openid
     * @return mixed
     */
    public function isSubscribed($openid) {
        $token = json_decode($this->http->request(
            "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->wx_appid}&secret={$this->wx_secret}",
            'GET'),
            true);

        $access_token =  $token['access_token'];

        $data = json_decode($this->http->request(
            'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN',
            'GET'
            ),
            true);

        return $data['subscribe'];
    }
}

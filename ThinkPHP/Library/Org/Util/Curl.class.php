<?php
/**
 * Curl Class
 */
namespace Org\Util;

class Curl {
	public $useragent = '';
	public $connecttimeout = 30;
	public $timeout = 30;
	public $ssl_verifer = FALSE;
	public $headers = '';
	public $header = FALSE;
	public $encoding = '';
	public $auto_refer = TRUE;
	public $return_transfer = TRUE;
	public $gzip = FALSE;
	public $proxy = '';
	public $follow_location = 1;
	public $referer = '';
	public $cookie = '';
	public $cookie_file = '';

	/**
	* 请求
	* @param unknown_type $url
	* @param unknown_type $method
	* @param unknown_type $params
	*/
	public function http($url, $method, $params = '')
	{
		$method = strtoupper($method);
		$user_agent[] = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';
		$user_agent[] = 'Mozilla/5.0 (X11; Linux i686; rv:9.0.1) Gecko/20100101 Firefox/9.0.1';
		$user_agent[] = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; SV1)';
		$user_agent[] = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)';
		$user_agent[] = 'Sosospider+(+http://help.soso.com/webspider.htm)';
		$this->useragent = !empty($this->useragent) ? $this->useragent : $user_agent[mt_rand(0, count($user_agent)-1)];
		//获取请求地址
		if(!empty($params) && $method == 'GET'){
			if(strpos($url, '?') !== FALSE){
				if(is_array($params)){
					foreach($params as $k => $v){
						$url .= '&'.$k.'='.$v;
					}
				}else{
					$url = $url.'&'.$params;
				}
			}else{
				if(is_array($params)){
					$url = $url.'?';
					foreach($params as $k => $v){
						$url .= $k.'='.$v.'&';
					}
					$url = substr($url, 0, -1);
				}else{
					$url = $url.'?'.$params;
				}
			}
		}

		if(function_exists('curl_init')){
			$ci = curl_init();
			curl_setopt($ci,  CURLOPT_URL,  $url);
			curl_setopt($ci,  CURLOPT_USERAGENT,  $this->useragent); 
			curl_setopt($ci,  CURLOPT_CONNECTTIMEOUT,  $this->connecttimeout); 
			curl_setopt($ci,  CURLOPT_TIMEOUT,  $this->timeout); 
			curl_setopt($ci,  CURLOPT_SSL_VERIFYPEER,  $this->ssl_verifer); 
			curl_setopt($ci,  CURLOPT_HEADER,  $this->header);
			curl_setopt($ci,  CURLOPT_RETURNTRANSFER,  $this->return_transfer);
			curl_setopt($ci,  CURLOPT_AUTOREFERER,  $this->auto_refer);
			curl_setopt($ci,  CURLOPT_FOLLOWLOCATION,  $this->follow_location);
			if(!empty($this->headers))		curl_setopt($ci,  CURLOPT_HTTPHEADER,  $this->headers );  
			if(!empty($this->encoding))		curl_setopt($ci,  CURLOPT_ENCODING ,  $this->encoding);
			if(!empty($this->proxy))		curl_setopt($ci,  CURLOPT_PROXY,  $this->proxy);
			if(!empty($this->referer))		curl_setopt($ci,  CURLOPT_REFERER,  $this->referer);
			if(!empty($this->cookie))		curl_setopt ($ci, CURLOPT_COOKIE, $this->cookie);
			if(!empty($this->cookie_file))	curl_setopt ($ci, CURLOPT_COOKIEFILE, $this->cookie_file);
			if($this->gzip) curl_setopt($ci,  CURLOPT_ENCODING,  "gzip" );
			if($method == 'POST'){
				curl_setopt($ci,  CURLOPT_POST,  count($params));
				if(is_array($params) || is_object($params))
					curl_setopt($ci,  CURLOPT_POSTFIELDS,  http_build_query($params));
				else
					curl_setopt($ci,  CURLOPT_POSTFIELDS,  $params);
			}
			

			$result = curl_exec($ci);
			curl_close($ci);


		}else{
			$context = array('http' =>array('method' => $method, 
							'header' => 'Content-type: application/x-www-form-urlencoded'."\r\n".
										'User-Agent:  '.$this->useragent."\r\n".
										'Content-length: ' . strlen($url), 
							'content' => $url));
			$contextid = stream_context_create($context);
			$sock= fopen($url,  'r',  false,  $contextid);
			if ($sock) {
				$result='';
				while (!feof($sock))
					$result.=fgets($sock,  4096);
				fclose($sock);
			}

		}

		return $result;


	}

}


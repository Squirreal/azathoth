<?php

/**
 * Common Function
 */

/**
 * Checks for invalid UTF8 in a string.
 * @param string $string The text which is to be checked.
 * @param boolean $strip Optional. Whether to attempt to strip out invalid UTF8. Default is false.
 * @return string The checked text.
 */
function check_invalid_utf8( $string, $strip = false ) {
	$string = (string) $string;

	if ( 0 === strlen( $string ) ) {
		return '';
	}

	// Store the site charset as a static to avoid multiple calls to get_option()
	static $is_utf8;
	if ( !isset( $is_utf8 ) ) {
		$is_utf8 = true;
	}
	if ( !$is_utf8 ) {
		return $string;
	}

	// Check for support for utf8 in the installed PCRE library once and store the result in a static
	static $utf8_pcre;
	if ( !isset( $utf8_pcre ) ) {
		$utf8_pcre = @preg_match( '/^./u', 'a' );
	}
	// We can't demand utf8 in the PCRE installation, so just return the string in those cases
	if ( !$utf8_pcre ) {
		return $string;
	}

	// preg_match fails when it encounters invalid UTF8 in $string
	if ( 1 === @preg_match( '/^./us', $string ) ) {
		return $string;
	}

	// Attempt to strip the bad chars if requested (not recommended)
	if ( $strip && function_exists( 'iconv' ) ) {
		return iconv( 'utf-8', 'utf-8', $string );
	}

	return '';
}

/**
 * Converts a number of special characters into their HTML entities.
 *
 * Specifically deals with: &, <, >, ", and '.
 *
 * $quote_style can be set to ENT_COMPAT to encode " to
 * &quot;, or ENT_QUOTES to do both. Default is ENT_NOQUOTES where no quotes are encoded.
 * @param string $string The text which is to be encoded.
 * @param mixed $quote_style Optional. Converts double quotes if set to ENT_COMPAT, both single and double if set to ENT_QUOTES or none if set to ENT_NOQUOTES. Also compatible with old values; converting single quotes if set to 'single', double if set to 'double' or both if otherwise set. Default is ENT_NOQUOTES.
 * @param string $charset Optional. The character encoding of the string. Default is false.
 * @param boolean $double_encode Optional. Whether to encode existing html entities. Default is false.
 * @return string The encoded text with HTML entities.
 */
function specialchars_encode( $string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false ) {
	$string = (string) $string;

	if ( 0 === strlen( $string ) )
		return '';

	// Don't bother if there are no specialchars - saves some processing
	if ( ! preg_match( '/[&<>"\']/', $string ) )
		return $string;

	// Account for the previous behaviour of the function when the $quote_style is not an accepted value
	if ( empty( $quote_style ) )
		$quote_style = ENT_NOQUOTES;
	elseif ( ! in_array( $quote_style, array( 0, 2, 3, 'single', 'double' ), true ) )
		$quote_style = ENT_QUOTES;

	$charset = 'UTF-8';

	$_quote_style = $quote_style;

	if ( $quote_style === 'double' ) {
		$quote_style = ENT_COMPAT;
		$_quote_style = ENT_COMPAT;
	} elseif ( $quote_style === 'single' ) {
		$quote_style = ENT_NOQUOTES;
	}

	// Handle double encoding ourselves
	if ( $double_encode ) {
		$string = @htmlspecialchars( $string, $quote_style, $charset );
	} else {
		// Decode &amp; into &
		$string = specialchars_decode( $string, $_quote_style );

		// Now re-encode everything except &entity;
		$string = preg_split( '/(&#?x?[0-9a-z]+;)/i', $string, -1, PREG_SPLIT_DELIM_CAPTURE );

		for ( $i = 0; $i < count( $string ); $i += 2 )
			$string[$i] = @htmlspecialchars( $string[$i], $quote_style, $charset );

		$string = implode( '', $string );
	}

	// Backwards compatibility
	if ( 'single' === $_quote_style )
		$string = str_replace( "'", '&#039;', $string );

	return $string;
}

/**
 * Converts a number of HTML entities into their special characters.
 *
 * Specifically deals with: &, <, >, ", and '.
 *
 * $quote_style can be set to ENT_COMPAT to decode " entities,
 * or ENT_QUOTES to do both " and '. Default is ENT_NOQUOTES where no quotes are decoded.
 * @param string $string The text which is to be decoded.
 * @param mixed $quote_style Optional. Converts double quotes if set to ENT_COMPAT, both single and double if set to ENT_QUOTES or none if set to ENT_NOQUOTES. Also compatible with old _wp_specialchars() values; converting single quotes if set to 'single', double if set to 'double' or both if otherwise set. Default is ENT_NOQUOTES.
 * @return string The decoded text without HTML entities.
 */
function specialchars_decode( $string, $quote_style = ENT_NOQUOTES ) {
	$string = (string) $string;

	if ( 0 === strlen( $string ) ) {
		return '';
	}

	// Don't bother if there are no entities - saves a lot of processing
	if ( strpos( $string, '&' ) === false ) {
		return $string;
	}

	// Match the previous behaviour of _wp_specialchars() when the $quote_style is not an accepted value
	if ( empty( $quote_style ) ) {
		$quote_style = ENT_NOQUOTES;
	} elseif ( !in_array( $quote_style, array( 0, 2, 3, 'single', 'double' ), true ) ) {
		$quote_style = ENT_QUOTES;
	}

	// More complete than get_html_translation_table( HTML_SPECIALCHARS )
	$single = array( '&#039;'  => '\'', '&#x27;' => '\'' );
	$single_preg = array( '/&#0*39;/'  => '&#039;', '/&#x0*27;/i' => '&#x27;' );
	$double = array( '&quot;' => '"', '&#034;'  => '"', '&#x22;' => '"' );
	$double_preg = array( '/&#0*34;/'  => '&#034;', '/&#x0*22;/i' => '&#x22;' );
	$others = array( '&lt;'   => '<', '&#060;'  => '<', '&gt;'   => '>', '&#062;'  => '>', '&amp;'  => '&', '&#038;'  => '&', '&#x26;' => '&' );
	$others_preg = array( '/&#0*60;/'  => '&#060;', '/&#0*62;/'  => '&#062;', '/&#0*38;/'  => '&#038;', '/&#x0*26;/i' => '&#x26;' );

	if ( $quote_style === ENT_QUOTES ) {
		$translation = array_merge( $single, $double, $others );
		$translation_preg = array_merge( $single_preg, $double_preg, $others_preg );
	} elseif ( $quote_style === ENT_COMPAT || $quote_style === 'double' ) {
		$translation = array_merge( $double, $others );
		$translation_preg = array_merge( $double_preg, $others_preg );
	} elseif ( $quote_style === 'single' ) {
		$translation = array_merge( $single, $others );
		$translation_preg = array_merge( $single_preg, $others_preg );
	} elseif ( $quote_style === ENT_NOQUOTES ) {
		$translation = $others;
		$translation_preg = $others_preg;
	}

	// Remove zero padding on numeric entities
	$string = preg_replace( array_keys( $translation_preg ), array_values( $translation_preg ), $string );

	// Replace characters according to translation table
	return strtr( $string, $translation );
}

/**
 * Escaping for HTML blocks.
 * @param string $text
 * @return string
 */
function esc_html( $text ) {
	$safe_text = check_invalid_utf8( $text );
	return specialchars_encode( $safe_text, ENT_QUOTES );
}

/**
 * escaping for html
 * @param type $value
 * @return type
 */
function eschtml_deep($value){
	if ( is_array($value) ) {
		$value = array_map('eschtml_deep', $value);
	} elseif ( is_object($value) ) {
		$vars = get_object_vars( $value );
		foreach ($vars as $key=>$data) {
			$value->{$key} = eschtml_deep( $data );
		}
	} elseif ( is_string( $value ) ) {
		$value = trim(esc_html($value));
	}

	return $value;
}

/**
 * @TODO send json
 * @param array $response
 */
function send_json($response) {
	@header('Content-Type: application/json; charset=utf-8');
	echo json_encode($response);
	exit;
}

/**
 * @TODO validate user
 */
function user_validate() {
	D('users')->validateLogin();
	if (session('userinfo')) {
		return true;
	} else {
		send_json(array('ret' => 1, 'errcode' => 1, 'msg' => '请登录!'));
	}
}

/**
 * @TODO get user meta
 * @param type $ID
 * @param type $meta_key
 * @param type $meta_value
 */
function update_user_meta($ID, $meta_key, $meta_value = '') {
	if ($ID && $meta_key) {
		$_meta = M('usermeta');
		$condition = array('uid' => $ID, 'meta_key' => $meta_key);
		if ($_meta->where($condition)->find()) {
			$_meta->where($condition)->save(array('meta_value' => $meta_value));
		} else {
			$_meta->add(array('uid' => $ID, 'meta_key' => $meta_key, 'meta_value' => $meta_value));
		}
	}
}

/**
 * @TODO get user meta
 * @param type $ID
 * @param type $meta_key
 * @return string
 */
function get_user_meta($ID, $meta_key) {
	if ($ID && $meta_key) {
		$_meta = M('usermeta');
		$condition = array('uid' => $ID, 'meta_key' => $meta_key);
		$meta = $_meta->where($condition)->find();
		return isset($meta['meta_value']) ? $meta['meta_value'] : '';
	}
	return '';
}

/**
 * @TODO abs intval
 * @param type $val
 * @return type
 */
function absint($val) {
	return abs(intval($val));
}

/**
 * @TODO Check value to find if it was serialized.
 *
 * If $data is not an string, then returned value will always be false.
 * Serialized data is always a string.
 * @param mixed $data Value to check to see if was serialized.
 * @return bool False if not serialized and true if it was.
 */
function is_serialized($data) {
	// if it isn't a string, it isn't serialized
	if (!is_string($data))
		return false;
	$data = trim($data);
	if ('N;' == $data)
		return true;
	$length = strlen($data);
	if ($length < 4)
		return false;
	if (':' !== $data[1])
		return false;
	$lastc = $data[$length - 1];
	if (';' !== $lastc && '}' !== $lastc)
		return false;
	$token = $data[0];
	switch ($token) {
		case 's' :
			if ('"' !== $data[$length - 2])
				return false;
		case 'a' :
		case 'O' :
			return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
		case 'b' :
		case 'i' :
		case 'd' :
			return (bool) preg_match("/^{$token}:[0-9.E-]+;\$/", $data);
	}
	return false;
}


/**
 * @TODO set variable
 * @param string $name
 * @param string $value
 * @return string
 */
function variable_set($name, $value) {
	return D('Variables')->set($name, $value);
}

/**
 * @TODO get variable
 * @param type $q
 * @return type
 */
function variable_get($q) {
    if (!$q)            return '';
    if (is_array($q))   return '';
	return D('Variables')->where(array('q' => $q))->getField('value');
}

/**
 * @TODO get option
 * @param type $company_id
 * @param type $option_name
 * @return type
 */
function get_option($option_name) {
	$value = M('options')->where(array('option_name' => $option_name))->getField('option_value');
	if ($value && is_serialized($value)) {
		return @unserialize($value);
	}
	return $value;
}

/**
 * @TODO update option
 * @param type $company_id
 * @param type $option_name
 * @param type $option_value
 */
function update_option($option_name, $option_value) {
	$m = M('options');
	if (is_array($option_value)) {
		$option_value = serialize($option_value);
	}
	if ($m->where(array('option_name' => $option_name))->getField('option_id')) {
		$m->where(array('option_name' => $option_name))->save(array('option_value' => $option_value));
	} else {
		$m->add(array('option_name' => $option_name, 'option_value' => $option_value));
	}
}

/**
 * @TODO check verify code
 * @param type $code
 * @param type $id
 * @return type
 */
function check_verify($code, $id = '') {
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}

/**
 * @TODO check user capability
 * @param type $cap
 * @return boolean
 */
function user_can($cap) {
	return in_array($cap, (array) session('userinfo.capability')) ? true : false;
}

/**
 * @TODO url split
 * @param $str
 * @param string $delimiter
 * @return string
 */
function url_split($str, $delimiter = '/') {
	$arr = preg_split('/(?=[A-Z])/', ucwords($str));
	array_shift($arr);
	return implode($delimiter, $arr);
}

/**
 * @TODO 文件大小转换
 * @param int $filesize
 * @return string
 */
function filesize_conv($filesize) {
	if ($filesize >= 1073741824) {
		$filesize = round($filesize / 1073741824 * 100) / 100 . ' G';
	} elseif ($filesize >= 1048576) {
		$filesize = round($filesize / 1048576 * 100) / 100 . ' M';
	} elseif ($filesize >= 1024) {
		$filesize = round($filesize / 1024 * 100) / 100 . ' K';
	}
	return $filesize;
}

/**
 * @TODO get user avatar
 * @param type $avatar
 * @param string $size
 * @return type
 */
function get_avatar($avatar, $size = '') {
	if (strpos($avatar, 'http') === 0) {
		return $avatar;
	}
	if (!$avatar) {
		$avatar = '/avatar/default-avatar.png';
	}
	if (!$size) {
	    return C('FILES_SERVER').$avatar;
    }
	return C('FILES_SERVER').$avatar.'_'.$size.'_'.$size;
}


/**
 * @TODO 日转周
 */
function day2week($day) {
	$w = date('w', strtotime($day));
	$week = array('周日', '周一', '周二', '周三', '周四', '周五', '周六');
	return $week[$w];
}


/**
 * @TODO amount format
 * @param type $amount
 * @return type
 */
function amount_format($amount) {
	return number_format($amount, 2, '.', ',');
}

/**
 * @TODO mobile format
 * @param type $mobile
 * @return string
 */
function mobile_format($mobile) {
	return substr($mobile, 0, 3) . '****' . substr($mobile, -4);
}

/**
 * @TODO dead line format
 * @param type $deadline
 * @param type $date_type
 * @return type
 */
function deadline_format($deadline, $date_type) {
	if ($date_type == 2) {
		$deadline = $deadline * 30;
	}
	return absint($deadline);
}

/**
 * @TODO bank account format
 * @param type $bank_account
 * @return string
 */
function bank_account_format($bank_account) {
	return '**** **** **** *** ' . substr($bank_account, -4);
}

/**
 * @TODO name format
 * @param type $name
 * @return mixed
 */
function name_format($name) {
	if ($name) {
		return mb_substr($name, 0, 1, 'utf-8') . ' * *';
	} else {
		return NULL;
	}
}

/**
 * @TODO idno format
 * @param string $idno
 * @return string
 */
function idno_format($idno) {
	if ($idno) {
		return str_repeat('*', 14) . substr($idno, -4);
	} else {
		return NULL;
	}
}

/**
 * @TODO nid generate
 * @param $prefix
 * @param $salt
 * @return string
 */
function nid_generate($prefix, $salt) {
    return $prefix.date('ymdHis').(microtime() * 1000000).strtoupper($salt).mt_rand(10000, 99999);
}

/**
 * @TODO url base64 encode
 * @param type $url
 * @return string
 */
function url_base64_encode($url) {
	return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($url));
}

/**
 * @TODO url base64 decode
 * @param type $string
 * @return string
 */
function url_base64_decode($string) {
	$string = str_replace(array('-', '_'), array('+', '/'), $string);
	$mod = strlen($string) % 4;
	if ($mod) {
		$string .= substr('====', $mod);
	}
	return base64_decode($string);
}


/**
 * @TODO 时间格式化
 * @param $time
 * @return false|string
 */
function time_format($time){
    if (strlen($time) > 10) {
        $time = strtotime($time);
    }
    $current = time();
    $time_d = $time - $current;		//时间差
    $todaytime = mktime(0,0,0,date('m'),date('d'),date('Y'));	//今天的0点时间戳
    $yestodaytime = $todaytime - 24*3600;	//昨天的0点时间戳
    //return $time.'-'.$todaytime.'-'.$yestodaytime;
    if (abs($time_d) <= 5) {
        return '刚刚';
    } else if (abs($time_d) <= 60) {
        return abs($time_d).'秒前';
    } elseif (abs($time_d) < 3600) {
        return ceil(abs($time_d) / 60).'分钟前';
    } elseif ($time >= $todaytime){
        return '今天 '.date('H:i',$time);
    } elseif ($time >= $yestodaytime && $time < $todaytime){
        return '昨天 '.date('H:i',$time);
    } else {
        return date('Y-m-d H:i',$time);
    }
}

/**
 * @TODO validate domain
 * @param $domain
 * @return bool
 */
function is_domain($domain) {
    return preg_match('/^(?=^.{3,255}$)[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+$/is', $domain) ? true : false;
}

/**
 * @TODO validate mobile
 * @param $mobile
 * @return false|int
 */
function is_mobile($mobile) {
    return preg_match("/^13[0-9]{9}$|14[0-9]{9}$|15[0-9]{9}$|16[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$|19[0-9]{9}$/", $mobile);
}

/**
 * @TODO get aliyun oss image
 * @param $image
 * @param $w
 * @param $h
 * @return string
 */
function get_oss_image($image, $w = 0, $h = 0) {
    if (!$image)    return '';
    $image = C('FILES_SERVER').$image;
    if ($w > 0)    return $image.'?x-oss-process=image/resize,m_fill,w_'.$w.',h_'.$h;
    return $image;
}

if( !function_exists('boolval')) {
    function boolval($var){
        return !! $var;
    }
}
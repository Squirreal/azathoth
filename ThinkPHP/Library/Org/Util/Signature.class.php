<?php
/**
 * Signature
 */
namespace Org\Util;

class Signature {
	
	public $font = null;
	public $width = 185;
	public $height = 68;
	
	public function __construct() {
		$this->font = APP_PATH.'/../public/assets/fonts/signature.ttf';
	}
	
	public function create($str1, $str2) {
		$im = imagecreatetruecolor($this->width, $this->height);
		$bg_color = imagecolorallocate($im, 255, 255, 255);
		$black = imagecolorallocate($im, 100, 100, 100);
		imagecolortransparent($im, $bg_color);
		imagefill($im , 0, 0, $bg_color);
		imagettftext($im, 35, 0, 0, 40, $black, $this->font, $str1);
		imagettftext($im, 18, 0, 10, 65, $black, $this->font, $str2);
		
		$img_name = substr(md5(md5($str1.$str2)), 8, 16).'.png';
		
		imagepng($im,  APP_PATH.'/../public/uploads/signature/'.$img_name);
		imagedestroy($im);
		
		return $img_name;
	}
}
?>
<?php

/**
 * Variables
 */

namespace Common\Model;

use Think\Model;

class VariablesModel extends Model {

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * set
	 * @param type $name
	 * @param type $value
	 * @return type
	 */
    public function set($name, $value) {
		if(is_numeric($value)){
			$name = $name.'.'.$value;
			$q = $this->where(array('name' => $name))->getField('q');
		}else{
			$q = $this->where(array('name' => $name, 'value' => $value))->getField('q');
		}
		if(!$q){
			$q = $this->generate();
			while(true){
				if($this->where(array('q' => $q))->getField('q')){
					$q = $this->generate();
				}else{
					break;
				}
			}
			$this->add(array('name' => $name, 'value' => $value, 'q' => $q));
		}
		return $q;
	}
			
	/**
	 * generate
	 * @return string
	 */
	private function generate() {
		$base32 = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
			'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',
			'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
			'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
			'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
			'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1',
			'2', '3', '4', '5', '6', '7', '8', '9','_'
		);
		shuffle($base32);
		$hex = md5(microtime());
		$hexLen = strlen($hex);
		$subHexLen = $hexLen / 8;
		$output = array();

		for ($i = 0; $i < $subHexLen; $i++) {
			$subHex = substr($hex, $i * 8, 8);
			$int = 0x3FFFFFFF & hexdec('0x' . $subHex);
			$out = '';

			for ($j = 0; $j < 10; $j++) {
				$val = 0x0000001F & $int;
				$out .= $base32[$val];
				$int = $int >> 3;
			}

			$output[] = $out;
		}

		return $output[mt_rand(0, 3)];
	}

}

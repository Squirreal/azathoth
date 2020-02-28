<?php
/**
 * Upload Class
 */
namespace Org\Util;

class Upload 
{
	private $max_size = 0;
	
	public function __construct() {
		$this->max_size = intval(ini_get('upload_max_filesize')) * 1000000;
	}

    /**
     * @TODO upload file from form
     * @param $file
     * @param $dir
     * @param string $path
     * @param string $type
     * @return array
     */
	public function fromForm($file, $dir, $path = '', $type = 'image') {
		$response = array('status' => 'n', 'msg' => '上传错误！');
		if ($file['error'] == 0 && $file['name']) {
			if ($file['size'] > $this->max_size) {
				$response['msg'] = '文件大小超出限制, 最大只能上传'.($this->max_size / 1000000).'M';
			} else {
				if($type == 'image'){
					$allow_files = array('jpg', 'gif', 'jpeg', 'png');
				}else{
					$allow_files = array('xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'rar', 'jpg', 'gif', 'jpeg', 'png', 'pdf', 'mp4');
				}
				
				$filetype = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
				if (!in_array($filetype, $allow_files)) {
					$response['msg'] = '仅支持'.implode(',', $allow_files).'格式的文件';
				} else {
					$filename = substr(md5(md5($file['name'].microtime())), 8, 16).'.'.$filetype;
					
					$upload_dir = $path ? $path.'/'.$dir : APP_PATH.'/../Public/public/uploads/'.$dir;

					if (!file_exists($upload_dir))	mkdir($upload_dir, 0777);
					$upload_dir = $upload_dir.'/'.date('Ym');
					if (!file_exists($upload_dir))	mkdir($upload_dir, 0777);
					file_put_contents($upload_dir.'/'.$filename, file_get_contents($file['tmp_name']));
					//move_uploaded_file($file['tmp_name'], $upload_dir.'/'.$filename);
					$response = array('status' => 'y', 'file' => $dir.'/'.date('Ym').'/'.$filename, 'name' => $file['name'], 'size' => $file['size'], 'type' => $filetype);
				}
			}
		}
		return $response;
	}


    /**
     * @TODO upload file from base64
     * @param $content
     * @param $dir
     * @return array
     */
    public function fromBase64($content, $dir) {
		//echo substr($content, strpos($content, 'base64,') + 7);exit;
		$content = base64_decode(substr($content, strpos($content, 'base64,') + 7));
		
		$result = array('result' => false,'pic' => '','msg' => '上传错误');
		if($content){
			
			//保存图片内容到临时目录
			$temp_file = tempnam(sys_get_temp_dir(), 'Upl');
			
			file_put_contents($temp_file, $content);
			if (filesize($temp_file) > $this->max_size) {
				$result['msg'] = '图片大小超出10M';
			} else {
				$upload_type = array("image/gif","image/png","image/jpeg","image/pjpeg");
				$file_info = getimagesize($temp_file);
				if (!in_array($file_info['mime'], $upload_type)) {
					$result['msg'] = '仅支持 gif | jpg | jpeg | png格式的图片';
				} else {
					$upload_dir = APP_PATH.'../Public/public/uploads/'.$dir;
					if(!file_exists($upload_dir))	@mkdir($upload_dir);
					$upload_dir = $upload_dir.'/'.date('Y');
					if(!file_exists($upload_dir))	@mkdir($upload_dir);
					$upload_dir = $upload_dir.'/'.date('m');
					if(!file_exists($upload_dir))	@mkdir($upload_dir);
					
					$pic_name = substr(md5(date('Y').date('m').date('d').microtime()*100000000), 0 , 16);
					
					switch ($file_info['mime']) {
						case 'image/jpeg':
							$new_pic_name =  $pic_name.'.jpg';
							break;
						case 'image/gif':
							$new_pic_name =  $pic_name.'.gif';
							break;
						case 'image/png':
							$new_pic_name =  $pic_name.'.png';
							break;
						case 'image/pjpeg':
							$new_pic_name =  $pic_name.'.jpg';
							break;
					
					}
					
					//保存图片
					file_put_contents($upload_dir.'/'.$new_pic_name, $content);
					$result = array('result' => true,'pic' => $dir.'/'.date("Y").'/'.date('m').'/'.$new_pic_name);
					
					//删除临时文件
					@unlink($temp_file);
				}
			}
		}
		
		return $result;
	}
	
}
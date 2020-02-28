<?php
/**
 * Upload
 * 
 */
namespace Admin\Controller;

use OSS\Core\OssException;
use OSS\OssClient;

class UploadController extends BaseController {

    public function __construct() {
		define('API_ENGINE', true);
		parent::__construct();
	}
	
	public function index() {
        vendor('AliOSS.autoload');
        $oss_config = C('ALI_OSS_CONFIG');

        try {
            $oss_client = new OssClient($oss_config['access_id'], $oss_config['access_key'], $oss_config['endpoint']);

            $file = $_FILES['files'];
            if ($file && $file['error'] == 0) {
                $filetype = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
                $new_file = date('Ymd').'/'.md5(md5($file['name'])).'.'.$filetype;
                $oss_client->uploadFile($oss_config['bucket'], $new_file, $file['tmp_name']);
                $this->response = array(
                    'status' => 'y',
                    'data' => array(
                        'url' => C('FILES_SERVER').$new_file,
                        'file' => $new_file,
                        'name' => $file['name'],
                    )
                );
            } else {
                throw new OssException('上传错误');
            }
        } catch (OssException $e) {

            $this->setError($e->getMessage());
        }

		$this->sendResponse();
	}
}
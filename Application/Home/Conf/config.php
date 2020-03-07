<?php

return array(
    'TMPL_PARSE_STRING' => array(
		'__PUBLIC__' => 'https://squirreal.oss-cn-shanghai.aliyuncs.com/asset',
        '__CSSVER__' => !APP_DEBUG ? '1.0.0' : date('YmdHis'),
        '__JSVER__' => !APP_DEBUG ? '1.0.0' : date('YmdHis')
	),

    'URL_HTML_SUFFIX'       => 'html',
	
	'TMPL_EXCEPTION_FILE' => APP_PATH.'Home/View/Error/exception.phtml',
	'TMPL_ACTION_ERROR' => APP_PATH.'Home/View/Error/error.phtml',
	'TMPL_ACTION_SUCCESS' => APP_PATH.'Home/View/Error/success.phtml',

    'OPEN_WECHAT' => [
        'APP_ID' => 'wx5fd2211460164848',
        'APP_SECRET' => 'dbd5ddca052dad2e478c2a96653588a4',
    ]
);

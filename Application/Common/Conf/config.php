<?php

//配置文件

return array(
    //'配置项' => '配置值'

    //Cookie设置
    'COOKIE_EXPIRE' => 86400 * 365,	//Cookie有效期
    'COOKIE_DOMAIN' => '',	//Cookie有效域名
    'COOKIE_PATH' => '/',	//Cookie路径
    'COOKIE_PREFIX' => '',	//Cookie前缀 避免冲突
    'COOKIE_SECURE' => false,	//Cookie安全传输
    'COOKIE_HTTPONLY' => '',	//Cookie httponly设置
    'COOKIE_SALT' => 'mlg@Ql@XkPW7DSuS', //Cookie salt

    'USER_PASSWORD_SALT' => 'K1ukB2vNy#U%1U&l', //user password salt

    //JWT
    'JWT' => array(
        'iss' => 'Online JWT Builde',
        'aud' => $_SERVER['SERVER_NAME'],
        'key' => '*(LX3CE90EllGpaJ',
        'type' => 'HS256',
        'exp' => 86400 * 30,
    ),

    //AES API
    'API' => array(
        'key' => '239dfnf8sd0fbsd1',    //API AES KEY
        'iv' => '8711df9f0d37s0d3', //API AES IV
    ),

    //JS API
    'JSAPI' => array(
        'key' => '9ef1c0d959184b3f',
        'iv' => '67f3a39255edbb4e',
    ),

    //form token
    'TOKEN_ON' => true,	//是否开启令牌验证 默认关闭
    'TOKEN_NAME' => '__hash__',	//令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE' => 'md5',	//令牌哈希验证规则 默认为MD5
    'TOKEN_RESET' => true,	//令牌验证出错后是否重置令牌 默认为true

    'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => '/public'
    ),

    /** session **/
    'SESSION_OPTIONS'     =>  array('name' => 'JSESSID'),	// session 配置数组 支持type name id path expire domain 等参数
    'VAR_SESSION_ID'      =>  'JSESSID',     //sessionID的提交变量

    'MULTI_MODULE'			=>	true,

    /** 多模块配置 **/
    'MODULE_ALLOW_LIST'    =>   array('Home', 'Admin', 'API'),	//可运行的模块

    //载入扩展配置
    'LOAD_EXT_CONFIG'	=> array('router', 'cache', 'db', 'ENUM' => 'enum'),

    //阿里云OSS设置
    'ALI_OSS_CONFIG' => array(
        'access_id' => 'LTAI4Fny7XqhcYgHrj7BcvZF', //阿里云Access Key ID
        'access_key' => 'vqU3v3saOEjx4JUm8bWwtyvlA5rarZ', //阿里云Access Key Secret
        'bucket' => 'squirreal', //阿里云的bucket
        'endpoint' => 'oss-cn-shanghai.aliyuncs.com',
    ),

    'FILES_SERVER' => 'https://squirreal.oss-cn-shanghai.aliyuncs.com/',

    //微信设置
    'WEIXIN' => array(
        'app_id' => 'wx810bc000241ac316',
        'app_secret' => '5b845282748d779c8d68597a66254965',
    )
);

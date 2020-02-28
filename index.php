<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', TRUE);

// 定义应用目录
define('APP_PATH', 'Application/');

// 定义根目录
define('ROOT_PATH', realpath(dirname(__FILE__)));

// 定义环境变量
define('ENV', 'dev'); // dev 本地开发环境 sandbox 测试环境 prod 生产环境

// 引入ThinkPHP入口文件
require 'ThinkPHP/ThinkPHP.php';

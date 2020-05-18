<?php

/**
 * 数据库配置
 */
return array(
    //'配置项'=>'配置值'
    // /* 数据库设置 */
    // 'DB_TYPE' => 'mysqli', // 数据库类型
    // 'DB_HOST' => 'localhost', // 服务器地址
    // 'DB_NAME' => 'squirreal', // 数据库名
    // 'DB_USER' => 'u_squirreal', // 用户名
    // 'DB_PWD' => 'WBeTDKRVF9KWxDAP', // 密码

    'DB_TYPE' => 'mysqli', // 数据库类型
    'DB_HOST' => '47.102.211.106', // 服务器地址
    'DB_NAME' => 'squirreal', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => 'Mz9#GEjx*IYnbAh6', // 密码

    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => 'sr_', // 数据库表前缀
    'DB_FIELDTYPE_CHECK' => false, // 是否进行字段类型检查
    'DB_FIELDS_CACHE' => false, // 启用字段缓存
    'DB_CHARSET' => 'utf8mb4', // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE' => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE' => false, // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM' => 1, // 读写分离后 主服务器数量
    'DB_SQL_BUILD_CACHE' => false, // 数据库查询的SQL创建缓存
    'DB_SQL_BUILD_QUEUE' => 'file', // SQL缓存队列的缓存方式 支持 file xcache和apc
    'DB_SQL_BUILD_LENGTH' => 20, // SQL缓存的队列长度
    'DB_PARAMS' =>  array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL), //区分大小写,
);

<?php
return array(
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // 数据库配置信息
    'DB_TYPE'                   => 'mysql',                 // 数据库类型
    'DB_HOST'                   => 'localhost',         // 数据库主机
    'DB_NAME'                   => 'twbb',               // 数据库名称
    'DB_USER'                   => 'root',        // 数据库用户
    'DB_PWD'                    => '',        // 数据库密码

    'DB_PORT'                   => '3306',                  // 连接数据库端口
    'DB_PREFIX'                 => 'twbb_',                   // 数据库前缀

    'MODULE_ALLOW_LIST'         => array('Home'),           //允许访问的模块列表
    'DEFAULT_MODULE'            => 'Home',                          // 默认模块
    'MODULE_DENY_LIST'          => array('Common', 'Runtime'),      // 设置禁止访问的模块列表

    'TMPL_FILE_DEPR'            => '_',                     // 配置简化模板的目录层次

    /* 修改模板定界符，默认为“{}”，修改为“<{}>” */
    'TMPL_L_DELIM'              => '<{',
    'TMPL_R_DELIM'              => '}>',

    /* URL配置 */
    'URL_CASE_INSENSITIVE'      => false,                   // 默认false 表示URL区分大小写 true则表示不区分大小写
    // 'URL_404_REDIRECT'          => '/404.html',             // 404跳转页面 部署模式有效
    
    'SESSION_AUTO_START'        => true,                    // 是否自动开启Session
    'SESSION_OPTIONS'           => array(),                 // session 配置数组 支持type name id path expire domain 等参数
    'SESSION_TYPE'              => '',                      // session hander类型 默认无需设置 除非扩展了session hander驱动
    'SESSION_PREFIX'            => '',                      // session 前缀

    // 开启路由
    'URL_ROUTER_ON'             => true,
    'URL_ROUTE_RULES'           => array(
        'signin'       => 'sign/in',
        'signup'       => 'sign/up',
        'signout'      => 'sign/out',
    ),
);
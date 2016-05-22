<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_FILE_DEPR'    => '_',                     // 配置简化模板的目录层次
    'SHOW_PAGE_TRACE'   =>true,                     // 开启调试模式
    'TMPL_PARSE_STRING'    =>  array(               // 定义常量
        '__IMG__'       => __ROOT__.'/Public/img',           
        '__CSS__'       => __ROOT__.'/Public/css',
        '__JS__'        => __ROOT__.'/Public/js',
        '__WOOL__'        => __ROOT__.'/Public/img/wool',
        '__AVATAR__'    => __ROOT__.'/Public/avatar',       // 专门用来存放用户的头像
    ),
    'URL_HTML_SUFFIX'=>'html'
);
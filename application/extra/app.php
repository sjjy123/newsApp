<?php
/*
 * 项目配置文件
 */
return [
    'password_half_pre' => "news-app",
    'aes_key' => "sdefsdawjfrtwq22",//aes密匙，服务端必须和客户端保持一致(密钥长度保持在16位以内)
    'apptypes' => [
        'ios',
        'android',
    ],
    'app_sign_time' => 10,// sign失效时间
    'app_sign_cache_time' => 20,// sign 缓存失效时间
];
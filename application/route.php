<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

//Route::get('test', 'api/test/index');
Route::resource('test', 'api/test');

Route::get('api/:ver/cat', 'api/:ver.cat/read');
//客户端首页
Route::get('api/:ver/index', 'api/:ver.index/index');
Route::get('api/:ver/init', 'api/:ver.index/init');

//排行榜
Route::get('api/:ver/rank', 'api/:ver.rank/index');
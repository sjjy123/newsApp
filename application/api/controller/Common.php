<?php
namespace app\api\controller;

use think\Cache;
use think\Controller;
use app\common\lib\IAuth;
use think\Request;

Class Common extends Controller{
    //服务器当前时间
    public $currentTime;

    public function __construct(Request $request = null)
    {
        $this->currentTime = time();
        parent::__construct($request);
    }

    /**
     * 初始化方法
     * @author: Shijie
     */
    public function _initialize()
    {
        $this->checkRequestAuth();
    }

    /**
     * 检查每次app请求的数据是否合法
     */
    public function checkRequestAuth() {
        // 首先需要获取headers
        $headers = request()->header();
        // todo

        // sign 加密需要 客户端工程师 ， 解密：服务端工程师
        // 1 headers body 仿照sign 做参数的加解密
        // 2
        //  3

        // 基础参数校验
        if(empty($headers['sign'])) {
            throw new ApiException('sign不存在', 400);
        }
        if(!in_array($headers['app_type'], config('app.apptypes'))) {
            throw new ApiException('app_type不合法', 400);
        }

        // 需要sign
        if(!IAuth::checkSignPass($headers)) {
            throw new ApiException('授权码sign失败', 401);
        }
        Cache::set($headers['sign'], 1, config('app.app_sign_cache_time'));

        // 1、文件  2、mysql 3、redis
        $this->headers = $headers;
    }

    /**
     * 获取处理的新闻的内容数据
     * @param array $news
     * @return array
     */
    protected  function getDealNews($news = []) {
        if(empty($news)) {
            return [];
        }

        $cats = config('cat.lists');

        foreach($news as $key => $new) {
            $news[$key]['catname'] = $cats[$new['ctaid']] ? $cats[$new['ctaid']] : '-';
        }

        return $news;
    }

}

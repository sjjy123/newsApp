<?php
namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    /**
     * page
     * @var string
     */
    public $page = '';

    /**
     * 每页显示多少条
     * @var string
     */
    public $size = '';

    /**
     * 当前页数
     * @var string
     */
    public $from = '';

    /**
     * @author: Shijie
     * 初始化方法
     */
    public function _initialize()
    {
        if (!$this->isLogin()) {
            return $this->redirect("login/index");
        }
    }

    public function isLogin()
    {
        $loginUser = session(config('admin.session_user'), '', config('admin.imooc_app_scope'));

        if ($loginUser && $loginUser->ID) {
            return true;
        }
        return false;
    }

    public function getPageAndSize($data){
        $this->page = !empty($data['page']) ? $data['page'] : 1;
        $this->size = !empty($data['size']) ? $data['size'] : config('paginate.list_rows');
        $this->from = ($this->page - 1) * $this->size;
    }
}

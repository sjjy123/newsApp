<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\common\lib\IAuth;

class Login extends Base
{
    public function _initialize()
    {
    }


    public function index()
    {
        if ($this->isLogin()) {
            return $this->redirect("index/index");
        } else {
            return $this->fetch();
        }
    }

    public function check()
    {
        if (request()->isPost()) {
            $loginData = input('post.');

//            if (!captcha_check($loginData['code'])) {
//                $this->error("验证码输入有误");
//            }

            $validate = validate('AdminUser');
            if (!$validate->check($loginData)) {
                $this->error("用户名密码输入格式不正确");
            }

            try{
                $loginUserInfo = model('AdminUser')->get(['username'=>$loginData['username']]);
            } catch (\Exception $e) {
                exception($e->getMessage());
            }

            if (!$loginUserInfo || $loginUserInfo['status'] != config('code.user_status_normol')) {
                $this->error("该用户不存在");
            }
            if (IAuth::setPassword($loginData['password']) != $loginUserInfo['password']) {
                $this->error("密码错误");
            }
            //更新用户登录IP，时间等数据数据
            $udata = [
                'last_login_ip' => request()->ip(),
                'last_login_time' => time(),
            ];

            try{

                model('AdminUser')->save($udata, ['id'=>$loginUserInfo->ID]);
            } catch (\Exception $e) {
                exception($e->getMessage());
            }
            //将用户信息存入session
            session(config('admin.session_user'), $loginUserInfo, config('admin.imooc_app_scope'));

            $this->success("登录成功", "index/index");

        } else {
            $this->error("请求方式错误");
        }
    }

    /**
     * 退出登录的逻辑
     * 1、清空session
     * 2、 跳转到登录页面
     */
    public function logout() {
        session(config('admin.session_user'), null);
        // 跳转
        return $this->redirect('login/index');
    }
}
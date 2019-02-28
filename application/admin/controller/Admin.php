<?php
namespace app\admin\controller;

use think\Controller;

class Admin extends Controller
{
    public function add()
    {
        try {
            if (request()->isPost()) {
                $data = input("post.");
                $data['password'] = md5($data['password'].'news-app');
                $data['status'] = 1;
                $data['create_time'] = time();

                $validate = validate("AdminUser");
                if(!$validate->check($data)) {
                    exception("数据提交有误");
                }

                $userInfo = model('AdminUser')->get(['username'=>$data['username']]);

                if (!empty($userInfo)) {
                    exception("该用户名已经存在");
                }

                $id = model('AdminUser')->add($data);

                if ($id) {
                    return ['status'=>1, 'message'=>'新增成功'];
                } else {
                    return ['status'=>0, 'message'=>'新增失败'];
                }
            } else {
                return $this->fetch('admin/add');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}

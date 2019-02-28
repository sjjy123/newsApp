<?php
namespace app\common\model;

use think\Model;

class AdminUser extends Model
{
    public function add($data) {
        return $this->allowField(true)->save($data);
    }
}
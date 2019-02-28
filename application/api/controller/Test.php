<?php
namespace app\api\controller;

use app\api\controller\Common;

class Test extends Common
{
    public function index() {
        return [
            'sign'=>'dshgfdjsgfghsdjfgdsgf',
            'name'=>'sdjdsgfjsdg',
        ];
    }

    public function save() {
        return show(1, 'OK', input('post.'), 201);
    }
}
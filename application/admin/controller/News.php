<?php
namespace app\admin\controller;

use app\admin\controller\Base;

class News extends Base
{
    public function index() {
        $data = input('param.');
        if (!empty($data)) {
            $query = http_build_query($data);
        } else {
            $query = "";
        }
        $whereData = [];

        // 转换查询条件
        if(!empty($data['start_time']) && !empty($data['end_time'])
            && $data['end_time'] > $data['start_time']
        ) {
            $whereData['create_time'] = [
                ['gt', strtotime($data['start_time'])],
                ['lt', strtotime($data['end_time'])],
            ];
        }
        if(!empty($data['ctaid'])) {
            $whereData['ctaid'] = intval($data['ctaid']);
        }
        if(!empty($data['title'])) {
            $whereData['title'] = ['like', '%'.$data['title'].'%'];
        }

        $this->getPageAndSize($data);
        // 获取表里面的数据
        $news = model('News')->getNewsByCondition($whereData, $this->from, $this->size);
        // 获取满足条件的数据总数 =》 有多少页
        $total = model('News')->getNewsCountByCondition($whereData);
        /// 结合总数+size  =》 有多少页
        $pageTotal = ceil($total/$this->size);//1.1 =>2

        return $this->fetch('news/index', [
            'cats' => config('cat.lists'),
            'news' => $news,
            'pageTotal' => $pageTotal,
            'curr' => $this->page,
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'catid' => empty($data['ctaid']) ? '' : $data['ctaid'],
            'title' => empty($data['title']) ? '' : $data['title'],
            'query' => $query,
        ]);
    }

    public function add() {

        if(request()->isPost()) {

            $data = input('post.');
            // 数据需要做检验 validate机制小伙伴自行完成

            //入库操作
            try {
                $id = model('News')->add($data);
            }catch (\Exception $e) {
                return $this->result('', 0, '新增失败');
            }

            if($id) {
                return $this->result(['jump_url' => url('news/index')], 1, 'OK');
            } else {
                return $this->result('', 0, '新增失败');
            }
        }else {
            return $this->fetch('', [
                'cats' => config('cat.lists')
            ]);
        }
    }

    // 1、 id 获取记录所有数据 填充模板。  save([], ['id'=>$id])
}

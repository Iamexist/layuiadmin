<?php
namespace app\admin\controller;

// 活动模块
class Activity extends Base
{
    /**
     * 活动列表
     * @date 2020/11/4 17:17
     */
    public function activity_list() {
        $list = db('activity')->paginate(15,false,['query'=>$_GET]);
        $this->assign('list',$list->all());
        $this->assign('page',$list->render());
        return $this->fetch();
    }

    /**
     * 添加活动
     * @date 2020/11/4 17:29
     */
    public function add_activity() {
        if(request()->isPost()) {
            $time = explode('-',param_check('time'));
            $data = [
                'title'         => param_check('title'),
                'thumb'         => param_check('thumb'),
                'rule'          => param_check('rule'),
                'banner'        => param_check('banner'),
                'status'        => param_check('status'),
                'start_time'    => strtotime($time[0]),
                'end_time'      => strtotime($time[1]),
                'create_time'   => time(),
                'update_time'    => time()
            ];
            db('activity')->insert($data)?json_response(1,'添加成功'):json_response(2,'添加失败');
        }
        return $this->fetch();
    }

    /**
     * 修改活动
     * @date 2020/11/4 18:44
     */
    public function edit_activity(){
        $id = param_check('id');
        if(request()->isPost()) {
            $time = explode('-',param_check('time'));
            $data = [
                'title'         => param_check('title'),
                'thumb'         => param_check('thumb'),
                'rule'          => param_check('rule'),
                'banner'        => param_check('banner'),
                'status'        => param_check('status'),
                'start_time'    => strtotime($time[0]),
                'end_time'      => strtotime($time[1]),
                'update_time'    => time()
            ];
            db('activity')->where('id',$id)->update($data)?json_response(1,'修改成功'):json_response(2,'修改失败');
        }
        $data = db('activity')->where('id',$id)->find();
        $data['time'] = date('Y/m/d H:i:s',$data['start_time']).' - '.date('Y/m/d H:i:s',$data['end_time']);
        $this->assign('data',$data);
        return $this->fetch('add_activity');
    }

    /**
     * 删除活动
     * @date 2020/11/5 09:32
     */
    public function del_activity() {
        $id = param_check('id');
        db('activity')->where('id',$id)->delete()?json_response(1,'删除成功'):json_response(2,'删除失败');
    }
}
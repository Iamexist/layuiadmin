<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/5
 * Time: 9:59
 */

namespace app\__MODULE__\controller;


class Prize extends Base
{
    private $prize_key = 'thinksix:PrizeStock:'; //要和Activity.php文件下的奖品缓存队列一样!

    /**
     * 奖品列表
     * @date 2020/11/5 9:59
     */
    public function prize_list() {
        $list = db('activity_prize')
            ->paginate(15,false,['query'=>$_GET]);
        $this->assign('list',$list->all());
        $this->assign('page',$list->render());
        return $this->fetch();
    }

    /**
     * 添加奖品
     * @date 2020/11/5 10:01
     */
    public function add_prize() {
        if(request()->isPost()) {
            $data =[
                'activity_id'   => param_check('activity_id'),
                'prize_type'    => param_check('prize_type'),
                'status'        => param_check('status'),
                'prize_name'    => param_check('prize_name'),
                'prize_num'     => param_check('prize_num'),
                'day_num'       => param_check('day_num'),
                'win_radio'     => param_check('win_radio'),
                'sort'          => param_check('sort'),
                'prize_img'     => param_check('prize_img'),
                'add_time'      => time(),
                'edit_time'     => time()
            ];
            db('activity_prize')->insert($data)?json_response(1,'添加成功'):json_response(2,'添加失败');
        }
        $activity = db('activity')
            ->where('status',1)
            ->field('title,id')
            ->select();
        $this->assign('activity',$activity);
        return $this->fetch();
    }

    /**
     * 修改奖品
     * @date 2020/11/5 10:33
     */
    public function edit_prize() {
        $id = param_check('id');
        if(request()->isPost()){
            $data =[
                'activity_id'   => param_check('activity_id'),
                'prize_type'    => param_check('prize_type'),
                'status'        => param_check('status'),
                'prize_name'    => param_check('prize_name'),
                'prize_num'     => param_check('prize_num'),
                'day_num'       => param_check('day_num'),
                'win_radio'     => param_check('win_radio'),
                'sort'          => param_check('sort'),
                'prize_img'     => param_check('prize_img'),
                'edit_time'     => time()
            ];
            db('activity_prize')->where('id',$id)->update($data)?json_response(1,'修改成功'):json_response(2,'修改失败');
        }
        $activity = db('activity')
            ->where('status',1)
            ->field('title,id')
            ->select();
        $this->assign('activity',$activity);
        $data = db('activity_prize')->where('id',$id)->find();
        $this->assign('data',$data);
        return $this->fetch('add_prize');
    }

    /**
     * 删除奖品
     * @date 2020/11/5 10:38
     */
    public function del_prize() {
        $id = param_check('id');
        db('activity_prize')->where('id',$id)->delete()?json_response(1,'删除成功'):json_response(2,'删除成功');
    }

    /**
     * 添加库存
     * @date 2020/11/5 15:46
     */
    public function add_stock(){
        $id = param_check('id');
        if(request()->isPost()) {
            $number = param_check('number');
            $res = db('activity_prize')->where('id', $id)->setInc('prize_num', $number);
            $redis = redis_instance();
            for($i=1; $i<=$number; $i++) {
                $redis->lPush($this->prize_key.$id, 1);
            }
            $res ? json_response(1, '添加成功') : json_response(0, '添加失败');
        }else {
            return $this->fetch();
        }
    }
}
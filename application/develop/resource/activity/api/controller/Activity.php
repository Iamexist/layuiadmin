<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/5
 * Time: 10:41
 */

namespace app\api\controller;


class Activity extends Base
{
    /**
     * 奖品信息
     * @date 2020/11/5 10:42
     */
    public function prize_info() {
        //$user_id = $this->get_user_id();
        $activity = db('activity_prize')
            ->where('status',1)
            ->order('sort asc')
            ->field('id,prize_name,prize_img')
            ->select();
        json_response(1,'获取成功',$activity);
    }

    /**
     * 抽奖接口
     * @date 2020/11/5 10:59
     */
    public function luck_draw() {
        $redis      = redis_instance();
        $user_id = 1;//$this->get_user_id();//获取用户id
        $day_time = 3;//每日抽奖次数 没有既为0
        $today_date = date('Y-m-d');
        $activity_id = 1;//活动id
        $activity_name = 'thinksix';//redis名称
        $redis_lock_key     = $activity_name.":UserLock:{$user_id}"; // redis接口锁
        $redis_user_log_key = "{$activity_name}:Prizelog:{$user_id}:{$today_date}"; // redis用户抽奖次数
        //查询活动开始和结束时间
        $activity_time = db('activity')
            ->where('id',$activity_id)
            ->field('start_time,end_time')
            ->find();

        try {
            if (!$redis->exists($redis_lock_key)) {
                $redis->set($redis_lock_key, 1, 10);
                //查询是否在活动时间内
                if (time() > $activity_time['start_time'] && time() < $activity_time['end_time']) {
                    // 获取奖品列表
                    $prize_list = $this->get_prize_list();
                    //开始抽奖
                    shuffle($prize_list);
                    $prize_key = $this->get_rand($prize_list);
                    $prize = $prize_list[$prize_key];
                    // 循环奖品列表，去掉无库存奖品
                    foreach ($prize_list as $key => $item) {
                        // 判断奖品是否还有库存
                        if (!$redis->lLen("KoraDior:PrizeStock:{$item['prize_id']}")) {
                            unset($prize_list[$key]);
                            continue;
                        }
                        // 判断奖品日发放数
                        $day_send = $redis->get("KoraDior:PrizeSend:{$item['prize_id']}:$today_date");
                        if (empty($day_send)) $day_send = db('prize_log')->where([
                            'prize_id' => $item['prize_id'],
                            'add_time' => ['>', strtotime($today_date)]
                        ])->count();
                        if (!empty($item['day_number']) && $item['day_number'] <= $day_send) {
                            unset($prize_list[$key]);
                            continue;
                        }
                    }
                    //每日抽奖次数存入redis 如果达到每日抽奖次数则阻止抽奖
                    if ($redis->get($redis_user_log_key) < $day_time) {
                        $redis->incr("{$activity_name}:Prizelog:{$user_id}:{$today_date}");
                    } else {
                        json_response(2, '今日抽奖次数已用完');
                    }
                    //redis 奖品总数量-1
                    if ($redis->rPop("{$activity_name}:PrizeStock:{$prize['prize_id']}")) {
                        // 奖品日抽中次数
                        $redis->incr("{$activity_name}:PrizeSend:{$prize['prize_id']}:$today_date");

                        //中奖日志存入数据库
                        $prize_log_id = db('activity_prize_log')->insertGetId([
                            'activity_id' => $activity_id,
                            'user_id' => $user_id,
                            'prize_id' => $prize['prize_id'],
                            'prize_type' => $prize['prize_type'],
                            'create_time' => time()
                        ]);
                        $redis->del($redis_lock_key);
                        json_response(1, 'success', [
                            'prize_log_id' => $prize_log_id,
                            'prize_type' => $prize['prize_type'],
                            'prize_name' => $prize['prize_name'],
                            'prize_img' => $prize['prize_img'],
                        ]);
                    } else {
                        json_response(2, '没有抽中奖品哟~');
                    }
                } else {
                    json_response(2, '不在活动时间内');
                }
            } else {
                json_response(2, '请求过快');
            }
        }catch (\Exception $e){
            json_response(0, '接口错误', [
                'info' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }

    public function get_prize_list(){
        $redis      = redis_instance();
        $activity_name = 'thinksix';//redis名称
        if($redis->exists($activity_name.':prize_list')){
            $prize_list = json_decode($redis->get($activity_name.':prize_list'), true);
        }else{
            $prize_list = db('activity_prize')
                ->where('status', 1)
                ->field('id as prize_id,prize_name, prize_img, prize_num,day_num,win_radio,prize_type')
                ->order('sort ASC, id DESC')
                ->select();
            $redis->set($activity_name.':prize_list', json_encode($prize_list, JSON_UNESCAPED_UNICODE), 10);
        }
        return $prize_list;
    }

    /**
     * 抽奖算法
     * @param array $prize_list 奖品列表 奖品排序: 低概率->高概率
     * @return int|string
     * @date 2020/11/5 14:15
     */
    private function get_rand($prize_list=[]) {
        $result = '';
        // 概率数组的总概率精度
        $radioSum = array_sum(array_column($prize_list, 'win_radio'));
        //概率数组循环
        foreach ($prize_list as $key => $prize) {
            $randNum = mt_rand(1, $radioSum);
            if ($randNum <= $prize['win_radio']) {
                $result = $key;
                break;
            } else {
                $radioSum -= $prize['win_radio'];
            }
        }
        return $result;
    }
}
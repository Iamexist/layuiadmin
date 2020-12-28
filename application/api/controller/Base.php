<?php


namespace app\api\controller;

// 公共继承模块
class Base
{
    protected $openid; // 用户openid

    /**
     * 构造方法
     * Base constructor.
     */
    public function __construct() {

    }

    /**
     * 通过openid换取user_id并缓存
     * @return bool|mixed|string
     * @date 2020/8/15 18:50
     */
    public function get_user_id() {
        // 接收openid
        $this->openid = param_check('openid');

        // 读取redis缓存
        $redis_key  = "Openid_Cache:{$this->openid}";
        $redis      = redis_instance();
        $is_cache   = $redis->exists($redis_key);
        if($is_cache) return $redis->get($redis_key);

        // 验证openid真实性
        $user_id = db('user')->where('openid', $this->openid)->value('id as user_id');
        if(empty($user_id)) json_response(0, '用户不存在');

        // 设置redis缓存
        $redis->set($redis_key, $user_id, 6);

        // 返回用户ID
        return $user_id;
    }
}
<?php
db('mg_menu')
    ->whereOr("mg_module='{$mg_module}' and name = '活动管理'")
    ->whereOr("mg_module='{$mg_module}' and router = '{$mg_module}/Activity/activity_list'")
    ->whereOr("mg_module='{$mg_module}' and router = '{$mg_module}/Activity/add_activity'")
    ->whereOr("mg_module='{$mg_module}' and router = '{$mg_module}/Activity/edit_activity'")
    ->whereOr("mg_module='{$mg_module}' and router = '{$mg_module}/Activity/del_activity'")
    ->whereOr("mg_module='{$mg_module}' and router = '{$mg_module}/Prize/prize_list'")
    ->whereOr("mg_module='{$mg_module}' and router = '{$mg_module}/Prize/add_stock'")
    ->whereOr("mg_module='{$mg_module}' and router = '{$mg_module}/Prize/add_prize'")
    ->whereOr("mg_module='{$mg_module}' and router = '{$mg_module}/Prize/edit_prize'")
    ->whereOr("mg_module='{$mg_module}' and router = '{$mg_module}/Prize/del_prize'")
    ->whereOr("mg_module='{$mg_module}' and router = '{$mg_module}/Plog/prize_log'")
    ->delete();

$parent_id = db('mg_menu')->insertGetId([
    'mg_module'     => $mg_module,
    'name'          => '活动管理',
    'module'        => $mg_module,
    'router'        => "",
    'controller'    => '',
    'action'        => '',
    'icon'          => 'layui-icon-gift',
    'status'        => 1,
    'create_time'   => time()
]);

$activity_id = db('mg_menu')->insertGetId([
    'parent_id'     => $parent_id,
    'mg_module'     => $mg_module,
    'name'          => '活动列表',
    'module'        => $mg_module,
    'router'        => "{$mg_module}/Activity/activity_list",
    'controller'    => 'Activity',
    'action'        => 'activity_list',
    'icon'          => '',
    'status'        => 1,
    'sort'          => 1,
    'create_time'   => time()
]);

db('mg_menu')->insertGetId([
    'parent_id'     => $activity_id,
    'mg_module'     => $mg_module,
    'name'          => '添加活动',
    'module'        => $mg_module,
    'router'        => "{$mg_module}/Activity/add_activity",
    'controller'    => 'Activity',
    'action'        => 'add_activity',
    'icon'          => '',
    'status'        => 1,
    'sort'          => 1,
    'create_time'   => time()
]);

db('mg_menu')->insertGetId([
    'parent_id'     => $activity_id,
    'mg_module'     => $mg_module,
    'name'          => '修改活动',
    'module'        => $mg_module,
    'router'        => "{$mg_module}/Activity/edit_activity",
    'controller'    => 'Activity',
    'action'        => 'edit_activity',
    'icon'          => '',
    'status'        => 1,
    'sort'          => 2,
    'create_time'   => time()
]);

db('mg_menu')->insertGetId([
    'parent_id'     => $activity_id,
    'mg_module'     => $mg_module,
    'name'          => '删除活动',
    'module'        => $mg_module,
    'router'        => "{$mg_module}/Activity/del_activity",
    'controller'    => 'Activity',
    'action'        => 'del_activity',
    'icon'          => '',
    'status'        => 1,
    'sort'          => 3,
    'create_time'   => time()
]);

$prize_id = db('mg_menu')->insertGetId([
    'parent_id'     => $parent_id,
    'mg_module'     => $mg_module,
    'name'          => '奖品列表',
    'module'        => $mg_module,
    'router'        => "{$mg_module}/Prize/prize_list",
    'controller'    => 'Prize',
    'action'        => 'prize_list',
    'icon'          => '',
    'status'        => 1,
    'sort'          => 2,
    'create_time'   => time()
]);

db('mg_menu')->insertGetId([
    'parent_id'     => $prize_id,
    'mg_module'     => $mg_module,
    'name'          => '添加奖品',
    'module'        => $mg_module,
    'router'        => "{$mg_module}/Prize/add_prize",
    'controller'    => 'Prize',
    'action'        => 'add_prize',
    'icon'          => '',
    'status'        => 1,
    'sort'          => 1,
    'create_time'   => time()
]);
db('mg_menu')->insertGetId([
    'parent_id'     => $prize_id,
    'mg_module'     => $mg_module,
    'name'          => '添加库存',
    'module'        => $mg_module,
    'router'        => "{$mg_module}/Prize/add_stock",
    'controller'    => 'Prize',
    'action'        => 'add_stock',
    'icon'          => '',
    'status'        => 1,
    'sort'          => 2,
    'create_time'   => time()
]);

db('mg_menu')->insertGetId([
    'parent_id'     => $prize_id,
    'mg_module'     => $mg_module,
    'name'          => '修改奖品',
    'module'        => $mg_module,
    'router'        => "{$mg_module}/Prize/edit_prize",
    'controller'    => 'Prize',
    'action'        => 'edit_prize',
    'icon'          => '',
    'status'        => 1,
    'sort'          => 3,
    'create_time'   => time()
]);

db('mg_menu')->insertGetId([
    'parent_id'     => $prize_id,
    'mg_module'     => $mg_module,
    'name'          => '删除奖品',
    'module'        => $mg_module,
    'router'        => "{$mg_module}/Prize/del_prize",
    'controller'    => 'Prize',
    'action'        => 'edl_prize',
    'icon'          => '',
    'status'        => 1,
    'sort'          => 4,
    'create_time'   => time()
]);

$prize_id = db('mg_menu')->insertGetId([
    'parent_id'     => $parent_id,
    'mg_module'     => $mg_module,
    'name'          => '中奖日志',
    'module'        => $mg_module,
    'router'        => "{$mg_module}/Plog/prize_log",
    'controller'    => 'Plog',
    'action'        => 'prize_log',
    'icon'          => '',
    'status'        => 1,
    'sort'          => 3,
    'create_time'   => time()
]);
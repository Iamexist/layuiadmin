CREATE TABLE `__DB_PRE__activity`(
`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '活动ID',
`title` varchar(128) NOT NULL DEFAULT '' COMMENT '活动标题',
`thumb` varchar(128) NOT NULL DEFAULT '' COMMENT '活动列表图',
`rule` varchar(128) NOT NULL DEFAULT '' COMMENT '活动规则图',
`banner` text(0) NOT NULL DEFAULT '' COMMENT '活动banner图',
`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1:开启 2:关闭',
`join_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '参与人数统计',
`start_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
`end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
`create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
`update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
PRIMARY KEY (`id`),
KEY `status` (`status`),
KEY `start_time` (`start_time`),
KEY `end_time` (`end_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='活动表';

CREATE TABLE `__DB_PRE__activity_prize` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '奖品ID',
  `activity_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动ID',
  `prize_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '奖品类型 1.虚拟商品 2.实物商品',
  `prize_name` varchar(128) NOT NULL COMMENT '奖品名称',
  `prize_img` varchar(128) NOT NULL COMMENT '奖品图片',
  `prize_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '奖品数量',
  `day_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '奖品每日发放数量',
  `win_radio` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '中奖概率,百分比',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `edit_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '奖品状态 1-上架 2-下架',
  PRIMARY KEY (` id`),
  KEY `activity_id` (` activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动奖品表';

CREATE TABLE `__DB_PRE__activity_prize_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `prize_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '奖品ID',
  `prize_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '奖品类型',
  `data_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '留资ID',
  `status` tinyint(1) NOT NULL DEFAULT '2' COMMENT '状态 1-已领取 2-待领取 ',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '中奖时间',
  PRIMARY KEY (` id`),
  KEY `user_id` (` user_id`),
  KEY `activity_id` (` activity_id`),
  KEY `create_time` (` create_time`),
  KEY `prize_id` (` prize_id`),
  KEY `status` (` status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='活动奖品记录表';
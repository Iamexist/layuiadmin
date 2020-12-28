DROP TABLE IF EXISTS `__DB_PRE__user`;
CREATE TABLE `__DB_PRE__user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `openid` varchar(32) NOT NULL DEFAULT '' COMMENT '微信openid',
  `unionid` varchar(32) NOT NULL DEFAULT '' COMMENT '微信unionid',
  `nickname` varchar(86) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` varchar(164) NOT NULL DEFAULT '' COMMENT '头像',
  `mobile` varchar(16) NOT NULL DEFAULT '' COMMENT '授权手机号',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`),
  KEY (`unionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';
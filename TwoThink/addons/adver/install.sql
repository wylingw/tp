SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for twothink_adver
-- ----------------------------
DROP TABLE IF EXISTS `twothink_adver`;
CREATE TABLE `twothink_adver` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '广告位置名称',
  `type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '广告位置展示方式  0为默认展示一张',
  `width` char(20) NOT NULL DEFAULT '' COMMENT '广告位置宽度',
  `height` char(20) NOT NULL DEFAULT '' COMMENT '广告位置高度',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态（0：禁用，1：正常）',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告位置表';

-- ----------------------------
-- Table structure for twothink_advsr_details
-- ----------------------------
DROP TABLE IF EXISTS `twothink_advsr_details`;
CREATE TABLE `twothink_advsr_details` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '广告标题',
  `adver_id` int(11) NOT NULL COMMENT '广告位置',
  `img_id` int(11) NOT NULL DEFAULT '0' COMMENT '图片地址',
  `advstext` text COMMENT '文字广告内容',
  `advshtml` text COMMENT '代码广告内容',
  `link` char(140) NOT NULL DEFAULT '' COMMENT '链接地址',
  `level` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '优先级',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态（0：禁用，1：正常）',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告位列表详情';
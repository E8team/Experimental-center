-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-08-09 15:27:58
-- 服务器版本： 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `center`
--

-- --------------------------------------------------------

--
-- 表的结构 `e8_admin`
--

CREATE TABLE `e8_admin` (
  `admin_id` int(11) UNSIGNED NOT NULL,
  `admin_group_id` int(11) NOT NULL,
  `perm_group_id` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `qq` varchar(266) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `login_time` int(11) NOT NULL,
  `login_ip` varchar(255) NOT NULL,
  `login_state` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `login_num` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `root` smallint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_admin`
--

INSERT INTO `e8_admin` (`admin_id`, `admin_group_id`, `perm_group_id`, `account`, `password`, `name`, `sex`, `photo`, `email`, `qq`, `remarks`, `login_time`, `login_ip`, `login_state`, `login_num`, `root`) VALUES
(1, 1, '1', 'fxy', '0b57ef9c2509a9b78c253683746bf77d', '超级管理员', '男', 'photo/2014-08-16/53eecf7017186.jpg', 'admin@admin.com', '11111111', NULL, 1502033664, '0.0.0.0', 1, 400, 1),
(13, 1, '1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '', '', '', NULL, NULL, 1502260322, '0.0.0.0', 1, 6, 0);

-- --------------------------------------------------------

--
-- 表的结构 `e8_admin_group`
--

CREATE TABLE `e8_admin_group` (
  `admin_group_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `perm_group_id` varchar(1024) NOT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `useful` smallint(1) UNSIGNED NOT NULL DEFAULT '0',
  `root` smallint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_admin_group`
--

INSERT INTO `e8_admin_group` (`admin_group_id`, `name`, `perm_group_id`, `description`, `useful`, `root`) VALUES
(1, '超级管理员', '1', '该组的所有管理员都为超级管理员', 1, 1),
(2, '文章发布员', '4', '该分组下的所有管理员拥有文章发布权限', 1, 0),
(3, '主任邮箱', '5', '该分组下的管理员拥有对主任邮箱管理权限！', 1, 0),
(4, '投诉建议', '6', '改分组下的所有管理员拥有投诉建议管理权限！', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `e8_big_pic`
--

CREATE TABLE `e8_big_pic` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `describtion` varchar(500) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `sort_index` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `addtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_big_pic`
--

INSERT INTO `e8_big_pic` (`id`, `title`, `describtion`, `url`, `logo`, `sort_index`, `addtime`) VALUES
(14, '', '', '', 'image/20170806/5986b2961682f.jpg', 0, 1501999766),
(15, '', '', '', 'image/20170806/5986b5d93d418.jpg', 0, 1502000601),
(16, '测试标题', '测试描述', '', 'image/20170806/5986b5eebf320.jpg', 0, 1502000622),
(17, '', '', '', 'image/20170806/5986db678848d.jpg', 0, 1502010215),
(18, '', '', 'http://localhost/Experimental-center/index.php', 'image/20170807/5988002d2d56b.jpg', 0, 1502094402);

-- --------------------------------------------------------

--
-- 表的结构 `e8_channel`
--

CREATE TABLE `e8_channel` (
  `channel_id` int(11) UNSIGNED NOT NULL,
  `channel_key` varchar(50) NOT NULL COMMENT '内容模型关键词',
  `name` varchar(100) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT '1' COMMENT '是否开启',
  `addon_table` varchar(50) DEFAULT NULL COMMENT '附加表',
  `add_action` varchar(50) DEFAULT NULL COMMENT '添加内容模块',
  `edit_action` varchar(50) DEFAULT NULL COMMENT '编辑内容模块',
  `fields` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容模型表';

--
-- 转存表中的数据 `e8_channel`
--

INSERT INTO `e8_channel` (`channel_id`, `channel_key`, `name`, `is_open`, `addon_table`, `add_action`, `edit_action`, `fields`) VALUES
(1, 'article', '普通文章', 1, 'conArticle', '', '', '外部链接:redirect_url:text,文章内容:body:longtext'),
(2, 'picture', '图片集', 1, 'conPicture', '', '', '外部链接:redirect_url:text,图片集内容:body:longtext'),
(3, 'video', '视频', 1, 'conVideo', '', '', '视频内容:body:longtext'),
(4, 'file', '文件', 1, 'conFile', '', '', '文件内容:body:longtext'),
(5, 'special', '专题', 1, 'conSpecial', '', '', '专题内容:body:longtext');

-- --------------------------------------------------------

--
-- 表的结构 `e8_class`
--

CREATE TABLE `e8_class` (
  `class_id` int(11) UNSIGNED NOT NULL COMMENT '栏目ID',
  `father_id` int(11) DEFAULT NULL COMMENT '父栏目ID',
  `name` varchar(255) DEFAULT NULL COMMENT '栏目名称',
  `type` enum('Index','List','Url') DEFAULT NULL COMMENT '栏目类型（List：列表栏目，Index：频道栏目，Url：外部链接）',
  `channel_id` int(11) DEFAULT NULL COMMENT '频道ID',
  `url` varchar(255) DEFAULT NULL COMMENT '外部链接',
  `sort_index` smallint(6) DEFAULT NULL COMMENT '排序',
  `is_show` tinyint(1) DEFAULT '0' COMMENT '是否显示',
  `is_nav` tinyint(1) DEFAULT '0' COMMENT '是否设置为导航栏',
  `content` longtext COMMENT '内容',
  `content_template` int(11) DEFAULT NULL COMMENT '栏目内容模板',
  `index_template` int(11) DEFAULT NULL COMMENT '栏目封面模板'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_class`
--

INSERT INTO `e8_class` (`class_id`, `father_id`, `name`, `type`, `channel_id`, `url`, `sort_index`, `is_show`, `is_nav`, `content`, `content_template`, `index_template`) VALUES
(40, 0, '中心概括', 'List', 1, '', 0, 1, 1, '', 3, 2),
(41, 0, '实验队伍', 'List', 1, '', 0, 1, 1, '', 3, 2),
(42, 0, '实验教学', 'List', 1, '', 0, 1, 1, '', 3, 2),
(43, 0, '学科竞赛', 'List', 1, '', 0, 1, 1, '', 3, 2),
(44, 0, '设备维修', 'List', 1, '', 0, 1, 1, '', 3, 4),
(45, 0, '学习资源', 'List', 1, '', 0, 1, 1, '', 3, 4),
(57, 40, '中心简介', 'Index', 1, '', 0, 1, 1, '<p>\r\n	<span style=\"background-color:#FFFFFF;\">        中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介中心简介</span><span style=\"background-color:#FFFFFF;\">中心简介中心简介中心简介中心简介中心简介中心简介中心简介中心简介中心简介中心简介中心简介<span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span></span>\r\n</p>\r\n<p>\r\n	<span style=\"background-color:#FFFFFF;\">        <span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span></span>\r\n</p>\r\n<p>\r\n	<span style=\"background-color:#FFFFFF;\"><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span></span>\r\n</p>\r\n<p>\r\n	<span style=\"background-color:#FFFFFF;\">        <span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span></span>\r\n</p>\r\n<p>\r\n	<span style=\"background-color:#FFFFFF;\"><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span><span style=\"font-size:13.3333px;background-color:#FFFFFF;\">中心简介</span></span>\r\n</p>', 3, 4),
(47, 40, '实验室一览', 'List', 1, '', 0, 1, 1, '', 3, 2),
(48, 40, '规章制度', 'Index', 1, '', 0, 1, 1, '', 3, 4),
(49, 40, '业务流程', 'List', 1, '', 0, 1, 1, '', 3, 4),
(50, 41, '主人职责', 'List', 1, '', 0, 1, 1, '', 3, 4),
(51, 41, '中心人员', 'List', 1, '', 0, 1, 1, '', 3, 4),
(52, 42, '课表', 'List', 1, '', 0, 1, 1, '', 3, 4),
(53, 42, '试验项目', 'List', 1, '', 0, 1, 1, '', 3, 4),
(54, 43, '15年成果', 'List', 1, '', 0, 1, 1, '', 3, 4),
(55, 0, '通知公告', 'List', 1, '', 0, 0, 1, '', 3, 2),
(56, 0, '教学反馈', 'List', 1, '', 0, 0, 1, '', 3, 2);

-- --------------------------------------------------------

--
-- 表的结构 `e8_content`
--

CREATE TABLE `e8_content` (
  `content_id` int(11) UNSIGNED NOT NULL COMMENT '文章ID',
  `admin_id` int(11) NOT NULL COMMENT '管理员ID',
  `class_id` int(11) NOT NULL COMMENT '栏目ID',
  `channel_id` int(11) NOT NULL COMMENT '频道ID',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `author` varchar(100) NOT NULL COMMENT '作者',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键字',
  `addtime` date DEFAULT NULL COMMENT '添加时间',
  `uptime` int(11) DEFAULT NULL COMMENT '修改时间',
  `state` enum('check','publish','trash') DEFAULT 'check' COMMENT '状态',
  `picurl` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `views` smallint(6) DEFAULT '0' COMMENT '点击量',
  `sort_index` smallint(6) DEFAULT NULL COMMENT '排序',
  `source` varchar(255) DEFAULT NULL COMMENT '来源',
  `is_stick` tinyint(1) DEFAULT '0' COMMENT '是否置顶',
  `title_color` varchar(255) DEFAULT NULL COMMENT '标题颜色',
  `sticky_time` date DEFAULT NULL COMMENT '置顶到期时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_content`
--

INSERT INTO `e8_content` (`content_id`, `admin_id`, `class_id`, `channel_id`, `title`, `author`, `description`, `keywords`, `addtime`, `uptime`, `state`, `picurl`, `views`, `sort_index`, `source`, `is_stick`, `title_color`, `sticky_time`) VALUES
(2, 1, 55, 1, '通知公告测试', '', '通知公告测试通知公告测试通知公告测试通知公告测试', '', '2017-08-06', 1502033002, 'publish', NULL, 0, 0, '通知公告测试', 0, '#333333', '1970-01-01'),
(3, 1, 55, 1, '通知公告测试', '', '通知公告测试通知公告测试通知公告测试', '', '2017-08-06', 1502033026, 'publish', NULL, 0, 0, '', 0, '#333333', '1970-01-01'),
(4, 1, 55, 1, '通知公告测试通知公告测试', '', '通知公告测试', '', '2017-08-06', 1502033038, 'publish', NULL, 0, 0, '通知公告测试', 0, '#333333', '1970-01-01'),
(5, 1, 55, 1, '通知公告测试通知公告测试通知公告测试通知公告测试通知公', '', '通知公告测试', '', '2017-08-06', 1502033053, 'publish', NULL, 1, 0, '', 0, '#333333', '1970-01-01'),
(6, 13, 56, 1, '教学反馈测试', 'admin', '教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试', '', '2017-08-07', 1502085341, 'publish', NULL, 2, 0, '', 0, '#333333', '1970-01-01'),
(7, 13, 56, 1, '教学反馈测试', '', '教学反馈测试教学反馈测试教学反馈测试教学反馈测试', '', '2017-08-07', 1502085490, 'publish', NULL, 1, 0, '', 0, '#333333', '1970-01-01'),
(8, 13, 47, 1, '实验室一览测试实验室一览测试', '', '实验室一览测试实验室一览测试实验室一览测试实验室一览测试', '', '2017-08-07', 1502085887, 'publish', 'image/20170807/598802ffaa4ef.jpg', 31, 0, '', 0, '#333333', '1970-01-01'),
(9, 13, 47, 1, '实验室一览测试', '', '实验室一', '', '2017-08-07', 1502085941, 'publish', 'image/20170807/59880335d0566.jpg', 24, 0, '', 0, '#333333', '1970-01-01'),
(10, 13, 55, 1, '通知公共通知公共通知公共通知公共', '', '通知公共通知公共', '', '2017-08-07', 1502096096, 'publish', NULL, 0, 0, '', 0, '#333333', '1970-01-01'),
(11, 13, 55, 1, '通知公共通知公共', '', '通知公共通知公共', '', '2017-08-07', 1502096109, 'publish', NULL, 1, 0, '', 0, '#333333', '1970-01-01'),
(12, 13, 55, 1, '通知公共通知公共通知公共', '', '通知公共通知公共通知公共', '', '2017-08-07', 1502096120, 'publish', NULL, 4, 0, '', 0, '#333333', '1970-01-01'),
(13, 13, 55, 1, '通知公共通知公共通知公共', '', '通知公共通知公共通知公共', '', '2017-08-07', 1502096136, 'publish', NULL, 0, 0, '', 0, '#333333', '1970-01-01'),
(14, 13, 55, 1, '通知公共通知公共通知公共', '', '通知公共通知公共通知公共通知公共', '', '2017-08-07', 1502096148, 'publish', NULL, 0, 0, '', 0, '#333333', '1970-01-01'),
(15, 13, 55, 1, '通知公共通知公共', '', '通知公共通知公共', '', '2017-08-07', 1502096165, 'publish', NULL, 1, 0, '', 0, '#333333', '1970-01-01'),
(16, 13, 55, 1, '通知公共', 'admin', '通知公共通知公共', '', '2017-08-07', 1502096199, 'publish', NULL, 2, 0, '', 0, '#333333', '1970-01-01'),
(18, 13, 55, 1, '撒旦撒', '', '大撒大撒', '', '2017-08-08', 1502162891, 'publish', NULL, 2, 0, '', 0, '#333333', '1970-01-01'),
(19, 13, 55, 1, '大撒大撒', '', '上单', '', '2017-08-08', 1502162914, 'publish', NULL, 1, 0, '', 0, '#333333', '1970-01-01');

-- --------------------------------------------------------

--
-- 表的结构 `e8_con_article`
--

CREATE TABLE `e8_con_article` (
  `content_id` int(11) UNSIGNED NOT NULL COMMENT '内容ID',
  `class_id` int(11) DEFAULT NULL COMMENT '栏目ID',
  `url` varchar(255) DEFAULT NULL COMMENT '外部链接',
  `body` longtext COMMENT '文章内容'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_con_article`
--

INSERT INTO `e8_con_article` (`content_id`, `class_id`, `url`, `body`) VALUES
(2, 55, NULL, '通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试'),
(3, 55, NULL, '通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试'),
(4, 55, NULL, '通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试'),
(5, 55, NULL, '通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试通知公告测试'),
(6, 56, NULL, '教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试'),
(7, 56, NULL, '教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试教学反馈测试'),
(8, 47, NULL, '实验室一览测试实验室一览测试实验室一览测试实验室一览测试实验室一览测试实验室一览测试实验室一览测试实验室一览测试实验室一览测试'),
(9, 47, NULL, '实验室一览测试实验室一览测试实验室一览测试实验室一览测试实验室一览测试实验室一览测试实验室一览测试实验室一览测试实验室一览测试实验室一览测试'),
(10, 55, NULL, '通知公共通知公共通知公共通知公共'),
(11, 55, NULL, '通知公共通知公共通知公共通知公共通知公共'),
(12, 55, NULL, '通知公共通知公共通知公共通知公共通知公共'),
(13, 55, NULL, '通知公共通知公共通知公共通知公共'),
(14, 55, NULL, '通知公共通知公共通知公共通知公共通知公共'),
(15, 55, NULL, '通知公共通知公共通知公共通知公共'),
(16, 55, NULL, '通知公共通知公共通知公共通知公共'),
(19, 55, NULL, '的撒'),
(18, 55, NULL, '的撒啊啊啊啊啊啊啊啊啊');

-- --------------------------------------------------------

--
-- 表的结构 `e8_flink`
--

CREATE TABLE `e8_flink` (
  `flink_id` int(11) UNSIGNED NOT NULL COMMENT '友链ID',
  `type_id` int(11) DEFAULT NULL COMMENT '类型ID',
  `url` varchar(255) DEFAULT NULL COMMENT '链接地址',
  `webname` varchar(255) DEFAULT NULL COMMENT '网站名称',
  `logo` varchar(255) DEFAULT NULL COMMENT 'logo',
  `addtime` int(11) DEFAULT NULL COMMENT '添加时间',
  `sort_index` smallint(6) DEFAULT NULL COMMENT '排序'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_flink`
--

INSERT INTO `e8_flink` (`flink_id`, `type_id`, `url`, `webname`, `logo`, `addtime`, `sort_index`) VALUES
(87, 9, 'http://www.hnnu.edu.cn/', '淮南师范学院', NULL, 1502012400, 0),
(88, 9, 'http://www.hnnu.edu.cn/', '淮南师范学院', NULL, 1502012414, 0),
(89, 9, 'http://www.hnnu.edu.cn/', '淮南师范学院', NULL, 1502012422, 0),
(90, 9, 'http://www.hnnu.edu.cn/', '淮南师范学院', NULL, 1502012432, 0),
(91, 9, 'http://www.hnnu.edu.cn/', '淮南师范学院', NULL, 1502012443, 0);

-- --------------------------------------------------------

--
-- 表的结构 `e8_flink_type`
--

CREATE TABLE `e8_flink_type` (
  `type_id` int(10) UNSIGNED NOT NULL COMMENT '类型ID',
  `typename` varchar(255) DEFAULT NULL COMMENT '类型名称'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_flink_type`
--

INSERT INTO `e8_flink_type` (`type_id`, `typename`) VALUES
(9, '友情链接');

-- --------------------------------------------------------

--
-- 表的结构 `e8_log`
--

CREATE TABLE `e8_log` (
  `log_id` int(11) UNSIGNED NOT NULL COMMENT '日志id',
  `admin_id` int(11) NOT NULL COMMENT '管理员ID',
  `content` varchar(1024) DEFAULT NULL COMMENT '管理员操作内容',
  `time` int(11) UNSIGNED DEFAULT NULL COMMENT '日志时间',
  `type` varchar(50) DEFAULT NULL COMMENT '类型'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_log`
--

INSERT INTO `e8_log` (`log_id`, `admin_id`, `content`, `time`, `type`) VALUES
(1991, 1, 'fxy(超级管理员) 登入了后台', 1501999460, '1'),
(1992, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 中心概括,栏目ID为', 1502003864, '1'),
(1993, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 实验队伍,栏目ID为', 1502003922, '1'),
(1994, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 实验教学,栏目ID为', 1502003945, '1'),
(1995, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 学科竞赛,栏目ID为', 1502003960, '1'),
(1996, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 设备维修,栏目ID为', 1502003971, '1'),
(1997, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 学习资源,栏目ID为', 1502003982, '1'),
(1998, 1, 'fxy(超级管理员) 执行了修改网站设置操作,修改的网站设置名称为 ', 1502004206, '1'),
(1999, 1, 'fxy(超级管理员) 执行了修改网站设置操作,修改的网站设置名称为 ', 1502006606, '1'),
(2000, 1, 'fxy(超级管理员) 执行了删除网站设置操作,添加的网站设置ID为 131', 1502006613, '1'),
(2001, 1, 'fxy(超级管理员) 执行了添加网站设置操作,添加的网站设置名称为 ', 1502006856, '1'),
(2002, 1, 'fxy(超级管理员) 登入了后台', 1502011114, '1'),
(2003, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 中心简介,栏目ID为', 1502011179, '1'),
(2004, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 实验室一览,栏目ID为', 1502011206, '1'),
(2005, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 规章制度,栏目ID为', 1502011218, '1'),
(2006, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 业务流程,栏目ID为', 1502011235, '1'),
(2007, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 主人职责,栏目ID为', 1502011262, '1'),
(2008, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 中心人员,栏目ID为', 1502011279, '1'),
(2009, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 课表,栏目ID为', 1502011321, '1'),
(2010, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 试验项目,栏目ID为', 1502011332, '1'),
(2011, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 15年成果,栏目ID为', 1502011371, '1'),
(2012, 1, 'fxy(超级管理员) 执行了修改栏目操作,修改的栏目名称为 设备维修,栏目ID为44', 1502011400, '1'),
(2013, 1, 'fxy(超级管理员) 执行了修改栏目操作,修改的栏目名称为 学习资源,栏目ID为45', 1502011422, '1'),
(2014, 1, 'fxy(超级管理员) 执行了添加栏目操作,添加的栏目名称为 通知公告,栏目ID为', 1502011800, '1'),
(2015, 1, 'fxy(超级管理员) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 测试标题测试标题测试标题测', 1502011963, '1'),
(2016, 1, 'fxy(超级管理员) 执行了移动文章到回收站操作,共移动了篇文章', 1502011989, '1'),
(2017, 1, 'fxy(超级管理员) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 中心简介', 1502014204, '1'),
(2018, 1, 'fxy(超级管理员) 执行了移动文章到回收站操作,共移动了篇文章', 1502014282, '1'),
(2019, 1, 'fxy(超级管理员) 执行了还原文章操作,共还原了篇文章', 1502014292, '1'),
(2020, 1, 'fxy(超级管理员) 执行了移动文章到回收站操作,共移动了篇文章', 1502014336, '1'),
(2021, 1, 'fxy(超级管理员) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 测试标题', 1502014406, '1'),
(2022, 1, 'fxy(超级管理员) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 测试标题', 1502031264, '1'),
(2023, 1, 'fxy(超级管理员) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 简介测试', 1502031845, '1'),
(2024, 1, 'fxy(超级管理员) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 简介测试', 1502032889, '1'),
(2025, 1, 'fxy(超级管理员) 执行了移动文章到回收站操作,共移动了篇文章', 1502032894, '1'),
(2026, 1, 'fxy(超级管理员) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 简介测试', 1502032971, '1'),
(2027, 1, 'fxy(超级管理员) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 通知公告测试', 1502033003, '1'),
(2028, 1, 'fxy(超级管理员) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 通知公告测试', 1502033026, '1'),
(2029, 1, 'fxy(超级管理员) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 通知公告测试通知公告测试', 1502033038, '1'),
(2030, 1, 'fxy(超级管理员) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 通知公告测试通知公告测试通知公告测试通知公告测试通知公', 1502033053, '1'),
(2031, 13, 'admin(admin) 登入了后台', 1502033621, '1'),
(2032, 1, 'fxy(超级管理员) 登入了后台', 1502033664, '1'),
(2033, 13, 'admin(admin) 登入了后台', 1502083533, '1'),
(2034, 13, 'admin(admin) 执行了修改文章操作,修改的文章ID为 1,修改的文章标题为 简介测试', 1502083917, '1'),
(2035, 13, 'admin(admin) 执行了修改文章操作,修改的文章ID为 1,修改的文章标题为 简介测试', 1502085028, '1'),
(2036, 13, 'admin(admin) 登入了后台', 1502085143, '1'),
(2037, 13, 'admin(admin) 执行了添加栏目操作,添加的栏目名称为 教学反馈,栏目ID为', 1502085291, '1'),
(2038, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 教学反馈测试', 1502085341, '1'),
(2039, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 教学反馈测试', 1502085490, '1'),
(2040, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 实验室一览测试实验室一览测试', 1502085887, '1'),
(2041, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 实验室一览测试', 1502085941, '1'),
(2042, 13, 'admin(admin) 执行了修改文章操作,修改的文章ID为 1,修改的文章标题为 简介测试', 1502085962, '1'),
(2043, 13, 'admin(admin) 登入了后台', 1502094346, '1'),
(2044, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 通知公共通知公共通知公共通知公共', 1502096096, '1'),
(2045, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 通知公共通知公共', 1502096109, '1'),
(2046, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 通知公共通知公共通知公共', 1502096120, '1'),
(2047, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 通知公共通知公共通知公共', 1502096136, '1'),
(2048, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 通知公共通知公共通知公共', 1502096148, '1'),
(2049, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 通知公共通知公共', 1502096165, '1'),
(2050, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 通知公共', 1502096199, '1'),
(2051, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 中心简介,栏目ID为46', 1502114318, '1'),
(2052, 13, 'admin(admin) 执行了移动文章到回收站操作,共移动了篇文章', 1502116655, '1'),
(2053, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 简介测试', 1502116779, '1'),
(2054, 13, 'admin(admin) 执行了修改文章操作,修改的文章ID为 17,修改的文章标题为 简介测试', 1502117465, '1'),
(2055, 13, 'admin(admin) 执行了删除栏目操作,删除的栏目ID为 46', 1502117874, '1'),
(2056, 13, 'admin(admin) 执行了添加栏目操作,添加的栏目名称为 中心简介,栏目ID为', 1502117968, '1'),
(2057, 13, 'admin(admin) 登入了后台', 1502161646, '1'),
(2058, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 规章制度,栏目ID为48', 1502161670, '1'),
(2059, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 规章制度,栏目ID为48', 1502161709, '1'),
(2060, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 撒旦撒', 1502162891, '1'),
(2061, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 大撒大撒', 1502162914, '1'),
(2062, 13, 'admin(admin) 登入了后台', 1502260323, '1'),
(2063, 13, 'admin(admin) 执行了修改网站设置操作,修改的网站设置名称为 ', 1502260341, '1'),
(2064, 13, 'admin(admin) 执行了修改网站设置操作,修改的网站设置名称为 ', 1502260375, '1');

-- --------------------------------------------------------

--
-- 表的结构 `e8_menu`
--

CREATE TABLE `e8_menu` (
  `menu_id` int(11) UNSIGNED NOT NULL COMMENT '菜单ID',
  `father_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `name` varchar(100) DEFAULT '' COMMENT '菜单名称',
  `url` varchar(255) DEFAULT '' COMMENT '菜单地址',
  `icon` varchar(255) DEFAULT NULL,
  `target` varchar(20) DEFAULT '' COMMENT '响应位置',
  `is_open` tinyint(1) DEFAULT '1' COMMENT '是否开启功能',
  `sort_index` smallint(6) DEFAULT '0' COMMENT '功能排序'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

--
-- 转存表中的数据 `e8_menu`
--

INSERT INTO `e8_menu` (`menu_id`, `father_id`, `name`, `url`, `icon`, `target`, `is_open`, `sort_index`) VALUES
(1, 0, '内容管理', NULL, 'icomoon-icon-folder', 'menu', 1, 2),
(2, 0, '系统管理', NULL, 'icomoon-icon-cogs', 'menu', 1, 4),
(4, 0, '管理员管理', NULL, 'icomoon-icon-user-4', 'menu', 1, 1),
(11, 1, '模板管理', 'Template', 'icomoon-icon-pencil-2', 'main', 1, 0),
(12, 1, '文档管理', 'Content/index', 'icomoon-icon-newspaper', 'main', 1, 0),
(13, 1, '审核文章', 'Content/check', 'icomoon-icon-reading', 'main', 1, 0),
(14, 1, '文档回收站', 'Content/recycle', 'icomoon-icon-remove', 'main', 1, 5),
(15, 1, '栏目管理', 'Class', 'icomoon-icon-list-view', 'main', 1, 1),
(21, 2, '网站设置', 'Setting', 'icomoon-icon-wrench', '', 1, 0),
(22, 2, '日志管理', 'Log', ' icomoon-icon-shield', 'menu', 1, 0),
(24, 2, '友情链接管理', 'FlinkType', ' icomoon-icon-link', '', 1, 0),
(40, 4, '管理员分组管理', 'AdminGroup', 'icomoon-icon-users', '', 1, 0),
(41, 4, '管理员管理', 'Admin', 'icomoon-icon-user', '', 1, 0),
(42, 4, '权限管理', 'Permission', 'icomoon-icon-locked', '', 1, 0),
(43, 4, '权限组管理', 'PermGroup', ' icomoon-icon-key-2', '', 1, 0),
(72, 1, '首页大图配置', 'BigPic/index', 'icomoon-icon-newspaper', 'main', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `e8_permission`
--

CREATE TABLE `e8_permission` (
  `permission_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_permission`
--

INSERT INTO `e8_permission` (`permission_id`, `name`, `description`, `action`) VALUES
(19, '管理员显示', '', 'Admin/index'),
(20, '管理员添加', '', 'Admin/add'),
(21, '管理员修改', '', 'Admin/edit'),
(22, '管理员显示修改', '', 'Admin/showEditView'),
(23, '管理员删除', '', 'Admin/del'),
(24, '管理员分组显示', '', 'AdminGroup/index'),
(25, '管理员分组添加', '', 'AdminGroup/add'),
(26, '管理员分组修改', '', 'AdminGroup/edit'),
(27, '管理员分组删除', '', 'AdminGroup/del'),
(28, '栏目显示', '', 'Class/index'),
(29, '栏目添加', '', 'Class/add'),
(30, '栏目修改', '', 'Class/edit'),
(31, '栏目删除', '', 'Class/del'),
(32, '栏目树查看', '', 'Class/tree'),
(33, '栏目移动', '', 'Class/move'),
(34, '文章查看', '', 'Content/index'),
(35, '文章添加', '', 'Content/add'),
(36, '文章修改', '', 'Content/edit'),
(37, '文章审查', '', 'Content/checkout'),
(38, '文章还原', '', 'Content/restore'),
(39, '文章移动到回收站', '', 'Content/remove'),
(40, '文章审核列表', '', 'Content/check'),
(41, '文档永久删除', '', 'Content/delete'),
(42, '文档回收站', '', 'Content/recycle'),
(50, '日志显示', '', 'Log/index'),
(51, '日志删除', '', 'Log/del'),
(52, '权限分组显示', '', 'PermGroup/index'),
(53, '权限分组添加', '', 'PermGroup/add'),
(54, '权限显示', '', 'Permission/index'),
(55, '权限添加', '', 'Permission/add'),
(56, '权限修改', '', 'Permission/edit'),
(57, '权限删除', '', 'Permission/del'),
(58, '系统设置查看', '', 'Setting/index'),
(59, '网站设置添加', '', 'Setting/add'),
(60, '网站设置修改', '', 'Setting/edit'),
(61, '网站设置删除', '', 'Setting/del'),
(62, '模板查看', '', 'Template/index'),
(63, '模板添加', '', 'Template/add'),
(64, '模板修改', '', 'Template/edit'),
(65, '模板删除', '', 'Template/del'),
(66, '后台首页', '', 'Index/index'),
(67, '权限分组删除', '', 'PermGroup/del'),
(69, 'Ajax获取管理员对应权限分组', '', 'Admin/getPermGroupList'),
(70, 'Ajax验证账户', '', 'Admin/checkAccount'),
(71, 'Ajax验证邮箱', '', 'Admin/checkEmail'),
(72, 'Ajax改变分组状态', '调用Ajax请求，改变管理员分组的可用状态', 'AdminGroup/changeUseful'),
(73, '权限分组修改', '对权限分组进行修改', 'PermGroup/edit'),
(82, '首页大图配置', '首页大图配置', 'BigPic/index'),
(83, '添加首页大图', '添加首页大图', 'BigPic/add'),
(84, '编辑首页大图', '编辑首页大图', 'BigPic/edit'),
(85, '删除首页大图', '删除首页大图', 'BigPic/del');

-- --------------------------------------------------------

--
-- 表的结构 `e8_perm_group`
--

CREATE TABLE `e8_perm_group` (
  `perm_group_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `permission` varchar(1024) NOT NULL,
  `root` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_perm_group`
--

INSERT INTO `e8_perm_group` (`perm_group_id`, `name`, `description`, `permission`, `root`) VALUES
(1, '超级管理员权限组', '所有功能', 'Administrator', 1),
(4, '文章管理权限组', '该分组对应文章修改，添加，删除、栏目修改，添加，修改和删除等相关权限！', '66,42,41,36,37,40,34,35,39,38,30,31,28,32,29,33,83,84,82,85', 0);

-- --------------------------------------------------------

--
-- 表的结构 `e8_session`
--

CREATE TABLE `e8_session` (
  `session_id` int(255) UNSIGNED NOT NULL,
  `ip` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_session`
--

INSERT INTO `e8_session` (`session_id`, `ip`, `name`) VALUES
(48, '0.0.0.0', '8c78e9f72332ce136fe94bf99bfb9aa3');

-- --------------------------------------------------------

--
-- 表的结构 `e8_setting`
--

CREATE TABLE `e8_setting` (
  `setting_id` int(11) UNSIGNED NOT NULL COMMENT '设置项ID',
  `item` varchar(100) NOT NULL COMMENT '设置项',
  `value` varchar(255) DEFAULT '' COMMENT '设置值',
  `description` varchar(255) DEFAULT '' COMMENT '设置项描述',
  `type` enum('string','number','bool') DEFAULT 'string' COMMENT '设置\r\n\r\n字段类型'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站设置表';

--
-- 转存表中的数据 `e8_setting`
--

INSERT INTO `e8_setting` (`setting_id`, `item`, `value`, `description`, `type`) VALUES
(1, 'WEBNAME', '计算机公共基础实验中心', '网站名称', 'string'),
(130, 'EMAIL', 'XXXXXXXXXX@XX.com', '邮箱', 'string'),
(4, 'WEBAUTHOR', 'E8网络工作室', '网站作者', 'string'),
(6, 'INDEXURL', 'http://www.hnjr.gov.cn', '网站首页', 'string'),
(7, 'check_on', 'true', '是否开启审核文档', 'bool'),
(117, 'ADDRESS', '安徽省淮南市田家庵区洞山西路', '地址', 'string'),
(118, 'COPYRIGHT', 'copyright e8net 2017', '版权信息', 'string'),
(132, 'CONTACTS', 'XXXX', '联系人', 'string'),
(128, 'ZIPCODE', '232038', '邮编', 'string'),
(129, 'PHONE', '(1234)12345678', '联系方式', 'string');

-- --------------------------------------------------------

--
-- 表的结构 `e8_template`
--

CREATE TABLE `e8_template` (
  `template_id` int(11) UNSIGNED NOT NULL COMMENT '模板ID',
  `type` enum('index','content') DEFAULT 'index' COMMENT '模板类型（index：封面模板，content，内容模板）',
  `name` varchar(255) DEFAULT NULL COMMENT '模板名称',
  `url` varchar(255) DEFAULT NULL COMMENT '模板地址'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_template`
--

INSERT INTO `e8_template` (`template_id`, `type`, `name`, `url`) VALUES
(2, 'index', '通用列表模板', 'Home/List/index'),
(3, 'content', '通用文章内容模板', 'Home/Content/index'),
(4, 'index', '通用单页模板', 'Home/List/show');

-- --------------------------------------------------------

--
-- 表的结构 `e8_visit`
--

CREATE TABLE `e8_visit` (
  `vid` int(255) UNSIGNED NOT NULL,
  `ip` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '今日访问次数',
  `y` int(11) NOT NULL,
  `m` int(11) NOT NULL,
  `d` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `e8_visit`
--

INSERT INTO `e8_visit` (`vid`, `ip`, `time`, `view`, `y`, `m`, `d`) VALUES
(56328, '0.0.0.0', 1502011584, 1, 17, 8, 6),
(56329, '0.0.0.0', 1502083508, 2, 17, 8, 7),
(56330, '0.0.0.0', 1502161197, 1, 17, 8, 8),
(56331, '0.0.0.0', 1502256761, 1, 17, 8, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `e8_admin`
--
ALTER TABLE `e8_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `e8_admin_group`
--
ALTER TABLE `e8_admin_group`
  ADD PRIMARY KEY (`admin_group_id`);

--
-- Indexes for table `e8_big_pic`
--
ALTER TABLE `e8_big_pic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e8_channel`
--
ALTER TABLE `e8_channel`
  ADD PRIMARY KEY (`channel_id`);

--
-- Indexes for table `e8_class`
--
ALTER TABLE `e8_class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `e8_content`
--
ALTER TABLE `e8_content`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `e8_con_article`
--
ALTER TABLE `e8_con_article`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `e8_flink`
--
ALTER TABLE `e8_flink`
  ADD PRIMARY KEY (`flink_id`);

--
-- Indexes for table `e8_flink_type`
--
ALTER TABLE `e8_flink_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `e8_log`
--
ALTER TABLE `e8_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `e8_menu`
--
ALTER TABLE `e8_menu`
  ADD PRIMARY KEY (`menu_id`,`father_id`),
  ADD KEY `father_id` (`father_id`);

--
-- Indexes for table `e8_permission`
--
ALTER TABLE `e8_permission`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `e8_perm_group`
--
ALTER TABLE `e8_perm_group`
  ADD PRIMARY KEY (`perm_group_id`);

--
-- Indexes for table `e8_session`
--
ALTER TABLE `e8_session`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `e8_setting`
--
ALTER TABLE `e8_setting`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `item` (`item`);

--
-- Indexes for table `e8_template`
--
ALTER TABLE `e8_template`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `e8_visit`
--
ALTER TABLE `e8_visit`
  ADD PRIMARY KEY (`vid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `e8_admin`
--
ALTER TABLE `e8_admin`
  MODIFY `admin_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `e8_admin_group`
--
ALTER TABLE `e8_admin_group`
  MODIFY `admin_group_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `e8_big_pic`
--
ALTER TABLE `e8_big_pic`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- 使用表AUTO_INCREMENT `e8_channel`
--
ALTER TABLE `e8_channel`
  MODIFY `channel_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `e8_class`
--
ALTER TABLE `e8_class`
  MODIFY `class_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '栏目ID', AUTO_INCREMENT=58;
--
-- 使用表AUTO_INCREMENT `e8_content`
--
ALTER TABLE `e8_content`
  MODIFY `content_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章ID', AUTO_INCREMENT=20;
--
-- 使用表AUTO_INCREMENT `e8_con_article`
--
ALTER TABLE `e8_con_article`
  MODIFY `content_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '内容ID', AUTO_INCREMENT=20;
--
-- 使用表AUTO_INCREMENT `e8_flink`
--
ALTER TABLE `e8_flink`
  MODIFY `flink_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '友链ID', AUTO_INCREMENT=92;
--
-- 使用表AUTO_INCREMENT `e8_flink_type`
--
ALTER TABLE `e8_flink_type`
  MODIFY `type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '类型ID', AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `e8_log`
--
ALTER TABLE `e8_log`
  MODIFY `log_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '日志id', AUTO_INCREMENT=2065;
--
-- 使用表AUTO_INCREMENT `e8_menu`
--
ALTER TABLE `e8_menu`
  MODIFY `menu_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单ID', AUTO_INCREMENT=73;
--
-- 使用表AUTO_INCREMENT `e8_permission`
--
ALTER TABLE `e8_permission`
  MODIFY `permission_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- 使用表AUTO_INCREMENT `e8_perm_group`
--
ALTER TABLE `e8_perm_group`
  MODIFY `perm_group_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `e8_session`
--
ALTER TABLE `e8_session`
  MODIFY `session_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- 使用表AUTO_INCREMENT `e8_setting`
--
ALTER TABLE `e8_setting`
  MODIFY `setting_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '设置项ID', AUTO_INCREMENT=133;
--
-- 使用表AUTO_INCREMENT `e8_template`
--
ALTER TABLE `e8_template`
  MODIFY `template_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '模板ID', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `e8_visit`
--
ALTER TABLE `e8_visit`
  MODIFY `vid` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56332;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

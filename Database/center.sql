-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-08-13 17:00:53
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
(13, 1, '1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '', '', '', NULL, NULL, 1502629842, '0.0.0.0', 1, 0, 1);

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
(44, 0, '设备维修', 'List', 1, '', 0, 1, 1, '', 3, 2),
(45, 0, '学习资源', 'List', 1, '', 0, 1, 1, '', 3, 2),
(57, 40, '中心简介', 'Index', 1, '', 0, 1, 1, '<p>\r\n	<span style=\"background-color:#FFFFFF;\">实验室主要提供计算机教学，网上学习等教学服务。主要面向网络工程、计算机科学与技术、数字媒体、影视多媒体等专业。目前开出实验课程主要有C语言程序设计、数据结构、面向对象程序设计、JAVA程序设计、数据库原理、计算机网络原理、计算机操作系统、数字图像处理、多媒体技术等20余门课程，共计90多个实验项目。机房中的所有微机均能快速访问校园网上的资源和接入Internet，为教学过程提供了充足的软件和硬件保障。  </span>\r\n</p>\r\n<p>\r\n	<span style=\"background-color:#FFFFFF;\">为实现实验教学手段的多样性，今后将进一步完善和更新实验室设备和管理。以学生创新能力、科学素质培养为核心；以提高学生学习兴趣、思维能力以及良好的科学素养和作风方面为重点，进一步推动实验室开放工作，更好地体现因材施教、个性化培养的时代要求。建设好实验教学中心自主学习平台，积极开展多媒体CAI教学研究与实践，按照开放式教学的要求改进实验室管理信息系统的设计，充实网络辅助教学资源，为全面实现实验教学的开放管理提供保障，大幅度提高网络辅助教学系统的使用效益。强化服务意识与管理效率，打造具有人文精神特色的实验室文化系统，通过多种实验形式和现代化的教学手段，实现教学模式的多元化和教学内容的创新。</span>\r\n</p>\r\n<p>\r\n	<span style=\"background-color:#FFFFFF;\"><span style=\"background-color:#FFFFFF;\"></span><br />\r\n</span> \r\n</p>', 3, 4),
(47, 40, '实验室一览', 'List', 1, '', 0, 1, 1, '', 3, 2),
(48, 40, '规章制度', 'Index', 1, '', 0, 1, 1, '<p>\r\n	一、 实验任课教师有教书育人的责任和义务。老师上课时，应事先布置实验任务，做好实验准备，并配合实验室做好学生学习、教育和管理的工作。 \r\n</p>\r\n<p>\r\n	二、上机实验须“三到”：教师到、学生到、时间到，方可以进入机房，教师不得无故迟到、早退或缺席。  \r\n</p>\r\n<p>\r\n	三、 实验任课教师有保证上课时段实验室实验设备安全的责任和义务。上课期间，老师应督促学生遵守学生实验室使用守则和遵守实验室的各项规章制度。   \r\n</p>\r\n<p>\r\n	四、教师在实验上课过程中，不得擅自随意离开机房。\r\n</p>\r\n<p>\r\n	五、 教师应该辅导学生做好上机实验、监督学生不做与实验无关的事情。\r\n</p>\r\n<p>\r\n	六、如实验设备存在的软硬件问题，请及时通知实验室工作人员处理，不得擅自做格式化、开机箱、更换物件等处理。\r\n</p>\r\n<p>\r\n	七、 教师下课时请务必和实验室工作人员完备相关交接手续后方可离去。若实验设备上课期间出现遗失现象，应配合实验室进行调查和处理，并负有造成设备遗失的相应责任。\r\n</p>\r\n<p>\r\n	八、应遵守实验室的各项规章制度，主动配合实验室做好实验教学的运行和管理工作。\r\n</p>', 3, 4),
(49, 40, '业务流程', 'List', 1, '', 0, 1, 1, '', 3, 4),
(50, 41, '主人职责', 'Index', 1, '', 0, 1, 1, '<br />\r\n<p style=\"text-align:center;\">\r\n	<span style=\"font-size:16px;\">计算机机房管理员岗位职责  </span>\r\n</p>\r\n<p>\r\n	一、热爱本职工作，有良好的职业道德和服务意识，为师生上机实验提供优质服务。   \r\n</p>\r\n<p>\r\n	二、负责计算机实验室的使用管理，课前10分钟开门，课后及时关门。  \r\n</p>\r\n<p>\r\n	三、负责计算机实验室的设备管理，做好机房设备的保养和维护工作，确保机房设备始终处于良好状况，保证教学正常进行。   \r\n</p>\r\n<p>\r\n	四、负责每天对值班室及各实验室教师用机、服务器进行清洁，督促清洁员做好每周一次的全面清洁工作，使实验室及设备处于整洁状态。  \r\n</p>\r\n<p>\r\n	五、负责机房设备的调试、检修、软件安装等全面技术工作，发现机器故障及时处理，保证设备完好率大于90%。    \r\n</p>\r\n<p>\r\n	六、在保证机房按计划正常开放前提下，负责对学校办公用计算机提供维护、维修等技术服务。   \r\n</p>\r\n<p>\r\n	七、负责计算机实验室防火、防盗、防雷和安全用电工作，切实做好安全检查和记录，配合保卫部门做好安全防范工作；对使用实验室的老师和学生执行实验室安全制度的情况进行监督，加强师生的安全意识。    \r\n</p>\r\n<p>\r\n	八、本岗位实行坐班制，并能服从工作的需要，调整上、下班时间。    \r\n</p>\r\n<p>\r\n	九、服从分配，完成领导交给的各项任务。 \r\n</p>', 3, 4),
(51, 41, '中心人员', 'Index', 1, '', 0, 1, 1, '<div style=\"text-align:center;\">\r\n	<table style=\"width:80%;\" cellpadding=\"2\" cellspacing=\"0\" border=\"1\" bordercolor=\"#000000\">\r\n		<tbody>\r\n			<tr>\r\n				<td>\r\n					教师名称\r\n				</td>\r\n				<td>\r\n					XXXXXXX\r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					<span>教师名称</span><br />\r\n				</td>\r\n				<td>\r\n					XXXXXXX\r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					<span>教师名称</span><br />\r\n				</td>\r\n				<td>\r\n					XXXXXXX\r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					<span>教师名称</span><br />\r\n				</td>\r\n				<td>\r\n					XXXXXXX\r\n				</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n<br />\r\n<span id=\"__kindeditor_bookmark_start_11__\"></span>\r\n</div>\r\n<br />\r\n<br />\r\n<br />\r\n<br />', 3, 4),
(52, 42, '课表', 'Index', 1, '', 0, 1, 1, '', 3, 4),
(53, 42, '试验项目', 'List', 1, '', 0, 1, 1, '', 3, 2),
(54, 43, '15年成果', 'List', 1, '', 0, 1, 1, '', 3, 2),
(55, 0, '通知公告', 'List', 1, '', 0, 0, 1, '', 3, 2),
(56, 0, '教学反馈', 'List', 1, '', 0, 0, 1, '', 3, 2),
(58, 43, '16年成果', 'List', 1, '', 0, 1, 1, '', 3, 2);

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
-- 表的结构 `e8_learn_resources`
--

CREATE TABLE `e8_learn_resources` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `filedescribe` varchar(255) NOT NULL,
  `fileurl` varchar(255) NOT NULL,
  `addtime` date NOT NULL,
  `updatetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(14, 1, '文档回收站', 'Content/recycle', 'icomoon-icon-remove', 'main', 1, 5),
(15, 1, '栏目管理', 'Class', 'icomoon-icon-list-view', 'main', 1, 1),
(21, 2, '网站设置', 'Setting', 'icomoon-icon-wrench', '', 1, 0),
(22, 2, '日志管理', 'Log', ' icomoon-icon-shield', 'menu', 1, 0),
(24, 2, '友情链接管理', 'FlinkType', ' icomoon-icon-link', '', 1, 0),
(40, 4, '管理员分组管理', 'AdminGroup', 'icomoon-icon-users', '', 1, 0),
(41, 4, '管理员管理', 'Admin', 'icomoon-icon-user', '', 1, 0),
(42, 4, '权限管理', 'Permission', 'icomoon-icon-locked', '', 1, 0),
(43, 4, '权限组管理', 'PermGroup', ' icomoon-icon-key-2', '', 1, 0),
(72, 1, '首页大图配置', 'BigPic/index', 'icomoon-icon-newspaper', 'main', 1, 0),
(73, 1, '学习资源管理', 'Content/resources', 'icomoon-icon-reading', 'main', 1, 0);

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
(37, '学习资源管理', '', 'Content/resources'),
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
(85, '删除首页大图', '删除首页大图', 'BigPic/del'),
(86, '添加学习资源', '添加学习资源', 'Content/showLearnFrom'),
(87, '添加学习资源', '添加学习资源', 'Content/addLearn'),
(88, '学习资源管理', '', 'Content/editor_resources');

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
(4, '文章管理权限组', '该分组对应文章修改，添加，删除、栏目修改，添加，修改和删除等相关权限！', '66,42,41,36,37,40,34,35,39,38,30,31,28,32,29,33,83,84,82,85,86', 0);

-- --------------------------------------------------------

--
-- 表的结构 `e8_session`
--

CREATE TABLE `e8_session` (
  `session_id` int(255) UNSIGNED NOT NULL,
  `ip` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
-- Indexes for table `e8_learn_resources`
--
ALTER TABLE `e8_learn_resources`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `e8_channel`
--
ALTER TABLE `e8_channel`
  MODIFY `channel_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `e8_class`
--
ALTER TABLE `e8_class`
  MODIFY `class_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '栏目ID', AUTO_INCREMENT=59;
--
-- 使用表AUTO_INCREMENT `e8_content`
--
ALTER TABLE `e8_content`
  MODIFY `content_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章ID';
--
-- 使用表AUTO_INCREMENT `e8_con_article`
--
ALTER TABLE `e8_con_article`
  MODIFY `content_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '内容ID';
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
-- 使用表AUTO_INCREMENT `e8_learn_resources`
--
ALTER TABLE `e8_learn_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `e8_log`
--
ALTER TABLE `e8_log`
  MODIFY `log_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '日志id';
--
-- 使用表AUTO_INCREMENT `e8_menu`
--
ALTER TABLE `e8_menu`
  MODIFY `menu_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单ID', AUTO_INCREMENT=74;
--
-- 使用表AUTO_INCREMENT `e8_permission`
--
ALTER TABLE `e8_permission`
  MODIFY `permission_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- 使用表AUTO_INCREMENT `e8_perm_group`
--
ALTER TABLE `e8_perm_group`
  MODIFY `perm_group_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `e8_session`
--
ALTER TABLE `e8_session`
  MODIFY `session_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
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
  MODIFY `vid` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

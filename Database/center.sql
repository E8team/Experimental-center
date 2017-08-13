-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-08-13 09:51:14
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
(13, 1, '1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '', '', '', NULL, NULL, 1502604577, '0.0.0.0', 1, 14, 0);

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
(15, '', '', '', '20170813/598fed81b4162.jpg', 0, 1502604673),
(16, '', '', '', '20170813/598feda8b3b21.jpg', 0, 1502604712),
(17, '', '', '', '20170813/598fed6773630.jpg', 0, 1502604647);

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

--
-- 转存表中的数据 `e8_content`
--

INSERT INTO `e8_content` (`content_id`, `admin_id`, `class_id`, `channel_id`, `title`, `author`, `description`, `keywords`, `addtime`, `uptime`, `state`, `picurl`, `views`, `sort_index`, `source`, `is_stick`, `title_color`, `sticky_time`) VALUES
(1, 13, 45, 1, '文件上传a', '雷建a', '文件上传a', NULL, '2017-08-12', 1502546932, 'publish', NULL, 2, 0, NULL, 0, '', '0000-00-00'),
(2, 13, 45, 1, '文件上传aasd', 'asd', 'as文件上传a', NULL, '2017-08-12', 1502551857, 'publish', NULL, 0, 0, NULL, 0, '', '0000-00-00'),
(3, 13, 45, 1, '文件路径测试', '雷建', '文件路径测试', NULL, '2017-08-13', 1502554330, 'publish', NULL, 2, NULL, NULL, 0, NULL, '1970-01-01'),
(4, 13, 57, 1, '实验室', '雷建', '实验室实验室', '', '2017-08-13', 1502554446, 'trash', NULL, 0, 0, 'admin', 0, '#333333', '1970-01-01'),
(5, 13, 45, 1, '最后测试', '雷建', '最后测试', NULL, '2017-08-13', 1502554651, 'publish', NULL, 1, NULL, NULL, 0, NULL, '1970-01-01'),
(6, 13, 45, 1, '最后最后测试', '雷剑', '最后最后测试', NULL, '2017-08-13', 1502556403, 'publish', NULL, 1, NULL, NULL, 0, NULL, '1970-01-01'),
(7, 13, 45, 1, '再试一次', '雷建', '再试一次', NULL, '2017-08-13', 1502556477, 'publish', NULL, 1, NULL, NULL, 0, NULL, '1970-01-01'),
(8, 13, 45, 1, '最最后一次', '雷建', '最后一次', NULL, '2017-08-13', 1502556592, 'publish', NULL, 2, NULL, NULL, 0, NULL, '1970-01-01'),
(9, 13, 47, 1, '实验室一', 'admin', '实验室一', '实验室', '2017-08-13', 1502605076, 'publish', '20170813/598fef1459281.jpg', 0, 0, 'admin', 0, '#333333', '1970-01-01'),
(10, 13, 47, 1, '实验室二', 'admin', '实验室二', 'shi\'yan\'shi', '2017-08-13', 1502605769, 'publish', '20170813/598ff1c933d50.jpg', 0, 0, 'admin', 0, '#333333', '1970-01-01'),
(11, 13, 47, 1, '实验室三', 'admin', '实验室三', '', '2017-08-13', 1502605862, 'publish', '20170813/598ff226dd07f.jpg', 0, 0, 'admin', 0, '#333333', '1970-01-01'),
(12, 13, 55, 1, '关于2015-2016学年第二学期公共机房新装软件的通知', 'admin', '关于2015-2016学年第二学期公共机房新装软件的通知', '', '2017-08-13', 1502607092, 'publish', NULL, 2, 0, '', 0, '#333333', '1970-01-01'),
(13, 13, 55, 1, '学院公共机房计算机设备采购公告', 'admin', '学院公共机房计算机设备采购公告', '', '2017-08-13', 1502607179, 'publish', NULL, 0, 0, '', 0, '#333333', '1970-01-01'),
(14, 13, 55, 1, '关于2016-2017学年第二学期公共机房新装软件的通知', 'admin', '关于2016-2017学年第二学期公共机房新装软件的通知', '', '2017-08-13', 1502607247, 'publish', NULL, 0, 0, '', 0, '#333333', '1970-01-01'),
(15, 13, 55, 1, '关于计算机公共实验教学中心机房免费开放的通知', 'admin', '关于计算机公共实验教学中心机房免费开放的通知', '', '2017-08-13', 1502607284, 'publish', NULL, 0, 0, '', 0, '#333333', '1970-01-01'),
(16, 13, 55, 1, '关于2017-2018学年第二学期公共机房新装软件的通知', 'admin', '关于2017-2018学年第二学期公共机房新装软件的通知', '', '2017-08-13', 1502607333, 'publish', NULL, 0, 0, '', 0, '#333333', '1970-01-01');

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
(1, 45, NULL, '20170812/598f210b51361.zip'),
(2, 45, NULL, '20170812/598f211bcd6da.zip'),
(3, 45, NULL, '&lt;a href=&quot;__PUBLIC__/upload/20170813/598f28da915e3.zip&quot;&gt;文件路径测试&lt;/a&gt;'),
(4, 57, '', '<a class=\"ke-insertfile\" href=\"/Experimental-center/Public/kindeditor/attached/file/20170812/20170812181400_91974.txt\" target=\"_blank\">/Experimental-center/Public/kindeditor/attached/file/20170812/20170812181400_91974.txt</a>实验室实验室实验室<img src=\"/Experimental-center/Public/kindeditor/attached/image/20170812/20170812181327_32565.jpg\" alt=\"\" />'),
(5, 45, NULL, '&lt;a class=&quot;ke-insertfile&quot; href=&quot;__PUBLIC__/upload/20170813/598f2a1b8bdf0.zip&quot;&gt;最后测试&lt;/a&gt;'),
(6, 45, NULL, '<a href=\'20170813/598f30f3bd4b7.zip\'>最后最后测试</a>'),
(7, 45, NULL, '<a href=\'__PUBLIC__/upload/20170813/598f313e3367f.zip\'>再试一次</a>'),
(8, 45, NULL, '<a href=\'Public/upload/20170813/598f31b13f48b.zip\'>最后一次</a>'),
(9, 47, '', '<p>\r\n	此外本室还承担了针对全校学生的每年一次的《计算机应用基础》知识竞赛、承担了一年两次的全国计算机等级考试及省级计算机等级上机考试，在社会服务方面，主要承接了ATA公司的如各大银行及海航等各种招聘及如金融理财师、建造师等资格认证的无纸化考试，每年接待社会考生约8000余人次。\r\n</p>\r\n<p>\r\n	实验室现有专职工作人员5人，其中副教授1名、高级实验师1名、助教2名，技工1名，计算机基础实验室除承担全校非计算机专业的计算机公共课外，还承担了部分学院的专业课实验教学。\r\n</p>'),
(10, 47, '', '<p>\r\n	一、 实验任课教师有教书育人的责任和义务。老师上课时，应事先布置实验任务，做好实验准备，并配合实验室做好学生学习、教育和管理的工作。 &nbsp;\r\n</p>\r\n<p>\r\n	二、上机实验须“三到”：教师到、学生到、时间到，方可以进入机房，教师不得无故迟到、早退或缺席。&nbsp;\r\n</p>\r\n<p>\r\n	三、实验任课教师有保证上课时段实验室实验设备安全的责任和义务。上课期间，老师应督促学生遵守学生实验室使用守则和遵守实验室的各项规章制度。 四、教师在实验上课过程中，不得擅自随意离开机房。 &nbsp;\r\n</p>\r\n<p>\r\n	五、教师应该辅导学生做好上机实验、监督学生不做与实验无关的事情。\r\n</p>\r\n<p>\r\n	六、如实验设备存在的软硬件问题，请及时通知实验室工作人员处理，不得擅自做格式化、开机箱、更换物件等处理。\r\n</p>'),
(11, 47, NULL, '计算机科学与技术和软件工程专业相关实验室有微原接口实验室、计算机组成原理实验室、软件综合机房、网络工程实训室、网络安全实验室。<br />\r\n计算机组成原理实验室 &nbsp;计算机组成原理实验室始建于2005年，并于2011年完成补充建设，是信息工程学院计算机科学与技术专业的基础实验室之一。实验室现有主要设备有DVCC-C8JH 计算机组成原理与系统结构实验系统45套，ZY12103D型计算机组成原理。它主要面向计算机科学与技术专业等相关专业的学，为学生提供计算机硬件课程实验、计算机硬件课程设计、毕业设计及相关实验室项目开放的环境。计算机组成原理实验室目前主要承担了我院计算机科学与技术专业和软件工程专业的《计算机组成原理》、《计算机系统结构》等课程的实验教学任务。<br />\r\n网络工程实训室 &nbsp;网络实验室分为5个实验组，每个实验组包含：锐捷二层交换机S2126G二台，三层交换机S3550二台，锐捷R1762模块化多业务路由器四台，锐捷管理控制器一台 ，双网卡联想商务机四台。实验室较系统地提供网络原理、网络操作系统、组网技术、网络安全、网络管理等方面的实验，满足了验证性、综合性、设计性和演示性几种不同层次的实验要求。采用了锐捷科技有限公司的高校网络实验室方案，采取了目前流行的整体型网络架构，只需将计算机和服务器都连接在网络上，再加上实验室教学管理系统等就可以实现一系列实验和管理功能。<br />\r\n微原接口实验室 &nbsp;微原接口实验室始建于2005年，共有Dais-8086H+微机原理课接口技术实验设备45套，2011年实验室补充采购了ZY11203D型单片机、微机原理及接口技术实验箱20套。微原接口实验室是为了学生巩固所学理论知识，增强动手能力而建立的。目的是使学生在对计算机的操作所获得的知识的基础上，进一步提高认识，真正了解计算机的本质，从而能更有效地进行硬件和软件的维护及开发，并为后续课程打下坚实的基础。本实验室主要针对信息工程学院的计算机科学与技术、自动化专业、电子信息工程、机械设计制造及自动化专业学生的微原接口实验。<br />\r\n综合机房 &nbsp;计算机科学是一门实践性很强的学科，在计算机教学活动中，上机实验是非常重要的教学环节。我院软件综合教学实验室(简称综合机房)是一个基于全院的软件综合教学实验室。现有三个大机房，配备有计算机近300台，服务器6台，并已组建成局域网。软件实验室安装了常用程序设计软件、软件开发软件、分析设计建模软件及办公软件、数学软件、网络模拟软件和其它辅助软件。近年来，该实验室承担了计划内安排的各类计算机软件应用及开发的实验教学，课程设计和毕业设计。<br />'),
(12, 55, NULL, '<p class=\"vsbcontent_start\" style=\"text-indent:0em;font-size:14px;font-weight:bold;font-family:微软雅黑;text-align:justify;background-color:#FBFBFB;\">\r\n	各学院（部）：\r\n</p>\r\n<p style=\"text-indent:2em;font-size:14px;font-family:微软雅黑;text-align:justify;background-color:#FBFBFB;\">\r\n	为确保2015-2016学年第二学期计算机公共机房的正常使用，实验实训与校企合作管理中心（以下简称“中心”）将于近期开始对我校公共机房的计算机进行各类教学软件的安装，现将相关事项通知如下：\r\n</p>\r\n<p style=\"text-indent:2em;font-size:14px;font-family:微软雅黑;text-align:justify;background-color:#FBFBFB;\">\r\n	1．计算机基础类教学软件安装Windows 7（32位）和Office 2010及其它常用软件。\r\n</p>\r\n<p style=\"text-indent:2em;font-size:14px;font-family:微软雅黑;text-align:justify;background-color:#FBFBFB;\">\r\n	2．各学院（部）申请在公共机房安装的软件原则上为各学院（部）根据教学安排的公共课所需软件，若确实需要安装专业类软件，请担任该课程的任课教师提供软件并到我中心相关机房指导安装。\r\n</p>\r\n<p style=\"text-indent:2em;font-size:14px;font-family:微软雅黑;text-align:justify;background-color:#FBFBFB;\">\r\n	3．请各学院（部）务必于2016年1月6日前将《公共机房软件安装申请表》（见附件）及相关教学软件安装包（需要破解的还需提供软件破解包）提供给我中心。\r\n</p>\r\n<p style=\"text-indent:2em;font-size:14px;font-family:微软雅黑;text-align:justify;background-color:#FBFBFB;\">\r\n	备注：软件安装包由各院担任该课程的任课教师提供，且能在Windows 7（32位）操作系统下正常安装使用，未提供软件者将不能进行相应安装。一般情况下，同一类型的软件，学校将统一安装同一个版本。\r\n</p>\r\n<p style=\"text-indent:2em;font-size:14px;font-family:微软雅黑;text-align:justify;background-color:#FBFBFB;\">\r\n	4．由于计算机公共机房需要安装的教学软件涉及面广、数量大，敬请在日期截止前上交完毕，以免影响安装进度。我中心在汇总后，根据在各学院（部）申报情况，统一协调教师和机房后统一进行安装，逾期未交的，不再受理。\r\n</p>\r\n<p style=\"text-indent:2em;font-size:14px;font-family:微软雅黑;text-align:justify;background-color:#FBFBFB;\">\r\n	5．联系人：XXXX\r\n</p>'),
(13, 55, NULL, '<span style=\"font-family:&quot;font-size:18.6667px;background-color:#FFFFFF;\">按照项目采购要求，XXXXXXXX对公共机房计算机设备进行询价采购，欢迎符合条件的各潜在供应商参加本次招标。与本次招投标相关的事宜如下：</span><br />\r\n<span style=\"font-family:&quot;font-size:18.6667px;background-color:#FFFFFF;\">&nbsp;&nbsp; 一、招标项目简要说明：计算机15台、桌凳8套等</span><br />\r\n<span style=\"font-family:&quot;font-size:18.6667px;background-color:#FFFFFF;\">&nbsp;&nbsp; 二、供应商资质要求：</span><br />\r\n<span style=\"font-family:&quot;font-size:18.6667px;background-color:#FFFFFF;\">&nbsp;&nbsp; ①具备独立的法人资格，符合《中华人民共和国政府采购法》规定供应商基本条件；</span><br />\r\n<span style=\"font-family:&quot;font-size:18.6667px;background-color:#FFFFFF;\">&nbsp;&nbsp; ②具备中华人民共和国工商部门颁发的有效期内按时年检营业执照副本，注册资金100万元（含100万元）以上且经营范围包含本次招标项目；</span><br />\r\n<span style=\"font-family:&quot;font-size:18.6667px;background-color:#FFFFFF;\">&nbsp;&nbsp; ③投标人必须由法定代表人或授权代表（委托代理人）参加开标仪式，并携带法定代表人证书（本人参加时）或授权委托书（代理人参加时）及本人身份证原件；</span><br />\r\n<span style=\"font-family:&quot;font-size:18.6667px;background-color:#FFFFFF;\">&nbsp;&nbsp; ④具有良好的商业信誉和健全的财务会计制度；</span><br />\r\n<span style=\"font-family:&quot;font-size:18.6667px;background-color:#FFFFFF;\">&nbsp;&nbsp; ⑤本项目不接受联合体投标。</span>'),
(14, 55, NULL, '为更好的保障教学工作的顺利进行，确保2016-2017学年第二学期计算机公共机房的正常使用，网络信息中心将于近期开始对我院公共机房的计算机进行各类教学软件的安装，现将相关事项通知如下：<br />\r\n1、计算机基础类教学软件安装Windows 7（32位）和Office 2010及其他常用软件。<br />\r\n2、各系部申请在公共机房安装的软件原则上为各系部教学安排的公共课所需软件，若确实需要安装专业类软件则必需教授相关课程的专业教师到网络信息中心配合安装。<br />\r\n3、请各教学系（部）务必于2016年12月30日前将需要在公共机房安装的软件安装申请表（见附件）及相关教学软件安装包（需要破解的还需提供软件破解包）提供给网络信息中心。<br />\r\n备注：软件安装包由各系授课教师自己提供且所交的教学软件安装包必须保证能正常使用，未提供软件者将不能进行相应安装。由于公共机房操作系统均为32位操作系统，所提供的软件安装包必须是能在Windows 7（32位）操作系统下运行的。一般情况下，同一类型的软件，只允许安装一个版本。<br />\r\n4、由于计算机公共机房需要安装的教学软件面广、量大、安装需要较长的时间，因此由网络中心人员在各系上交教学用软件后进行统一安装，逾期未交，不再受理。<br />'),
(15, 55, NULL, '<p style=\"color:#333333;font-size:14px;font-family:helvetica, arial, sans-serif, 宋体, 新宋体;text-indent:2em;background-color:#FFFFFF;\">\r\n	<span style=\"font-size:19px;font-family:宋体;\">计算机是信息社会必不可少的工具，熟练掌握计算机基本知识与基本操作，是学习和工作中的一项基本技能。为了提高我校大学生计算机操作实践能力，计算机公共实验中心从通知之日开始，将免费对本校学生开放，我校学生可凭校园一卡通等有效证件免费进行计算机基础知识、办公软件、程序设计、计算机等级考试模拟训练、多种专业软件的操作与实践。</span>\r\n</p>\r\n<p style=\"color:#333333;font-size:14px;font-family:helvetica, arial, sans-serif, 宋体, 新宋体;text-indent:38px;background-color:#FFFFFF;\">\r\n	<strong><span style=\"font-size:19px;font-family:宋体;\">开放时间：</span></strong><span style=\"font-size:19px;font-family:宋体;\">周一至周四</span><span style=\"font-size:19px;font-family:宋体;\">白天上班时间、晚上</span><span style=\"font-size:19px;\"><span style=\"font-size:14px;font-family:calibri;\">19:00</span></span><span style=\"font-size:19px;font-family:宋体;\">—</span><span style=\"font-size:19px;\"><span style=\"font-size:14px;font-family:calibri;\">21:00</span></span><span style=\"font-size:19px;font-family:宋体;\">（节假日除外）</span>\r\n</p>\r\n<p style=\"color:#333333;font-size:14px;font-family:helvetica, arial, sans-serif, 宋体, 新宋体;text-indent:38px;background-color:#FFFFFF;\">\r\n	<strong><span style=\"font-size:19px;font-family:宋体;\">开放机房</span></strong><span style=\"font-size:19px;font-family:宋体;\">：计算机公共实验中心</span><span style=\"font-size:19px;\"><span style=\"font-size:14px;font-family:calibri;\">403</span></span><span style=\"font-size:19px;font-family:宋体;\">机房</span>\r\n</p>'),
(16, 55, NULL, '为更好的保障教学工作的顺利进行，确保2016-2017学年第二学期计算机公共机房的正常使用，网络信息中心将于近期开始对我院公共机房的计算机进行各类教学软件的安装，现将相关事项通知如下：<br />\r\n1、计算机基础类教学软件安装Windows 7（32位）和Office 2010及其他常用软件。<br />\r\n2、各系部申请在公共机房安装的软件原则上为各系部教学安排的公共课所需软件，若确实需要安装专业类软件则必需教授相关课程的专业教师到网络信息中心配合安装。<br />\r\n3、请各教学系（部）务必于2016年12月30日前将需要在公共机房安装的软件安装申请表（见附件）及相关教学软件安装包（需要破解的还需提供软件破解包）提供给网络信息中心。<br />\r\n备注：软件安装包由各系授课教师自己提供且所交的教学软件安装包必须保证能正常使用，未提供软件者将不能进行相应安装。由于公共机房操作系统均为32位操作系统，所提供的软件安装包必须是能在Windows 7（32位）操作系统下运行的。一般情况下，同一类型的软件，只允许安装一个版本。<br />\r\n4、由于计算机公共机房需要安装的教学软件面广、量大、安装需要较长的时间，因此由网络中心人员在各系上交教学用软件后进行统一安装，逾期未交，不再受理。<br />');

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

--
-- 转存表中的数据 `e8_learn_resources`
--

INSERT INTO `e8_learn_resources` (`id`, `title`, `author`, `filedescribe`, `fileurl`, `addtime`, `updatetime`) VALUES
(1, 'asda', 'asd', 'asd', 'file/20170811/598db8bd1b9cf.zip', '2017-08-11', 1502460092),
(2, 'asda', 'asd', 'asd', 'file/20170811/598db8c695e4d.zip', '2017-08-11', 1502460102),
(3, '阿斯顿', 's\'da', '大苏打', 'file/20170811/598db8e80ff56.zip', '2017-08-11', 1502460135);

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
(2064, 13, 'admin(admin) 执行了修改网站设置操作,修改的网站设置名称为 ', 1502260375, '1'),
(2065, 13, 'admin(admin) 登入了后台', 1502289369, '1'),
(2066, 13, 'admin(admin) 执行了修改文章操作,修改的文章ID为 19,修改的文章标题为 大撒大撒', 1502289456, '1'),
(2067, 13, 'admin(admin) 执行了修改文章操作,修改的文章ID为 19,修改的文章标题为 大撒大撒', 1502289714, '1'),
(2068, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 文件测试', 1502290210, '1'),
(2069, 13, 'admin(admin) 执行了修改文章操作,修改的文章ID为 20,修改的文章标题为 文件测试', 1502290282, '1'),
(2070, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 简介测试', 1502290643, '1'),
(2071, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 中心简介,栏目ID为57', 1502290750, '1'),
(2072, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 学习资源,栏目ID为45', 1502290937, '1'),
(2073, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 啊实打实的', 1502291059, '1'),
(2074, 13, 'admin(admin) 登入了后台', 1502340166, '1'),
(2075, 13, 'admin(admin) 执行了修改文章操作,修改的文章ID为 22,修改的文章标题为 啊实打实的', 1502340225, '1'),
(2076, 13, 'admin(admin) 登入了后台', 1502347567, '1'),
(2077, 13, 'admin(admin) 登入了后台', 1502368871, '1'),
(2078, 13, 'admin(admin) 登入了后台', 1502428343, '1'),
(2079, 13, 'admin(admin) 登入了后台', 1502432552, '1'),
(2080, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 da', 1502465522, '1'),
(2081, 13, 'admin(admin) 登入了后台', 1502516960, '1'),
(2082, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502517470, '1'),
(2083, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 asd', 1502517872, '1'),
(2084, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 asd', 1502517988, '1'),
(2085, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502518859, '1'),
(2086, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502519020, '1'),
(2087, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502519390, '1'),
(2088, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502520591, '1'),
(2089, 13, 'admin(admin) 执行了移动文章到回收站操作,共移动了篇文章', 1502520611, '1'),
(2090, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502520625, '1'),
(2091, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502520715, '1'),
(2092, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502530613, '1'),
(2093, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502531560, '1'),
(2094, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502531919, '1'),
(2095, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502531963, '1'),
(2096, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502532104, '1'),
(2097, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502532186, '1'),
(2098, 13, 'admin(admin) 执行了移动文章到回收站操作,共移动了篇文章', 1502532198, '1'),
(2099, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502532222, '1'),
(2100, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502532370, '1'),
(2101, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502536143, '1'),
(2102, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502536255, '1'),
(2103, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502536351, '1'),
(2104, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502536925, '1'),
(2105, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 ', 1502537137, '1'),
(2106, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 文件上传', 1502546932, '1'),
(2107, 13, 'admin(admin) 执行了移动文章到回收站操作,共移动了篇文章', 1502550963, '1'),
(2108, 13, 'admin(admin) 执行了还原文章操作,共还原了篇文章', 1502550970, '1'),
(2109, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 文件上传', 1502551857, '1'),
(2110, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 文件上传a', 1502552331, '1'),
(2111, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 文件上传aasd', 1502552347, '1'),
(2112, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 文件路径测试', 1502554330, '1'),
(2113, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 实验室', 1502554410, '1'),
(2114, 13, 'admin(admin) 执行了修改文章操作,修改的文章ID为 4,修改的文章标题为 实验室', 1502554446, '1'),
(2115, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 最后测试', 1502554651, '1'),
(2116, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 最后最后测试', 1502556403, '1'),
(2117, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 再试一次', 1502556478, '1'),
(2118, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 最最后一次', 1502556593, '1'),
(2119, 13, 'admin(admin) 登入了后台', 1502604577, '1'),
(2120, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 中心简介,栏目ID为57', 1502604837, '1'),
(2121, 13, 'admin(admin) 执行了移动文章到回收站操作,共移动了篇文章', 1502604918, '1'),
(2122, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 实验室一', 1502605043, '1'),
(2123, 13, 'admin(admin) 执行了修改文章操作,修改的文章ID为 9,修改的文章标题为 实验室一', 1502605076, '1'),
(2124, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 实验室二', 1502605662, '1'),
(2125, 13, 'admin(admin) 执行了修改文章操作,修改的文章ID为 10,修改的文章标题为 实验室二', 1502605769, '1'),
(2126, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 实验室三', 1502605862, '1'),
(2127, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 规章制度,栏目ID为48', 1502606171, '1'),
(2128, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 主人职责,栏目ID为50', 1502606393, '1'),
(2129, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 中心人员,栏目ID为51', 1502606564, '1'),
(2130, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 中心人员,栏目ID为51', 1502606671, '1'),
(2131, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 课表,栏目ID为52', 1502606739, '1'),
(2132, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 试验项目,栏目ID为53', 1502606755, '1'),
(2133, 13, 'admin(admin) 执行了添加栏目操作,添加的栏目名称为 16年比赛成果,栏目ID为', 1502606813, '1'),
(2134, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 16年成果,栏目ID为58', 1502606829, '1'),
(2135, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 设备维修,栏目ID为44', 1502606850, '1'),
(2136, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 关于2015-2016学年第二学期公共机房新装软件的通知', 1502607092, '1'),
(2137, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 学院公共机房计算机设备采购公告', 1502607179, '1'),
(2138, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 关于2016-2017学年第二学期公共机房新装软件的通知', 1502607247, '1'),
(2139, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 关于计算机公共实验教学中心机房免费开放的通知', 1502607284, '1'),
(2140, 13, 'admin(admin) 执行了添加文章操作,添加的文章ID为 ,添加的文章标题为 关于2017-2018学年第二学期公共机房新装软件的通知', 1502607333, '1'),
(2141, 13, 'admin(admin) 执行了修改栏目操作,修改的栏目名称为 15年成果,栏目ID为54', 1502607401, '1');

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
(56331, '0.0.0.0', 1502256761, 2, 17, 8, 9),
(56332, '0.0.0.0', 1502340156, 3, 17, 8, 10),
(56333, '0.0.0.0', 1502427666, 2, 17, 8, 11),
(56334, '0.0.0.0', 1502513591, 1, 17, 8, 12),
(56335, '0.0.0.0', 1502604537, 1, 17, 8, 13);

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
  MODIFY `class_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '栏目ID', AUTO_INCREMENT=59;
--
-- 使用表AUTO_INCREMENT `e8_content`
--
ALTER TABLE `e8_content`
  MODIFY `content_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章ID', AUTO_INCREMENT=17;
--
-- 使用表AUTO_INCREMENT `e8_con_article`
--
ALTER TABLE `e8_con_article`
  MODIFY `content_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '内容ID', AUTO_INCREMENT=17;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `e8_log`
--
ALTER TABLE `e8_log`
  MODIFY `log_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '日志id', AUTO_INCREMENT=2142;
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
  MODIFY `vid` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56336;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

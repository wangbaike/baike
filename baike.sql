-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 12 月 21 日 22:54
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `baike`
--

-- --------------------------------------------------------

--
-- 表的结构 `bk_fun`
--

CREATE TABLE IF NOT EXISTS `bk_fun` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `signId` char(32) NOT NULL COMMENT '唯一签名',
  `age` tinyint(3) DEFAULT '0' COMMENT '年龄',
  `content` varchar(1000) NOT NULL COMMENT '内容',
  `fromUrl` varchar(300) DEFAULT NULL COMMENT '来源地址',
  `fromSite` varchar(50) DEFAULT NULL COMMENT '来源网站',
  `addTime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `signId` (`signId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

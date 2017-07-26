# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: app.doomeye.com (MySQL 5.5.38-0ubuntu0.12.04.1)
# Database: my_openid
# Generation Time: 2015-06-22 01:53:49 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table gconfig
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gconfig`;

CREATE TABLE `gconfig` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `config_name` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `int_value` int(11) DEFAULT NULL,
  `float_value` float DEFAULT NULL,
  `string_value` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



# Dump of table glog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `glog`;

CREATE TABLE `glog` (
  `stamp` datetime NOT NULL,
  `content` varchar(1000) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table greclaim
# ------------------------------------------------------------

DROP TABLE IF EXISTS `greclaim`;

CREATE TABLE `greclaim` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reclaim_token` varchar(100) NOT NULL DEFAULT '',
  `is_used` int(11) NOT NULL DEFAULT '0',
  `reclaim_stamp` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table grequest
# ------------------------------------------------------------

DROP TABLE IF EXISTS `grequest`;

CREATE TABLE `grequest` (
  `user_id` int(11) unsigned NOT NULL,
  `session_id` varchar(100) NOT NULL DEFAULT '',
  `redirect_url` varchar(200) NOT NULL DEFAULT '',
  `access_token` varchar(100) NOT NULL DEFAULT '',
  `access_content` varchar(100) NOT NULL DEFAULT '',
  `access_stamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table gsession
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gsession`;

CREATE TABLE `gsession` (
  `user_id` int(11) unsigned NOT NULL,
  `session_id` varchar(100) NOT NULL DEFAULT '',
  `user_host` varchar(100) NOT NULL DEFAULT '',
  `user_port` int(11) NOT NULL,
  `user_language` varchar(100) NOT NULL DEFAULT '',
  `session_stamp` datetime NOT NULL,
  `session_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table guser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `guser`;

CREATE TABLE `guser` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nickname` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `create_stamp` datetime NOT NULL,
  `email_address` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `registry_from_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

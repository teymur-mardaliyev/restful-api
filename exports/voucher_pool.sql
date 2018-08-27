# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.33)
# Database: voucher_pool
# Generation Time: 2018-08-27 03:14:04 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table recipient
# ------------------------------------------------------------

DROP TABLE IF EXISTS `recipient`;

CREATE TABLE `recipient` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_index` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table special_offer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `special_offer`;

CREATE TABLE `special_offer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `discount` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_index` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table voucher_code
# ------------------------------------------------------------

DROP TABLE IF EXISTS `voucher_code`;

CREATE TABLE `voucher_code` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(60) DEFAULT NULL,
  `recipient_id` int(11) unsigned DEFAULT NULL,
  `offer_id` int(11) unsigned DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `is_used` tinyint(1) DEFAULT NULL,
  `used_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recipient_idex` (`recipient_id`),
  KEY `offer_index` (`offer_id`),
  CONSTRAINT `FK_Recipient` FOREIGN KEY (`recipient_id`) REFERENCES `recipient` (`id`),
  CONSTRAINT `FK_SpecialOffer` FOREIGN KEY (`offer_id`) REFERENCES `special_offer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.34)
# Database: facie_app
# Generation Time: 2014-08-21 21:22:09 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table facie_data_mentoren
# ------------------------------------------------------------

DROP TABLE IF EXISTS `facie_data_mentoren`;

CREATE TABLE `facie_data_mentoren` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mentor_naam` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `mentor_email` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `mentor_woonplaats` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `mentor_telefoon` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `mentor_datum` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mentor_studie` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `mentor_stukje` text COLLATE utf8_unicode_ci NOT NULL,
  `mentor_hash` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `mentor_foto` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `checked` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table facie_data_nullen
# ------------------------------------------------------------

DROP TABLE IF EXISTS `facie_data_nullen`;

CREATE TABLE `facie_data_nullen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nul_naam` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `nul_email` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `nul_woonplaats` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `nul_telefoon` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `nul_datum` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nul_stukje` text COLLATE utf8_unicode_ci NOT NULL,
  `nul_hash` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `nul_foto` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `checked` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nul_studie` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table facie_export_mentoren
# ------------------------------------------------------------

DROP TABLE IF EXISTS `facie_export_mentoren`;

CREATE TABLE `facie_export_mentoren` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `export_mentor_naam` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `export_mentor_email` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table facie_export_nullen
# ------------------------------------------------------------

DROP TABLE IF EXISTS `facie_export_nullen`;

CREATE TABLE `facie_export_nullen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `export_nul_naam` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `export_nul_email` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `export_nul_woonplaats` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `export_nul_telefoon` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `export_nul_studie` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `export_nul_datum` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table facie_leden
# ------------------------------------------------------------

DROP TABLE IF EXISTS `facie_leden`;

CREATE TABLE `facie_leden` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lid_naam` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lid_gebruikersnaam` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lid_email` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `lid_password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table facie_written
# ------------------------------------------------------------

DROP TABLE IF EXISTS `facie_written`;

CREATE TABLE `facie_written` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lid_number` int(11) NOT NULL,
  `data_nullen_number` int(11) NOT NULL,
  `data_mentoren_number` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

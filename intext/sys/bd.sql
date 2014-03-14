-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.30 - MySQL Community Server (GPL)
-- Server OS:                    Linux
-- Date/time:                    2013-03-07 18:12:00
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table lliure_site.ll_intext
DROP TABLE IF EXISTS `ll_intext`;
CREATE TABLE IF NOT EXISTS `ll_intext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idd` varchar(100) DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL,
  `tipo` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1=arquivos; 2=grupos; 3=frases',
  `nome_grupo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idd` (`idd`),
  KEY `grupo` (`grupo`),
  CONSTRAINT `ll_intext_ibfk_1` FOREIGN KEY (`grupo`) REFERENCES `ll_intext` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table lliure_site.ll_intext_texto
DROP TABLE IF EXISTS `ll_intext_texto`;
CREATE TABLE IF NOT EXISTS `ll_intext_texto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fk` int(11) NOT NULL,
  `ling` varchar(10) NOT NULL,
  `texto` text NULL,
  PRIMARY KEY (`id`),
  KEY `id_fk` (`id_fk`),
  CONSTRAINT `ll_intext_texto_ibfk_1` FOREIGN KEY (`id_fk`) REFERENCES `ll_intext` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

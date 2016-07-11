-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.5.27 - MySQL Community Server (GPL)
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela lliure.ll_intext
CREATE TABLE IF NOT EXISTS `ll_intext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` int(11) DEFAULT NULL,
  `idd` varchar(100) DEFAULT NULL,
	`tipo` ENUM('1','2','3','4') NOT NULL DEFAULT '1' COMMENT '1=arquivos; 2=grupos; 3=frases; 4=imagem',
  `nome_grupo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idd` (`idd`),
  KEY `grupo` (`grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela lliure.ll_intext_texto
CREATE TABLE IF NOT EXISTS `ll_intext_texto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fk` int(11) NOT NULL,
  `ling` varchar(10) NOT NULL,
  `texto` text,
  PRIMARY KEY (`id`),
  KEY `id_fk` (`id_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

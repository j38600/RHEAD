-- Adminer 4.2.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `ipad`;
CREATE DATABASE `ipad` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `ipad`;

DROP TABLE IF EXISTS `companhias`;
CREATE TABLE `companhias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companhia` varchar(200) COLLATE utf8_bin NOT NULL,
  `abreviatura` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `escalas`;
CREATE TABLE `escalas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) COLLATE utf8_bin NOT NULL,
  `diario` tinyint(1) NOT NULL DEFAULT '1',
  `numero_nomeados` int(11) NOT NULL,
  `hora_inicio` datetime NOT NULL,
  `hora_fim` datetime NOT NULL,
  `semana` tinyint(1) NOT NULL DEFAULT '1',
  `horas_duracao` int(11) NOT NULL DEFAULT '24',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `feriados`;
CREATE TABLE `feriados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quartel_id` int(11) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quartel_id` (`quartel_id`),
  CONSTRAINT `feriados_ibfk_1` FOREIGN KEY (`quartel_id`) REFERENCES `quarteis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1,	'admin',	'Administrator'),
(2,	'members',	'General User');

DROP TABLE IF EXISTS `indisponibilidades`;
CREATE TABLE `indisponibilidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `militar_nim` int(8) unsigned zerofill NOT NULL,
  `gdh_inicio` datetime NOT NULL,
  `gdh_fim` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `militar_nim` (`militar_nim`),
  CONSTRAINT `indisponibilidades_ibfk_2` FOREIGN KEY (`militar_nim`) REFERENCES `militares` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `login_attempts` (`id`, `ip_address`, `login`, `time`) VALUES
(3,	'::1',	'administrador',	1454516642);

DROP TABLE IF EXISTS `medalhas_condecoracoes`;
CREATE TABLE `medalhas_condecoracoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) COLLATE utf8_bin NOT NULL,
  `descricao` text COLLATE utf8_bin NOT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `militares`;
CREATE TABLE `militares` (
  `nim` int(8) unsigned zerofill NOT NULL,
  `nome` varchar(200) COLLATE utf8_bin NOT NULL,
  `apelido` varchar(50) COLLATE utf8_bin NOT NULL,
  `antiguidade` datetime NOT NULL,
  `nota_curso` int(4) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `posto_id` int(11) NOT NULL,
  `quartel_id` int(11) NOT NULL,
  `companhia_id` int(11) NOT NULL,
  PRIMARY KEY (`nim`),
  KEY `posto_id` (`posto_id`),
  KEY `quartel_id` (`quartel_id`),
  KEY `companhia_id` (`companhia_id`),
  CONSTRAINT `militares_ibfk_3` FOREIGN KEY (`posto_id`) REFERENCES `postos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `militares_ibfk_4` FOREIGN KEY (`quartel_id`) REFERENCES `quarteis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `militares_ibfk_5` FOREIGN KEY (`companhia_id`) REFERENCES `companhias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `militares_escalas`;
CREATE TABLE `militares_escalas` (
  `militares_nim` int(8) unsigned zerofill NOT NULL,
  `escalas_id` int(11) NOT NULL,
  `gdh_ultimo` datetime DEFAULT NULL,
  KEY `escalas_id` (`escalas_id`),
  KEY `militares_nim` (`militares_nim`),
  CONSTRAINT `militares_escalas_ibfk_4` FOREIGN KEY (`escalas_id`) REFERENCES `escalas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `militares_escalas_ibfk_6` FOREIGN KEY (`militares_nim`) REFERENCES `militares` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `militares_med_cond`;
CREATE TABLE `militares_med_cond` (
  `militar_nim` int(8) unsigned zerofill NOT NULL,
  `med_cond_id` int(11) NOT NULL,
  `pedida` tinyint(4) NOT NULL DEFAULT '0',
  `data_pedida` datetime DEFAULT '0000-00-00 00:00:00',
  `recebida` tinyint(4) NOT NULL DEFAULT '0',
  `data_recebida` datetime DEFAULT '0000-00-00 00:00:00',
  `imposta` tinyint(4) NOT NULL DEFAULT '0',
  `data_imposta` datetime DEFAULT '0000-00-00 00:00:00',
  `informacao` text COLLATE utf8_bin,
  KEY `med_cond_id` (`med_cond_id`),
  KEY `militar_nim` (`militar_nim`),
  CONSTRAINT `militares_med_cond_ibfk_1` FOREIGN KEY (`militar_nim`) REFERENCES `militares` (`nim`),
  CONSTRAINT `militares_med_cond_ibfk_2` FOREIGN KEY (`med_cond_id`) REFERENCES `medalhas_condecoracoes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `postos`;
CREATE TABLE `postos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posto` varchar(100) COLLATE utf8_bin NOT NULL,
  `abreviatura` varchar(50) COLLATE utf8_bin NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `quarteis`;
CREATE TABLE `quarteis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quartel` varchar(200) COLLATE utf8_bin NOT NULL,
  `abreviatura` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1,	'127.0.0.1',	'administrator',	'$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',	'',	'admin@admin.com',	'',	NULL,	NULL,	NULL,	1268889823,	1454588522,	1,	'Admin',	'istrator',	'ADMIN',	'0');

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1,	1,	1),
(2,	1,	2);

-- 2016-02-04 12:28:12

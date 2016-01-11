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

INSERT INTO `companhias` (`id`, `companhia`, `abreviatura`) VALUES
(1,	'Companhia de Guerra Eletrónica',	'CGE'),
(2,	'Companhia Comando e Serviços - RT',	'CCS/RT'),
(3,	'Companhia Comando e Serviços - BTm',	'CCS/BTm'),
(4,	'Companhia de Transmissões de Apoio',	'CTmAp'),
(5,	'Companhia de Transmissões',	'CTm/BrigInt');

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

INSERT INTO `escalas` (`id`, `nome`, `diario`, `numero_nomeados`, `hora_inicio`, `hora_fim`, `semana`, `horas_duracao`) VALUES
(1,	'Comandante da Guarda A',	1,	1,	'2015-01-01 09:30:00',	'2015-01-02 09:30:00',	1,	24),
(2,	'Comandante da Guarda B',	1,	1,	'2015-01-01 09:30:00',	'2015-01-02 09:30:00',	0,	24);

DROP TABLE IF EXISTS `feriados`;
CREATE TABLE `feriados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quartel_id` int(11) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quartel_id` (`quartel_id`),
  CONSTRAINT `feriados_ibfk_1` FOREIGN KEY (`quartel_id`) REFERENCES `quarteis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `feriados` (`id`, `quartel_id`, `data`) VALUES
(1,	1,	'2015-12-08 01:00:00');

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


DROP TABLE IF EXISTS `medalhas_condecoracoes`;
CREATE TABLE `medalhas_condecoracoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) COLLATE utf8_bin NOT NULL,
  `descricao` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `medalhas_condecoracoes` (`id`, `nome`, `descricao`) VALUES
(1,	'Comportamento Exemplar - Grau Cobre',	'Estamedalha é imposta aos militares que não tenham recebido qualquer castigo nos últimos 6 anos.'),
(2,	'Comportamento Exemplar - Grau Prata',	'Esta medalha é imposta aos militares que não tenham recebido qualquer castigo nos últimos 15 anos.');

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

INSERT INTO `militares` (`nim`, `nome`, `apelido`, `antiguidade`, `nota_curso`, `ativo`, `posto_id`, `quartel_id`, `companhia_id`) VALUES
(00775995,	'Paulo Manuel Pereira',	'Simões',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(00840302,	'Daniel Alexandre Póvoa',	'Pereira',	'2015-01-01 01:00:00',	1200,	1,	8,	1,	2),
(01508298,	'Filipe Miguel da Costa Oliveira',	'Fonseca',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(01561291,	'Rui Jorge Rio',	'Santos',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(01852598,	'Raúl Vicente',	'Pinheiro',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(02456105,	'José Alberto da Silva',	'Maia',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(02619096,	'Carlos Manuel Marques',	'Carrinho',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(02773402,	'João Carlos Simões',	'Paiva',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(03427305,	'Valdemar Tiago Ramos',	'Silva',	'2015-01-01 01:00:00',	1000,	1,	7,	1,	2),
(03892702,	'Luís Filipe Jorge',	'Oliveira',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(04088884,	'Carlos Manuel de Sousa',	'Narra',	'2014-12-31 01:00:00',	1000,	1,	10,	1,	2),
(04503909,	'Suzana Dalila Alomaya Marques',	'Tavares',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(04902988,	'António Alberto Noronha',	'Ribeiro',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(05154995,	'Pedro Manuel Silva',	'Soares',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(05256093,	'Humberto Joaquim Curralo',	'Machado',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(05723594,	'Rui Michel Palmeiro',	'Regino',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(05827805,	'Miguel Arcanjo Vieira',	'Castro',	'2015-01-01 01:00:00',	1000,	1,	7,	1,	2),
(06284503,	'PEdro Miguel Viana',	'Ribeiro',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(06542603,	'Rui Duarte da Costa',	'Macedo',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(06967788,	'José Alberto',	'Santos',	'2015-01-01 02:00:00',	1000,	1,	9,	1,	2),
(07048887,	'Arnaldo Paulo Silva',	'Pereira',	'2015-01-03 01:00:00',	1000,	1,	10,	1,	2),
(07079290,	'João Fernandes',	'Carvalho',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(07149409,	'Hugo Emanuel Gonçalves',	'Cardoso',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(07310306,	'José Emanuel Correia',	'Ferreira',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(08896285,	'Eusébio Fernandes',	'Ferreira',	'2015-01-02 01:00:00',	1000,	1,	10,	1,	2),
(09844391,	'Joaquim Filipe Moreira',	'Lopes',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(09879805,	'Márcia Ribeiro',	'Silva',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(10116702,	'Júlio Ricardo Moreira',	'Sebastião',	'2014-10-01 00:00:00',	1534,	1,	8,	1,	1),
(10449204,	'Jorge Miguel Melo da Almeida',	'Mercê',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(10528203,	'Luis Daniel Pinho Soares',	'Pinto',	'2014-10-01 00:00:00',	1537,	1,	8,	1,	5),
(10862999,	'Hélder Renato Queirós',	'Costa',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(10875791,	'Vitor Avelino',	'Cruz',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(11205088,	'João Alberto Alves',	'Lopes',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(11392687,	'Paulo Jorge Correia',	'Pinto',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(11625488,	'Albano da Costa',	'Leite',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(11644795,	'José João Martinho',	'Henriques',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(12101390,	'Paulo Jorge Patrocínio',	'Moreira',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(12593889,	'Artur Jorge Neves',	'Pinto',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(12945799,	'Marco Paulo Mesquita',	'Monteiro',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(13203399,	'Bruno Martins',	'Silva',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(13254504,	'Alexandre Ferreira',	'Viana',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(13585402,	'Jorge Manuel Matos Faria Silva',	'Matos',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(13927087,	'Celestino Manuel Abreu da Costa',	'Rios',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(14348500,	'Vitor José Vieira',	'Santos',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(14541004,	'João André Ferreira C. Teles',	'Carvalho',	'2015-01-01 01:00:00',	1000,	1,	7,	1,	2),
(14865195,	'Pedro Nunes Pinto da Silva',	'Bráz',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(15295704,	'Marco Manuel Gonçalves',	'Borges',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(15465401,	'Edi Emanuel Valadares',	'Costa',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(15585587,	'António da Cruz',	'Freitas',	'2015-01-03 03:00:00',	1000,	1,	9,	1,	2),
(16345996,	'António dos Reis Domingues',	'Gomes',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(16539083,	'Fernando Lourenço',	'Castro',	'2015-01-01 01:00:00',	1000,	1,	10,	1,	2),
(17172401,	'Domingos Ladislau da Silva',	'Paiva',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(17915786,	'João Rua',	'Ribeiro',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(18106381,	'José Manuel Lopes',	'Silva',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(18240997,	'Paulo Sérgio Castro',	'Cardoso',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(18365599,	'Ricardo Nunes',	'Cunha',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(18424204,	'Cláudio André Nobre',	'Matos',	'2015-01-01 01:00:00',	1000,	1,	7,	1,	2),
(18734610,	'Carlos Miguel Sá',	'Carvalho',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(18787498,	'Nuno Luciano Pereira',	'Fernandes',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(18816004,	'Diogo Ferreira',	'Silva',	'2015-01-01 01:00:00',	1000,	1,	7,	1,	2),
(18859705,	'Micael Teixeira',	'Galvão',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(19662306,	'João Pedro Batista',	'Rocha',	'2015-01-01 01:00:00',	1000,	1,	7,	1,	2),
(19861492,	'Rui Filipe Braga Pinto',	'Sousa',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(19909005,	'Adam Gregory',	'Lambert',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(22599992,	'Luís Alberto Ribeiro Soares',	'Barquinha',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(23463192,	'Noémia Delfina Martins Nunes',	'Magalhães',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(24247092,	'António Manuel Pinto',	'Francisco',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(28986893,	'Joaquim Rebelo',	'Torres',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2),
(32987892,	'José Paulo Alves',	'Magalhães',	'2015-01-01 01:00:00',	1000,	1,	9,	1,	2),
(35976893,	'Eugénio Alves',	'Ribeiro',	'2015-01-01 01:00:00',	1000,	1,	8,	1,	2);

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

INSERT INTO `militares_escalas` (`militares_nim`, `escalas_id`, `gdh_ultimo`) VALUES
(10528203,	1,	NULL),
(10116702,	1,	NULL),
(00775995,	1,	NULL),
(10116702,	2,	NULL);

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

INSERT INTO `militares_med_cond` (`militar_nim`, `med_cond_id`, `pedida`, `data_pedida`, `recebida`, `data_recebida`, `imposta`, `data_imposta`, `informacao`) VALUES
(10116702,	1,	1,	'2016-01-08 12:53:59',	0,	'0000-00-00 00:00:00',	0,	'0000-00-00 00:00:00',	NULL);

DROP TABLE IF EXISTS `postos`;
CREATE TABLE `postos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posto` varchar(100) COLLATE utf8_bin NOT NULL,
  `abreviatura` varchar(50) COLLATE utf8_bin NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `postos` (`id`, `posto`, `abreviatura`, `ordem`) VALUES
(1,	'Soldado',	'Sold',	1),
(2,	'2º Cabo',	'2Cb',	2),
(3,	'1º Cabo',	'1Cb',	3),
(4,	'Cabo Adjunto',	'CAdj',	4),
(5,	'2º Furriel',	'Fur',	5),
(6,	'Furriel',	'Fur',	6),
(7,	'2º Sargento',	'2Sarg',	7),
(8,	'1º Sargento',	'1Sarg',	8),
(9,	'Sargento Ajudante',	'SAj',	9),
(10,	'Sargento Chefe',	'SCh',	10),
(11,	'Sargento Mor',	'SMor',	11),
(12,	'Aspirante',	'Asp',	12),
(13,	'Alferes',	'Alf',	13),
(14,	'Tenente',	'Ten',	14),
(15,	'Capitão',	'Cap',	15),
(16,	'Major',	'Maj',	16),
(17,	'Tenente-Coronel',	'TCor',	17),
(18,	'Coronel',	'Cor',	18),
(19,	'Brigadeiro-General',	'BGen',	19),
(20,	'Major-General',	'MGen',	20),
(21,	'Tenente-General',	'TGen',	21),
(22,	'General',	'Gen',	22),
(23,	'Marechal',	'Mar',	23);

DROP TABLE IF EXISTS `quarteis`;
CREATE TABLE `quarteis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quartel` varchar(200) COLLATE utf8_bin NOT NULL,
  `abreviatura` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `quarteis` (`id`, `quartel`, `abreviatura`) VALUES
(1,	'Regimento de Transmissões',	'RT');

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
(1,	'127.0.0.1',	'administrator',	'$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',	'',	'admin@admin.com',	'',	NULL,	NULL,	NULL,	1268889823,	1452255373,	1,	'Admin',	'istrator',	'ADMIN',	'0');

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

-- 2016-01-11 00:22:41

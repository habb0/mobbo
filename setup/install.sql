DROP TABLE IF EXISTS mobbo_minimail;
DROP TABLE IF EXISTS mobbo_settings;
DROP TABLE IF EXISTS mobbo_news;
DROP TABLE IF EXISTS beta;
DROP TABLE IF EXISTS addons;
DROP TABLE IF EXISTS stafflogs;
DROP TABLE IF EXISTS mobbo_banners;
DROP TABLE IF EXISTS mobbo_hotcampaigns;
DROP TABLE IF EXISTS mobbo_recommended;
DROP TABLE IF EXISTS mobbo_plugins;
DROP TABLE IF EXISTS mobbo_conversations;
DROP TABLE IF EXISTS mobbo_navi;
DROP TABLE IF EXISTS mobbo_subnavi;
DROP TABLE IF EXISTS ranks;
DROP TABLE IF EXISTS mobbo_registration_figures;
DROP TABLE IF EXISTS mobbo_recupera;
DROP TABLE IF EXISTS mobbo_backups;
DROP TABLE IF EXISTS `arrowchat`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `mobbo_shop`;
DROP TABLE IF EXISTS `users_referidos`;
DROP TABLE IF EXISTS `users_homes`;
CREATE TABLE IF NOT EXISTS `mobbo_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dolares` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `users_referidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(400) NOT NULL DEFAULT 'user',
  `ip_referida` varchar(50) NOT NULL,
  `fecha` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `users_homes` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `texto` varchar(255) NOT NULL DEFAULT 'Nao Possuo Texto Personalizado Ainda...',
  `fundo` varchar(255) NOT NULL,
  `cores` varchar(99) NOT NULL DEFAULT '#FFFFFF',
  `video` varchar(255) NOT NULL DEFAULT 'http://www.youtube.com/embed/aiBt44rrslw',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `mobbo_backups` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `stafflogs` (
  `id` int(5) NOT NULL auto_increment,
  `action` varchar(12) collate latin1_general_ci NOT NULL,
  `message` text collate latin1_general_ci,
  `note` text collate latin1_general_ci,
  `userid` int(11) NOT NULL,
  `targetid` int(11) default '0',
  `timestamp` varchar(50) collate latin1_general_ci default NULL,
  `details` varchar(50) collate latin1_general_ci NOT NULL default '-/-',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `beta` (
  `code` varchar(40) NOT NULL,
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE IF NOT EXISTS `mobbo_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_name` text NOT NULL,
  `plugin_version` text NOT NULL,
  `plugin_author` text NOT NULL,
  `mobbo_code` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `mobbo_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `shortstory` text COLLATE latin1_general_ci,
  `longstory` text COLLATE latin1_general_ci,
  `published` int(10) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE latin1_general_ci DEFAULT '/Public/Images/news/TS_Web60.png',
  `author` int(6) NOT NULL DEFAULT '1',
  `mini` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;
INSERT INTO `mobbo_news` (`id`, `title`, `shortstory`, `longstory`, `published`, `image`, `author`, `mini`) VALUES
(1, 'mobbo Instalada', 'Mobbo Instalada com Sucesso', 'A Mobbo Foi Instalada com Sucesso! Aproveite!', 1, '#2ba6cb', 'Admin', '');
CREATE TABLE IF NOT EXISTS `mobbo_settings` (
  `variabler` varchar(80) NOT NULL,
  `valuer` text NOT NULL,
  `description` text,
  `example` text,
  PRIMARY KEY (`variabler`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `mobbo_settings` (`variabler`, `valuer`, `description`, `example`) VALUES
('maintenance', '0', 'Manutenção', '0/1'),
('maintenance_text', 'Estamos Atualizando o Nosso Sistema..', 'Texto Manutenção', 'Estamos Atualizando o Nosso Sistema..'),
('hotel_mail', 'admin@m0va.me', 'E-mail do Criador', 'info@tuhotel.com'),
('hotel_name', 'mobbo', 'Nome do Hotel', 'mobbo'),
('hotel_url', 'http://localhost/', 'URL do Hotel', 'http://localhost/'),
('hotel_ticket', 'users;auth_ticket', 'Table do Ticket (Tabela, Coluna)', 'users;auth_ticket'),
('timezone', 'Europe/Madrid', 'Default Timezone', 'America/Los Angeles');
CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `badgeid` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;
INSERT INTO `ranks` (`id`, `name`, `badgeid`) VALUES
(1, 'User', 'OI'),
(2, 'VIP', 'VIP'),
(3, 'Habbo-X', 'LLL'),
(4, 'Silver', 'XXX'),
(5, 'Estagiario', 'MOD'),
(6, 'Moderador', 'ADM'),
(7, 'Administradores', 'ADM'),
(8, 'Criadores', 'ADM');
ALTER TABLE  `users` ADD  `owner` INT( 99 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `users` ADD  `novato` INT( 99 ) NOT NULL DEFAULT  '0';
ALTER TABLE users ADD fundom VARCHAR(255) NOT NULL DEFAULT '#43AC6A';'
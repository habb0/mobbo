<?php
if (!file_exists('trava.php'))
    {
    error_reporting(0);
    session_start();
    $fileArray = array(
        "../GALLERY.zip",
        "../PUBLIC.zip",
        "../TEMPLATE.zip"
    );

    foreach ($fileArray as $key => $value)
        {
        if (file_exists($value[$key]))
            {
            unlink($value[$key]);
            }
        }
    $myFile    = "../GALLERY.zip";
    unlink($myFile);
    $myFile    = "../GALLERY.ZIP";
    unlink($myFile);
    $myFile    = "../PUBLIC.zip";
    unlink($myFile);
    $myFile    = "../PUBLIC.ZIP";
    unlink($myFile);
    @include('../CORE.php');
    $host      = $config['host'];
    $host_user = $config['host_user'];
    $host_pass = $config['host_pass'];
    $host_db   = $config['host_db'];
    $host_type = $config['host_type'];
    $host_port = $config['host_port'];
    Transaction::open(array('user' => $host_user, 'pass' => $host_pass, 'name' => $host_db, 'type' => $host_type, 'port' => $host_port, 'host' => $host));
    $link      = Transaction::get();
    Transaction::query("DROP TABLE IF EXISTS mobbo_minimail;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_settings;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_news;");
    Transaction::query("DROP TABLE IF EXISTS beta;");
    Transaction::query("DROP TABLE IF EXISTS addons;");
    Transaction::query("DROP TABLE IF EXISTS stafflogs;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_banners;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_hotcampaigns;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_recommended;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_plugins;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_conversations;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_navi;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_subnavi;");
    Transaction::query("DROP TABLE IF EXISTS ranks;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_registration_figures;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_recupera;");
    Transaction::query("DROP TABLE IF EXISTS mobbo_backups;");
    Transaction::query("DROP TABLE IF EXISTS `arrowchat`;");
    Transaction::query("DROP TABLE IF EXISTS `comments`;");
    Transaction::query("DROP TABLE IF EXISTS `posts`;");
    Transaction::query("DROP TABLE IF EXISTS `mobbo_marktplatzvip`;");
    Transaction::query("DROP TABLE IF EXISTS `users_referidos`;");
    Transaction::query("DROP TABLE IF EXISTS `users_homes`;");
    Transaction::query("CREATE TABLE IF NOT EXISTS `mobbo_marktplatzvip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dolares` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;");
    Transaction::query("CREATE TABLE IF NOT EXISTS `users_referidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(400) NOT NULL DEFAULT 'user',
  `ip_referida` varchar(50) NOT NULL,
  `fecha` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;");
    Transaction::query("CREATE TABLE IF NOT EXISTS `users_homes` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `texto` varchar(255) NOT NULL DEFAULT 'Nao Possuo Texto Personalizado Ainda...',
  `fundo` varchar(255) NOT NULL,
  `cores` varchar(99) NOT NULL DEFAULT '#FFFFFF',
  `video` varchar(255) NOT NULL DEFAULT 'http://www.youtube.com/embed/aiBt44rrslw',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;");
    Transaction::query("CREATE TABLE IF NOT EXISTS `mobbo_backups` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
");
    Transaction::query("CREATE TABLE IF NOT EXISTS `stafflogs` (
  `id` int(5) NOT NULL auto_increment,
  `action` varchar(12) collate latin1_general_ci NOT NULL,
  `message` text collate latin1_general_ci,
  `note` text collate latin1_general_ci,
  `userid` int(11) NOT NULL,
  `targetid` int(11) default '0',
  `timestamp` varchar(50) collate latin1_general_ci default NULL,
  `details` varchar(50) collate latin1_general_ci NOT NULL default '-/-',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;");
    Transaction::query("CREATE TABLE IF NOT EXISTS `beta` (
  `code` varchar(40) NOT NULL,
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");
    Transaction::query("CREATE TABLE IF NOT EXISTS `mobbo_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_name` text NOT NULL,
  `plugin_version` text NOT NULL,
  `plugin_author` text NOT NULL,
  `mobbo_code` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
    Transaction::query("CREATE TABLE IF NOT EXISTS `mobbo_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `shortstory` text COLLATE latin1_general_ci,
  `longstory` text COLLATE latin1_general_ci,
  `published` int(10) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE latin1_general_ci DEFAULT '/Public/Images/news/TS_Web60.png',
  `campaign` int(1) NOT NULL DEFAULT '0',
  `campaignimg` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `author` int(6) NOT NULL DEFAULT '1',
  `super_fader_image` varchar(225) CHARACTER SET latin1 NOT NULL DEFAULT '/Public/Images/news/v2/topstory_security.png',
  `super_fader` int(1) NOT NULL,
  `mini` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=56 ;");
    Transaction::query("INSERT INTO `mobbo_news` (`id`, `title`, `shortstory`, `longstory`, `published`, `image`, `campaign`, `campaignimg`, `author`, `super_fader_image`, `super_fader`, `mini`) VALUES
(1, 'mobbo Instalada', 'Mobbo Instalada com Sucesso', 'A Mobbo Foi Instalada com Sucesso! Aproveite!', 1382883244, '', 0, '0', 0, '#2ba6cb', 1, '')");
    Transaction::query("CREATE TABLE IF NOT EXISTS `mobbo_settings` (
  `variable` varchar(80) NOT NULL,
  `value` text NOT NULL,
  `description` text,
  `example` text,
  PRIMARY KEY (`variable`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");
    Transaction::query("INSERT INTO `mobbo_settings` (`variable`, `value`, `description`, `example`) VALUES
('maintenance', '0', 'Manutenção', '0/1'),
('maintenance_text', 'Estamos Atualizando o Nosso Sistema..', 'Texto Manutenção', 'Estamos Atualizando o Nosso Sistema..'),
('hotel_mail', 'admin@m0va.me', 'E-mail do Criador', 'info@tuhotel.com'),
('hotel_name', 'mobbo', 'Nome do Hotel', 'mobbo'),
('hotel_url', 'http://localhost/', 'URL do Hotel', 'http://localhost/'),
('timezone', 'Europe/Madrid', 'Default Timezone', 'America/Los Angeles')
");
    Transaction::query("CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `badgeid` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;");
    Transaction::query("INSERT INTO `ranks` (`id`, `name`, `badgeid`) VALUES
(1, 'User', 'OI'),
(2, 'VIP', 'VIP'),
(3, 'Habbo-X', 'LLL'),
(4, 'Silver', 'XXX'),
(5, 'Estagiario', 'MOD'),
(6, 'Moderador', 'ADM'),
(7, 'Administradores', 'ADM'),
(8, 'Criadores', 'ADM');");
    Transaction::query("ALTER TABLE  `users` ADD  `owner` INT( 99 ) NOT NULL DEFAULT  '0';");
    Transaction::query("ALTER TABLE  `users` ADD  `novato` INT( 99 ) NOT NULL DEFAULT  '0';");
    Transaction::query("ALTER TABLE users ADD fundom VARCHAR(255) NOT NULL DEFAULT '#43AC6A';'");
    if (isset($_SESSION['hotel_name']))
        {
        $hotelname = $_SESSION['hotel_name'];
        $hosting   = $_SESSION['host_url'];
        Transaction::query("UPDATE mobbo_settings SET value = '" . $hotelname . "' WHERE variable = 'hotel_name'");
        Transaction::query("UPDATE mobbo_settings SET value = '" . $hosting . "' WHERE variable = 'hotel_url'");
        }
    $mensagem = "setup travado";
    $log      = fopen("trava.php", "a+");
    fwrite($log, $mensagem);
    $a        = 1;
    if ($a == 1)
        {
        echo('<META HTTP-EQUIV="Refresh" CONTENT="10; URL=../index.php">');
        }
    ?>
    <html class=" js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" lang="en" data-useragent="Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36" style=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta charset="utf-8">
            <title> Mobbo - Welcome </title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="http://foundation.zurb.com/assets/img/icons/favicon.ico" type="image/x-icon">
            <!-- For third-generation iPad with high-resolution Retina display: -->
            <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://foundation.zurb.com/assets/img/icons/apple-touch-icon-144x144-precomposed.png">
            <!-- For iPhone with high-resolution Retina display: -->
            <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://foundation.zurb.com/assets/img/icons/apple-touch-icon-114x114-precomposed.png">
            <!-- For first- and second-generation iPad: -->
            <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://foundation.zurb.com/assets/img/icons/apple-touch-icon-72x72-precomposed.png">
            <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
            <link rel="apple-touch-icon-precomposed" href="http://foundation.zurb.com/assets/img/icons/apple-touch-icon-precomposed.png">

            <meta name="description" content="Documentation and reference library for ZURB Foundation. JavaScript, CSS, components, grid and more.">

            <meta name="author" content="ZURB, inc. ZURB network also includes zurb.com">
            <meta name="copyright" content="ZURB, inc. Copyright (c) 2013">
            <link rel="stylesheet" href="./gallery/css/foundation.css" />
            <link rel="stylesheet" href="./gallery/css/cms.css" />
            <script src="./gallery/web-gallery/js/jquery.js"></script>
            <script src="./gallery/web-gallery/js/modernizr.js"></script>
            <link type="text/css" rel="stylesheet" href="./gallery/css/marketing.css">
            <link rel="stylesheet" type="text/css" href="./gallery/css/css">
        </head>
        <div class="row">
            <form method="post" name="okay" id="okay">
                <div class="large-12 columns">
                    <br><h4>Setup</h4><br>
                    <div class="panel">
                        <h4> Aguarde a CMS Está Sendo Instalada!</h4>
                        <h5>Você será Redirecionado para a CMS Quando o Setup Acabar, Não Esqueça de Apagar a pasta Setup. Obrigado por Usar a Mobbo</h5>
                    </div>
                </div>
        </div>
    <?php } ?>
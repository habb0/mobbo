<?php

if (!file_exists('trava.php'))
    {
    error_reporting(0);
    set_time_limit(0);
    session_start();
    if (isset($_POST['hosts']))
        {
        // GET Values
        include_once('../CORE.php');
        $host      = $_POST['host'];
        $host_user = $_POST['host_user'];
        $host_pass = $_POST['host_pass'];
        $host_db   = $_POST['host_db'];
        $host_port = $_POST['host_port'];
        $host_type = $_POST['host_type'];
        // Check If Configuration is Valid
        if ($host == NULL or $host_user == NULL or $host_db == NULL or $host_type == NULL or $host_port == NULL)
            {
            echo ('Algum dos Campos de Configuração MySQL Estão em Branco!');
            }
        else
            {
            try
                {
                Transaction::open(array('user' => $host_user, 'pass' => $host_pass, 'name' => $host_db, 'type' => $host_type, 'port' => $host_port, 'host' => $host));
                $oi = 2;
                }
            catch (PDOException $e)
                {
                echo('Error!' . $e);
                }
            if ($oi != 2)
                {
                echo('Configuração MySQL Não Valida! Pois Não foi Possivel conectar ao MySQL');
                }
            else
                {
                $o = 1;
                if ($o != 1)
                    {
                    echo('Configuração MySQL Não Valida! Pois Não Foi Possivel Conectar á DB!');
                    }
                else
                    {
                    $mensagem  = "host = $host \r\n";
                    $mensagem2 = "host_user = $host_user \r\n";
                    $mensagem3 = "host_pass = $host_pass \r\n";
                    $mensagem4 = "host_db = $host_db \r\n";
                    $mensagem5 = "host_port = $host_port \r\n";
                    $mensagem6 = "host_type = $host_type \r\n";
                    $log       = fopen($_SERVER ['DOCUMENT_ROOT'] . "/settings.ini", "a+");
                    fwrite($log, $mensagem);
                    fwrite($log, $mensagem2);
                    fwrite($log, $mensagem3);
                    fwrite($log, $mensagem4);
                    fwrite($log, $mensagem5);
                    fwrite($log, $mensagem6);
                    fclose($log);
                    if (isset($_POST['accounts']))
                        {
                        $username  = $_POST['user_name'];
                        $password  = md5($_POST['user_pass']);
                        $rank      = $_POST['user_rank'];
                        $remote_ip = $_SERVER ['REMOTE_ADDR'];
                        if ($username == NULL or $password == NULL or $rank == NULL or $remote_ip == NULL)
                            {
                            echo('Algum dos Campo de Ciração da Conta de Administrador está Em Branco!');
                            }
                        else
                            {
                            Transaction::open(array('user' => $host_user, 'pass' => $host_pass, 'name' => $host_db, 'type' => $host_type, 'port' => $host_port, 'host' => $host));
                            $link = Transaction::get();
                            Transaction::query("CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `real_name` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL,
  `mail` varchar(50) NOT NULL DEFAULT 'defaultuser@yourmail.com',
  `auth_ticket` varchar(75) DEFAULT NULL,
  `rank` int(11) unsigned NOT NULL DEFAULT '1',
  `credits` int(11) NOT NULL DEFAULT '50000',
  `seasonal_credits` int(11) NOT NULL DEFAULT '0',
  `vip_points` int(11) NOT NULL DEFAULT '0',
  `activity_points` int(11) NOT NULL DEFAULT '0',
  `activity_points_lastupdate` double NOT NULL DEFAULT '0',
  `look` text NOT NULL,
  `gender` enum('M','F') NOT NULL DEFAULT 'M',
  `motto` varchar(50) NOT NULL,
  `last_online` int(250) NOT NULL,
  `account_created` double NOT NULL DEFAULT '0',
  `online` enum('0','1') NOT NULL DEFAULT '0',
  `ip_last` varchar(120) NOT NULL,
  `ip_reg` varchar(120) NOT NULL,
  `home_room` int(10) unsigned NOT NULL DEFAULT '0',
  `respect` int(11) NOT NULL DEFAULT '0',
  `daily_respect_points` int(11) NOT NULL DEFAULT '3',
  `daily_pet_respect_points` int(11) NOT NULL DEFAULT '3',
  `newbie_status` int(11) NOT NULL DEFAULT '0',
  `is_muted` enum('0','1') NOT NULL DEFAULT '0',
  `mutant_penalty` enum('0','1','2') NOT NULL DEFAULT '0',
  `mutant_penalty_expire` int(11) NOT NULL DEFAULT '0',
  `block_newfriends` enum('0','1') NOT NULL DEFAULT '0',
  `hide_online` enum('0','1') NOT NULL DEFAULT '0',
  `hide_inroom` enum('0','1') NOT NULL DEFAULT '0',
  `mail_verified` varchar(6) NOT NULL DEFAULT '0',
  `vip` enum('0','1') NOT NULL DEFAULT '0',
  `client_volume` int(11) NOT NULL DEFAULT '100',
  `volume` varchar(12) NOT NULL DEFAULT '100,100,100',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `accept_trading` enum('0','1') NOT NULL DEFAULT '1',
  `whisper_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `is_guide` enum('0','1') NOT NULL DEFAULT '1',
  `last_change` int(20) NOT NULL DEFAULT '0',
  `key_colour` int(11) NOT NULL DEFAULT '0',
  `position` varchar(30) NOT NULL DEFAULT '0',
  `acc_pornbanned` enum('0','1') NOT NULL DEFAULT '0',
  `acc_flagged` enum('0','1') NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  `belcredits` int(11) NOT NULL DEFAULT '0',
  `working` varchar(50) NOT NULL DEFAULT '0',
  `secretcode` varchar(8) NOT NULL DEFAULT '0',
  `mymusik` varchar(50) NOT NULL DEFAULT '0',
  `allowed` varchar(1) DEFAULT '1',
  `use_newui` enum('1','0') DEFAULT '1',
  `canchangename` enum('1','0') NOT NULL DEFAULT '1',
  `lastnamechange` varchar(100) NOT NULL DEFAULT '0',
  `seckey` varchar(50) NOT NULL DEFAULT '0',
  `Spirit` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `auth_ticket` (`auth_ticket`),
  KEY `online` (`online`),
  KEY `rank` (`rank`),
  KEY `ip_last` (`ip_last`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;");
                            Transaction::query("INSERT INTO users (username,password,motto,mail,rank) VALUES ('" . $username . "', '" . $password . "', 'Administrador', 'admin@bi0s.com.br', '" . $rank . "');");
                            $o    = 1;
                            if ($o != 1)
                                {
                                echo ('Erro ao Criar a Conta de Administrador');
                                }
                            else
                                {
                                if (isset($_POST['basics']))
                                    {
                                    $opcao = $_POST['client'];
                                    if ($opcao == NULL)
                                        {
                                        echo('Selecione uma Client Para Continuar!');
                                        }
                                    else
                                        {

                                        if (isset($_POST['hotel_name']))
                                            {
                                            $_SESSION['hotel_name'] = $_POST['hotel_name'];
                                            }
                                        Transaction::query("DROP TABLE IF EXISTS `mobbo_templates`;");
                                        Transaction::query("CREATE TABLE IF NOT EXISTS `mobbo_templates` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `creator` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `active` int(99) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
");
                                        $_SESSION['host_url'] = htmlentities($_POST['host_url']);
                                        $template             = $_POST['template_url'];

                                        if ($opcao == "phoenix")
                                            {
                                            $origem  = 'client/clientphx.php';
                                            $destino = '../templates/mobbo/client.php';
                                            copy($origem, $destino);
                                            }
                                        if ($opcao == "atom")
                                            {
                                            $origem  = 'client/clientatom.php';
                                            $destino = '../templates/mobbo/client.php';
                                            copy($origem, $destino);
                                            }
                                        if ($opcao == "bcstorm")
                                            {
                                            $origem  = 'client/clientbcstorm.php';
                                            $destino = '../templates/mobbo/client.php';
                                            copy($origem, $destino);
                                            }
                                        if ($opcao == "fstorm")
                                            {
                                            $origem  = 'client/clientfstorm.php';
                                            $destino = '../templates/mobbo/client.php';
                                            copy($origem, $destino);
                                            }
                                        if ($opcao == "fstorm2")
                                            {
                                            $origem  = 'client/clientteste.php';
                                            $destino = '../templates/mobbo/client.php';
                                            copy($origem, $destino);
                                            }
                                        if ($opcao == "fstorm3")
                                            {
                                            $origem  = 'client/clientswift.php';
                                            $destino = '../templates/mobbo/client.php';
                                            copy($origem, $destino);
                                            }

                                        Templates::Download('http://bi0s.hostingsiteforfree.com/uploads/bi0s/mobbonovo.zip');
                                        Templates::Install('mobbonovo');
                                        Templates::Active('mobbonovo');

                                        $fileArray = array(
                                            "../GALLERY.zip",
                                            "../PUBLIC.zip"
                                        );


                                        foreach ($fileArray as $key => $value)
                                            {
                                            if (file_exists($value[$key]))
                                                {
                                                unlink($value[$key]);
                                                }
                                            }
                                        echo('TudoCertoTudoCerto');
                                        }
                                    }
                                else
                                    echo('Você não selecionou uma Client');
                                }
                            }
                        }
                    else
                        echo('Você não criou uma conta de Admin');
                    }
                }
            }
        }
    else
        echo('Você não postou uma Host..');
    }
?>
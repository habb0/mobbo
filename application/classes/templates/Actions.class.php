<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Actions
 *
 * @author Gisele Santoro
 */
class Actions
    {

    public
    static
            function show($actions = array())
        {
        $action = htmlspecialchars($actions);
        switch ($action)
            {
            case "login":
                if (isset($_POST['username']))
                    {
                    if (isset($_POST['password']))
                        {
                        $email      = Security::textFilter($_POST['username']);
                        $password   = md5(Security::textFilter($_POST['password']));
                        $find_user2 = Transaction::query("SELECT * FROM `users` WHERE `username` = '" . $email . "'");
                        $user_info2 = Transaction::fetch($find_user2);
                        $find_user  = Transaction::query("SELECT * FROM `users` WHERE `mail` = '" . $email . "'");
                        $user_info  = Transaction::fetch($find_user);
                        if ($user_info['password'] == $password or $user_info2['password'] == $password)
                            {
                            $queryban = Transaction::query("SELECT * FROM `bans` WHERE `value` = '" . $user_info['username'] . "' OR `value` =  '" . $user_info2['username'] . "' LIMIT 1");
                            if (Transaction::num_rows($queryban) > 0)
                                {
                                $fetchban = Transaction::fetch($queryban);
                                header("location: ../index.php?ban=" . $fetchban['value'] . "&reason=" . $fetchban['reason'] . "&time=" . $fetchban['expire'] . "&true=1");
                                exit;
                                }
                            if (!empty($user_info))
                                {
                                $_SESSION['id']     = $user_info['id'];
                                $_SESSION['userid'] = $user_info['id'];
                                $rawhotel           = md5($user_info['id'] + $user_info['username'] + $user_info['password'] + Security::getUserIP());
                                setcookie('rawsessionhotel', $rawhotel);
                                }
                            elseif (!empty($user_info2))
                                {
                                $_SESSION['id']     = $user_info2['id'];
                                $_SESSION['userid'] = $user_info2['id'];
                                $rawhotel           = md5($user_info2['id'] + $user_info2['username'] + $user_info2['password'] + Security::getUserIP());
                                setcookie('rawsessionhotel', $rawhotel);
                                }

                            header("location: me");

                            if ($_SESSION['login_try'] > 0)
                                {
                                $_SESSION['login_try'] = 0;
                                }
                            exit;
                            }
                        else
                            {
                            $_SESSION['login_try'] = ($_SESSION['login_try'] + 1);
                            header("location: ../index.php?erroro=" . $_POST['username'] . "&type=1");
                            exit;
                            }
                        }
                    else
                        {
                        $_SESSION['login_try'] = ($_SESSION['login_try'] + 1);
                        header("location: ../index.php?erroro=" . $_POST['username'] . "&type=1");
                        exit;
                        }
                    }
                else
                    {
                    $_SESSION['login_try'] = ($_SESSION['login_try'] + 1);
                    header("location: ../index.php?erroro=" . $_POST['username'] . "&type=2");
                    exit;
                    }
                break;
            case "logout":
                session_destroy();
                setcookie('rawsessionhotel', '0');
                header("location: ../index.php");
                break;
            case "404":
                $ok = <<<PAGE
                    <html>
    <title>404</title>
	   <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="../web-gallery/css/marketing.css">
</head>
  <body style="">
<section id="oops" style="width: 100%;">
<div class="row">
  <div class="large-9 medium-9 small-12 columns small-centered">
    <h5>404: Página não Encontrada</h5>
    <h1 class="oversized">Esta página não existe...</h1>
    <p class="lead bottom40">Você pode tentar recarregar a página indo na <a href="./">homepage.</a></p>   
  </div>
</div>
</section>
        <a class="exit-off-canvas"></a>
      </div>      
    </div>
</body></html> 
PAGE;
                echo $ok;
                break;
			case "405":
			    $maintenance_text = mobbo::mobbo_settings('maintenance_text');
                $ok = <<<PAGE
                    <html>
					   <meta charset="utf-8">
    <title>405</title>
    <link type="text/css" rel="stylesheet" href="../web-gallery/css/marketing.css">
</head>
  <body style="">
<section id="oops" style="width: 100%;">
<div class="row">
  <div class="large-9 medium-9 small-12 columns small-centered">
    <h5>405: Estamos em Manutencao</h5>
    <h1 class="oversized">Opa! Manutencao.</h1>
    <p class="lead bottom40"><b>Motivo:</b> $maintenance_text   <a href="/">Voltar a Home Page</a></p>   
  </div>
</div>
</section>
        <a class="exit-off-canvas"></a>
      </div>      
    </div>
</body></html> 
PAGE;
                echo $ok;
                break;
            case 'referidos':
                echo('      <link type="text/css" rel="stylesheet" href="./web-gallery/css/marketing.css">');
                if (!isset($_SESSION['id']))
                    {
                    $ip      = $_SERVER['REMOTE_ADDR'];
                    $usuario = htmlentities($_GET['referido']);
                    $query1  = Transaction::query("SELECT ip_referida FROM users_referidos WHERE ip_referida = '" . $ip . "' LIMIT 1");
                    if (Transaction::num_rows($query1) > 0)
                        {
                        echo('<div data-alert class="alert-box alert" style="position:fixed;width:100%;height:45px;z-index:9;">
                IP Ja Registrado, voce nao Pode se Registrar por Este Referido.
                <a href="#" class="close">&times;</a>
            </div>');
                        }
                    else
                        {
                        $_SESSION['referido']    = $ip;
                        $_SESSION['referiduser'] = $usuario;
                        header("Location: /registro");
                        }
                    }
                break;
            case 'erroro':
                echo('      <link type="text/css" rel="stylesheet" href="./web-gallery/css/marketing.css">');
                $erroro = htmlentities(addslashes($_GET['erroro']));
                if ($_GET['type'] == 1)
                    {
                    echo('<div data-alert class="alert-box alert" style="position:fixed;width:100%;height:45px;z-index:9;">
                ' . $erroro . ', Suas Credenciais de Logins sao Invalidas, e essa senha Mesmo?
                <a href="#" class="close">&times;</a>
            </div>');
                    }
                if ($_GET['type'] == 2)
                    {
                    echo('<div data-alert class="alert-box alert" style="position:fixed;width:100%;height:45px;z-index:9;">
                ' . $erroro . ', Este usuario nao Existe, tem Certeza?
                <a href="#" class="close">&times;</a>
            </div>');
                    }
                break;
            case 'ban':
                echo('      <link type="text/css" rel="stylesheet" href="./web-gallery/css/marketing.css">');
                $user   = htmlentities(addslashes($_GET['ban']));
                $reason = htmlentities(addslashes($_GET['reason']));
                $reason = htmlentities(addslashes($_GET['expire']));
                echo('<div data-alert class="alert-box alert" style="position:fixed;width:100%;height:45px;z-index:9;">
                ' . $user . ', Você foi Banido, Pelo Seguinte Motivo: ' . $reason . ', Entre em Contato com os Admins!
                <a href="#" class="close">&times;</a>
            </div>');
                break;
            case 'registro':
                if (isset($_POST['username']) && isset($_POST['mail']) && isset($_POST['pass']))
                    {
                    $usuario = Security::textFilter(htmlentities($_POST['username']));
                    $mail    = Security::textFilter(htmlentities($_POST['mail']));
                    $pass    = Security::textFilter(htmlentities(md5($_POST['pass'])));
                    $firstn  = Security::textFilter(htmlentities($_POST['firstname']));
                    $lastn   = Security::textFilter(htmlentities($_POST['lastname']));
                    $query   = Transaction::query("SELECT `id` FROM `users` WHERE `mail` = '" . $mail . "'");
                    if (Transaction::num_rows($query) == 0)
                        {
                        $query = Transaction::query("SELECT `id` FROM `users` WHERE `username` = '" . $usuario . "'");
                        if (Transaction::num_rows($query) == 0)
                            {
                            if (strlen($_POST['pass']) > 5)
                                {
                                if (preg_match('`[a-z]`', $_POST['pass']))
                                    {
                                    if (preg_match('`[0-9]`', $_POST['pass']))
                                        {

                                        Transaction::query("INSERT INTO `users` (`username`, `password`, `mail`) VALUES ('" . $usuario . "', '" . $pass . "', '" . $mail . "');");

                                        $get_id             = Transaction::query("SELECT id FROM `users` WHERE `username` = '" . $usuario . "';");
                                        $get_id_result      = Transaction::fetch($get_id);
                                        $_SESSION['id']     = $get_id_result['id'];
                                        $_SESSION['userid'] = $get_id_result['id'];
                                        $_SESSION['step']   = 0;
                                        if (isset($_SESSION['referido']))
                                            {
                                            $ip     = htmlentities($_SESSION['referido']);
                                            $userne = htmlentities($_SESSION['referiduser']);
                                            Transaction::query("INSERT INTO users_referidos (usuario, ip_referida) VALUES ('" . $userne . "', '" . $ip . "');");

                                            $_SESSION['referido'] = NULL;
                                            }
                                        echo 'OKAY';
                                        }
                                    else
                                        {
                                        echo('Esta senha a muito curta e/ou invalida');
                                        }
                                    }
                                else
                                    {
                                    echo('Esta senha a muito curta e/ou invalida');
                                    }
                                }
                            else
                                {
                                echo('Esta senha a muito curta e/ou invalida');
                                }
                            }
                        else
                            {
                            echo('Esse Usuario ja Existe');
                            }
                        }
                    else
                        {
                        echo('Este e-mail esta em uso');
                        }
                    }
                else
                    {
                    echo('Erro...');
                    }
                break;
            case 'editarhome':
                if (isset($_POST['texto']))
                    {
                    $username = htmlentities($_POST['username']);
                    $texto    = htmlentities(addslashes($_POST['texto']));
                    $fundo    = htmlentities(addslashes($_POST['fundo']));
                    $cores    = htmlentities($_POST['cor']);
                    $video    = htmlentities($_POST['video']);
					if(!empty($texto))
                    Transaction::query("UPDATE users_homes SET texto = '" . $texto . "' WHERE username = '" . $username . "'");
					if(!empty($video))
                    Transaction::query("UPDATE users_homes SET video = '" . $video . "' WHERE username = '" . $username . "'");
					if(!empty($cores))
                    Transaction::query("UPDATE users_homes SET cores = '" . $cores . "' WHERE username = '" . $username . "'");
					if(!empty($fundo))
                    Transaction::query("UPDATE users_homes SET fundo = '" . $fundo . "' WHERE username = '" . $username . "'");
                    }
                break;
            case 'editarfundo':
                $fundo    = htmlentities($_POST['fundo']);
				$words    = array('http://', 'www.');
				if(strpos($fundo, $words[0]) !== false OR strpos($fundo, $words[1]) !== false)
				$fundo = 'url(' . $fundo . ')';
                $username = htmlentities($_POST['username']);
                $user     = mobbo::users_info('username');
                if ($username == $user)
                    {
                    Transaction::query("UPDATE users SET fundom = '" . $fundo . "' WHERE username = '" . $username . "'");
                    }

                break;
            case 'colocarmanutencao':
                if (mobbo::users_info("rank") >= 6)
                    {
                    if (mobbo::mobbo_settings("maintenance") == 0)
                        {
                        Transaction::query("UPDATE mobbo_settings SET value = '1' WHERE variable = 'maintenance'");
                        }
                    elseif (mobbo::mobbo_settings("maintenance") == 1)
                        {
                        Transaction::query("UPDATE mobbo_settings SET value = '0' WHERE variable = 'maintenance'");
                        }
                    header("Location: /me");
                    }
                else
                    {
                    header("Location: /me");
                    }
                break;
            case 'compraritem':
                $fetch = 0;
                $cat   = 0;
                $query = 0;
                if (isset($_POST['cat']))
                    {
                    $cat     = htmlentities(addslashes($_POST['cat']));
                    $query   = Transaction::query("SELECT * FROM mobbo_marktplatzvip WHERE id = '" . $cat . "' LIMIT 1");
                    $fetch   = Transaction::fetch($query);
                    $dolares = $fetch['dolares'];
                    if (mobbo::users_info('dolares') >= $dolares)
                        {
                        $queryCheck = Transaction::query("SELECT * FROM user_badges WHERE user_id = '" . mobbo::users_info('id') . "' AND badge_id = '" . $cat . "' LIMIT 1");
                        if (Transaction::num_rows($queryCheck) < 1)
                            {
                            Transaction::query("UPDATE users SET dolares = dolares-'" . $fetch['dolares'] . "' WHERE id = '" . mobbo::users_info('id') . "' LIMIT 1");
                            Transaction::query("INSERT INTO user_badges (user_id, badge_id) VALUES ('" . mobbo::users_info('id') . "','" . $cat . "')");
                            $dolares = mobbo::users_info('dolares');
                            echo("Item Comprado com Sucesso, Seu Balanço de Dolares agora é de $dolares");
                            }
                        else
                            {
                            echo("Você já Possui este Emblema");
                            }
                        }
                    else
                        {
                        echo("Você Não Possui Dolares Suficientes");
                        }
                    }
                else
                    {
                    echo("Você é um Hacker ?");
                    }
                break;
            case 'wallupdate':
                if (isset($_POST['update']))
                    {
//insert into wall table
                    $message = Security::textFilter($_POST['update']);
                    if ($message != "")
                        {
                        $image  = '';
                        $time   = time();
                        $video  = '';
                        $userid = mobbo::users_info('id');
                        $query  = Transaction::query("INSERT INTO `posts` (`desc`, `image_url`, `vid_url`,`date`,`userid`) VALUES ('$message', '$image', '$video','$time', '$userid')");
                        $ins_id = mysql_insert_id();
                        echo('sucess');
                        }
                    }
                break;
            default:
                die('This Action Does Not Exists');
                break;
            }
        }

    public static
            function Names()
        {
        $array = array('referidos', 'erroro', 'ban');
        return $array;
        }

    }

<?php

$a = 1;
@include('../../CORE.php');
if ($user_info['id'] == NULL or empty($user_info['id']))
    {
    echo('Voce nao esta Logado no Facebook Tente Logar Novamente Acessando Primeiramente www.facebook.com');
    exit;
    }
$result = Transaction::query("SELECT fb_id FROM users WHERE fb_id = '" . $user_info['id'] . "'");
$row    = Transaction::fetch($result);
$conic  = $row['fb_id'];
if ($conic == 0)
    {
    $usr_info  = $user_info['id'];
    $usr_name  = $user_info['name'];
    $usr_name2 = $user_info['last_name'];
    if ($user_info['last_name'] == NULL or empty($user_info['last_name']))
        {
        $usr_name2 = $user_info['name'];
        }
    $usr_mail  = $user_info['name'];
    $usr_mail2 = $user_info['mail'];
    $remote_ip = $_SERVER['REMOTE_ADDR'];
    $query2    = Transaction::query("SELECT * FROM users");
    $fetch2    = Transaction::fetch($query2);
    if ($usr_info['name'] == $fetch2['username'])
        {
        header("Location: /");
        }
    elseif ($usr_info['last_name'] == $fetch2['username'])
        {
        header("Location /");
        }
    elseif ($usr_info['mail2'] == $fetch2['mail'])
        {
        header("Location /");
        }
    else
        {
        Transaction::query("INSERT INTO users (username,password,motto,mail,rank,fb_id) VALUES ('" . $usr_name2 . "', 'f09927c417e569baaeaa561f501d3e77', 'Registrei por facebook', '" . $usr_name . "', '2', '" . $usr_info . "');");
        $q      = "SELECT * FROM users WHERE fb_id='" . $user_info['id'] . "'";
        $result = @Transaction::query($q);
        $row    = Transaction::fetch($result);
        }
    }
$q                 = "SELECT fb_id FROM users WHERE fb_id='" . $user_info['id'] . "'";
$result            = @Transaction::query($q);
$row               = Transaction::fetch($result);
$user_ida          = $row['fb_id'];
$_SESSION['fb_id'] = $user_ida;
$user_id           = $facebook->getUser();
if ($user_ida)
    {
    try
        {
        $ret_obj = $facebook->api('/me/feed', 'POST', array(
            'link'    => $msg,
            'message' => $url
        ));
        }
    catch (FacebookApiException $e)
        {
        $login_url = $facebook->getLoginUrl(array(
            'scope' => 'publish_stream'
        ));
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
        }
    }
else
    {
    echo('Voce nao esta Logado Corretamente no Facebook Acesse Primeiramente www.facebook.com Apos Isso Tente Logar Novamente');
    exit;
    }
logs::mobbo_log("facebook");
header("Location: /me?connect=true&disableFriendLinking=false&next=");
?>
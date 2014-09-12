<?php

/* Security of blaming */
$owner     = 'imnot';
$user_rank = 0;
$onlyowner = 1;

/* include the CORE */
include_once('../../CORE.php');

/*
 *
 *  mobbo 6.0 - Habbo Environment
 *  start the habbo environment
 *
 */

// mysql connect

Transaction::open(array('user' => $host_user, 'pass' => $host_pass, 'name' => $host_db, 'type' => $host_type, 'port' => $host_port, 'host' => $host));
$conn = Transaction::get();

// check the debug mode

if ($debug_mode)
    {
    ini_set("display_errors", false);
    ini_set('default_charset', 'iso-8859-1');
    header("Content-Type: text/html; charset=ISO-8859-1", true);
    error_reporting(1);
    }

// start the translation system

Translation::setLanguage($language);
Security::ddosprotect();

// the hotel settings rows


$remote_ip   = $_SERVER['REMOTE_ADDR'];
$maintenance = ( mobbo::mobbo_settings('maintenance') != 0 ) ? mobbo::mobbo_settings('maintenace') : 0;

// check the settings rows for the housekeeping
// Transaction::query ( "UPDATE mobbo_settings SET value = 'mobbo-c9-sant0ro.c9.io' WHERE variable = 'hotel_url'" ) ;
$config    = Transaction::fetch($mobbo_settings);
$sitename  = mobbo::mobbo_settings('hotel_name');
$path      = mobbo::mobbo_settings('hotel_url');
$onlines   = $online_count;
$shortname = $mobbo_name;
$adminpath = $path . "/acp/";
$pagefile  = $_SERVER['PHP_SELF'];
$key       = htmlentities($_GET['key']);
// check the date and start the dating rows

if (@ini_get('date.timezone') == null && function_exists("date_default_timezone_get"))
    {
    @date_default_timezone_set("Europe/Madrid");
    }

$H = date('H');
$i = date('i');
$s = date('s');
$m = date('m');
$d = date('d');
$Y = date('Y');
$j = date('j');
$n = date('n');


// start the user system

if (isset($_SESSION['id']))
    {

    $rawname = htmlentities($_SESSION['id']);

    $usersql = Transaction::query("SELECT * FROM users WHERE id = '" . $rawname . "' LIMIT 1");
    $myrow   = Transaction::fetch($usersql);

    $ban      = Transaction::query("SELECT * FROM bans WHERE value = '" . $myrow['username'] . "' AND bantype = 'user' or value = '" . $remote_ip . "' AND bantype = 'ip' LIMIT 1");
    $bancheck = Transaction::num_rows($ban);

    if ($myrow['ip_reg'] == "0")
        {
        Transaction::query("UPDATE users SET ip_reg = '" . $remote_ip . "' WHERE id = '" . $myrow['id'] . "'");
        }
    elseif ($bancheck > 0)
        {

        $bandata = Transaction::fetch($ban);

        $timestamp = time();
        if ($bandata['expire'] > $timestamp)
            {
            session_destroy();
            header("Location: index.php");
            exit;
            }
        else
            {
            Transaction::query("DELETE FROM bans WHERE value = '" . $name . "' AND bantype = 'user' or value = '" . $remote_ip . "' AND bantype = 'ip' LIMIT 1");
            }
        }
    $rawhotel = 0;
    $rawhotel = md5($myrow['id'] + $myrow['username'] + $myrow['password'] + Security::getUserIP());
    if (isset($_COOKIE['rawsessionhotel']))
        {
        if ($_COOKIE['rawsessionhotel'] == $rawhotel)
            {
            $logged_in = true;
            $name      = ( mobbo::HoloText($myrow['username']) != 0 ) ? mobbo::HoloText($myrow['username']) : "Guest";
            $id        = ( mobbo::HoloText($myrow['id']) != 0 ) ? mobbo::HoloText($myrow['id']) : 0;
            $fb_id     = ( mobbo::HoloText($myrow['fb_id']) != 0 ) ? mobbo::HoloText($myrow['fb_id']) : 0;
            $my_id     = ( mobbo::HoloText($myrow['id']) != 0 ) ? mobbo::HoloText($myrow['id']) : 0;
            $motto     = ( mobbo::HoloText($myrow['motto']) != 0 ) ? mobbo::HoloText($myrow['moyyo']) : "Nothing";
            $mail      = ( mobbo::HoloText($myrow['mail']) != 0 ) ? mobbo::HoloText($myrow['mail']) : "guest@guest.com";
            $rank      = ( mobbo::HoloText($myrow['rank']) != 0 ) ? mobbo::HoloText($myrow['rank']) : 0;
            $credits   = ( mobbo::HoloText($myrow['credits']) != 0 ) ? mobbo::HoloText($myrow['credits']) : 0;
            $pixels    = ( mobbo::HoloText($myrow['activity_points']) != 0 ) ? mobbo::HoloText($myrow['activity_points']) : 0;
            $look      = ( mobbo::HoloText($myrow['look']) != 0 ) ? mobbo::HoloText($myrow['look']) : "Guest";
            $online    = ( mobbo::HoloText($myrow['online']) != 0 ) ? mobbo::HoloText($myrow['online']) : "Guest";
            $user_rank = $rank;
            }
        else
            {
            setcookie('rawsessionhotel', '0');
            session_destroy();
            header("Location: index.php");
            exit;
            }
        }
    else
        {
        $user_rank = 0;
        $name      = "Guest";
        $my_id     = 0;
        $myticket  = "0";
        $logged_in = false;
        }
    }
else
    {

    $user_rank = 0;
    $name      = "Guest";
    $my_id     = 0;
    $myticket  = "0";
    $logged_in = false;
    }


/* Is the Owner of the Hotel? */
if ($onlyowner == 1)
    {
    $query = Transaction::query("SELECT id FROM users ORDER BY id ASC LIMIT 1");
    $fetch = Transaction::fetch($query);
    if ($myrow['id'] == $fetch['id'])
        $owner = 'yesiamtheowner';
    else
        $owner = 'imnot';
    }
else
    $owner = 'yesiamtheowner';

$user_rank = mobbo::users_info('rank');
if ($user_rank > 3 && $logged_in or ! $logged_in)
    {



    $hkzone = true;
    $p      = Security::textFilter($_GET['p']);
    $do     = Security::textFilter($_GET['do']);
    $page   = Security::textFilter($_GET['page']);
    $key    = Security::textFilter($_GET['key']);
    $search = Security::textFilter($_POST['search']);

    if (mobbo::session_is_registered('acp'))
        {

        $session        = $_SESSION['acp'];
        $admin_username = $_SESSION['hkusername'];
        $admin_password = $_SESSION['hkpassword'];

        $check = Transaction::query("SELECT * FROM `users` WHERE `username` = '" . $myrow['username'] . "' AND `rank` > 5 LIMIT 1");
        $valid = Transaction::num_rows($check);

        if ($valid > 0)
            {

            $tmp = Transaction::fetch($check);

            if ($p == "logout")
                {
                session_destroy();
                $notify_logout = true;
                include('login.php');
                }
            elseif ($p == "home")
                {
                $tab = 1;
                require_once('home.php');
                }
            elseif ($p == "test")
                {
                $tab = 1;
                require_once('test.php');
                }
            elseif ($p == "banners")
                {
                $tab = 3;
                require_once('banners.php');
                }
            elseif ($p == "campaigns")
                {
                $tab = 3;
                require_once('campaigns.php');
                }
            elseif ($p == "groups")
                {
                $tab = 3;
                require_once('groups.php');
                }
            elseif ($p == "news")
                {
                $tab = 3;
                require_once('news.php');
                }
            elseif ($p == "marktplatz")
                {
                $tab = 3;
                require_once('marktplatz.php');
                }
            elseif ($p == "marktplatzdo")
                {
                $tab = 3;
                require_once('marktplatzdo.php');
                }
            elseif ($p == "recommended")
                {
                $tab = 3;
                require_once('recommended.php');
                }
            elseif ($p == "settings")
                {
                $tab = 3;
                require_once('settings.php');
                }
            elseif ($p == "sitealert")
                {
                $tab = 3;
                require_once('sitealert.php');
                }
            elseif ($p == "webstore_item")
                {
                $tab = 3;
                require_once('webstore_item.php');
                }
            elseif ($p == "webstore_catalog")
                {
                $tab = 3;
                require_once('webstore_catalog.php');
                }
            elseif ($p == "banlogs")
                {
                $tab = 5;
                require_once('banlogs.php');
                }
            elseif ($p == "alert")
                {
                $tab = 5;
                require_once('alert.php');
                }
            elseif ($p == "alertlogs")
                {
                $tab = 5;
                require_once('alertlogs.php');
                }
            elseif ($p == "chatlogs")
                {
                $tab = 5;
                require_once('chatlogs.php');
                }
            elseif ($p == "onlinelogs")
                {
                $tab = 5;
                require_once('onlinelogs.php');
                }
            elseif ($p == "viptool")
                {
                $tab = 5;
                require_once('viptool.php');
                }
            elseif ($p == "viptool_bestellung")
                {
                $tab = 5;
                require_once('viptool_bestellung.php');
                }
            elseif ($p == "pubtool")
                {
                $tab = 5;
                require_once('pubtool.php');
                }
            elseif ($p == "ban")
                {
                $tab = 5;
                require_once('bantool.php');
                }
            elseif ($p == "unban")
                {
                $tab = 5;
                require_once('unbantool.php');
                }
            elseif ($p == "cloner")
                {
                $tab = 5;
                require_once('cloner.php');
                }
            elseif ($p == "badgetool")
                {
                $tab = 5;
                require_once('badgetool.php');
                }
            elseif ($p == "newswin")
                {
                $tab = 5;
                require_once('newin.php');
                }
            elseif ($p == "event")
                {
                $tab = 5;
                require_once('event.php');
                }
            elseif ($p == "fansites")
                {
                $tab = 3;
                require_once('fansites.php');
                }
            elseif ($p == "user_adv")
                {
                $tab = 5;
                require_once('user_adv.php');
                }
            elseif ($p == "calendario")
                {
                $tab = 5;
                require_once('calendario.php');
                }
            elseif ($p == "massa")
                {
                $tab = 5;
                require_once('massa.php');
                }
            elseif ($p == "helper")
                {
                $tab = 5;
                require_once('helper.php');
                }
            elseif ($p == "stafflogs")
                {
                $tab = 5;
                require_once('stafflogs.php');
                }
            elseif ($p == "users")
                {
                $tab = 5;
                require_once('users.php');
                }
            elseif ($p == "users_edit")
                {
                $tab = 5;
                require_once('users_edit.php');
                }
            elseif ($p == "ranktool")
                {
                $tab = 5;
                require_once('ranktool.php');
                }
            elseif ($p == "passwordtool")
                {
                $tab = 5;
                require_once('passwordtool.php');
                }
            elseif ($p == "transactions")
                {
                $tab = 5;
                require_once('transactions.php');
                }
            elseif ($p == "transactionsvip")
                {
                $tab = 5;
                require_once('transactionsvip.php');
                }
            elseif ($p == "minimail")
                {
                $tab = 5;
                require_once('minimail.php');
                }
            elseif ($p == "referusers")
                {
                $tab = 5;
                require_once('referusers.php');
                }
            elseif ($p == "puk")
                {
                $tab = 5;
                require_once('puk.php');
                }
            elseif ($p == "bots")
                {
                $tab = 9;
                require_once('bots.php');
                }
            elseif ($p == "bots_speech")
                {
                $tab = 9;
                require_once('bots_speech.php');
                }
            elseif ($p == "plugins")
                {
                $tab = 3;
                require_once('plugins.php');
                }
            elseif ($p == "pluginsadd")
                {
                $tab = 3;
                require_once('pluginsadd.php');
                }
            elseif ($p == "pluginsexport")
                {
                $tab = 3;
                require_once('pluginsexport.php');
                }
            elseif ($p == "templates")
                {
                $tab = 3;
                require_once('templates.php');
                }
            elseif ($p == "bots_responses")
                {
                $tab = 9;
                require_once('bots_responses.php');
                }
            else
                {
                $tab = 0;
                header("Location: " . $adminpath . "/p/home");
                exit;
                }
            }
        else
            {
            session_destroy();
            header("Location: " . $path . "");
            exit;
            }
        }
    else
        {
        include('login.php');
        }
    }
else
    {
    require_once('error.php');
    }
exit;
?>
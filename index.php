<?php

/*
 *  mobbo 6.0 - the m0vame project
 *  index.php 
 *  (c)2013 - maked by bi0s
 *
 */

if (!file_exists('setup/trava.php'))
    {
    if (file_exists('setup/index.php'))
        {
        header("Location: setup/");
        die();
        }
    }

// include the CORE file

include_once('./CORE.php');

/*
 *
 *  mobbo 5.5 - Habbo Environment
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

$mobbo_name       = ( mobbo::mobbo_settings('hotel_name') != 0 ) ? mobbo::mobbo_settings('hotel_name') : 0;
$mobbo_url        = ( mobbo::mobbo_settings('hotel_url') != 0 ) ? mobbo::mobbo_settings('hotel_url') : 0;
$remote_ip        = $_SERVER['REMOTE_ADDR'];
$maintenance      = ( mobbo::mobbo_settings('maintenance') != 0 ) ? mobbo::mobbo_settings('maintenace') : 0;
$maintenance_text = ( mobbo::mobbo_settings('maintenance_text') != 0 ) ? mobbo::mobbo_settings('maintenace_text') : 0;
$online_count     = ( mobbo::users_onlines() != 0 ) ? mobbo::users_onlines() : 0;

// check the settings rows for the housekeeping

$mobbo_settings = Transaction::query("SELECT * FROM mobbo_settings LIMIT 1");
$config         = Transaction::fetch($mobbo_settings);
$sitename       = $mobbo_name;
$path           = 'http://' . mobbo::mobbo_settings('hotel_url');
$onlines        = $online_count;
$shortname      = $mobbo_name;
$adminpath      = $path . "/theallseeingeye/hotel/br/housekeeping";
$pagefile       = $_SERVER['PHP_SELF'];

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
            @$fb_id     = ( mobbo::HoloText($myrow['fb_id']) != 0 ) ? mobbo::HoloText($myrow['fb_id']) : 0;
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

// check the maintenance

if (mobbo::mobbo_settings('maintenance') == 1)
{
 if(!isset($_GET['actions']) AND $_GET['actions'] != '405')
   {
    if (!isset($_SESSION ['id']) or mobbo::users_info('rank') < 5)
        {
        header("Location: /action/405");
        }
    }
}

// say to the system what its the filename

$pagina = $_SERVER['PHP_SELF'];

/*
 *
 * End of the Habbo Environment Parsering
 *
 */

/*
 *
 * Index.php - main file.
 *
 */

if (isset($_GET['settings']))
    $vars = mobbo::array_explode_with_keys(htmlentities($_GET['settings']));
else
    $vars = array('languages' => 1, 'settings' => 1);
$page = new Pages($vars);
echo $page->show();
die();

// End of File
?>
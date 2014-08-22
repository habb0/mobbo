<?php

/*
 *  mobbo 6.0 - the m0vame project
 *  CORE.php
 *  (c)2014 - maked by bi0s
 *
 */

/* pre start the items */

error_reporting(1);
session_start();
date_default_timezone_set("Brazil/East");

/* pre-start the cms , defines the app paths */

$server      = $_SERVER['DOCUMENT_ROOT'];
$application = '/application/';
$classes     = '/classes/';
$languages   = '/languages/';
$logs        = '/logs/';
$public      = '/public/';
$gallery     = '/gallery/';
$templat     = '/templates/';
$hkpath      = '/ase/';

/* set the variables from config.php */

$config         = parse_ini_file('settings.ini');
$app_id         = $config['app_id'];
$app_secret     = $config['app_secret'];
$site_url       = $config['site_url'];
$host           = $config['host'];
$host_user      = $config['host_user'];
$host_pass      = $config['host_pass'];
$host_db        = $config['host_db'];
$debug_mode     = $config['debug_mode'];
$logType        = $config['logtype'];
$host_type      = $config['host_type'];
$host_port      = $config['host_port'];
$backup_enabled = $config['backup_enabled'];
$backup_time    = $config['backup_time'];
$language       = $config['language'];

/* defines the app paths with "define" */

define('SERVERE', $server);
define('classes', $server . $application . $classes);
define('LANGUAGES', $server . $application . $languages);
define('PUBLIC', $server . $public . '/');
define('GALLERY', $server . $gallery . '/');
define('APPLICATION', $server . $application . '/');
define('TEMPLATES', $server . $templat . '/');
define('SERVER', $server . '/');
define('PUBLICS', $server . $public . '/');
define('HKPATH', $server . $gallery . $hkpath . '/');
define('LOGS', $server . $application . 'logs' . '/');
define('WEBGALLERY', $server . $gallery . 'web-gallery' . '/');
define('LOGEXTENSION', $logType);
define('DEBUGMODE', $debug_mode);

/* include the classes */

function __autoload($class_name)
    {
    //class directories
    $directorys = array(
        classes . '/structure/',
        classes . '/templates/',
        classes . '/databases/',
        classes . '/filesyste/',
        classes . '/enginerin/'
    );

    //for each directory
    foreach ($directorys as $directory)
        {
        //see if the file exsists
        if (file_exists($directory . $class_name . '.class.php'))
            {
            require_once($directory . $class_name . '.class.php');
            //only require the class once, so quit after to save effort (if you got more, then name them something else 
            return;
            }
        }
    }

// END OF CORE 
?>
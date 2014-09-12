<?php
/*
 * * Habbo Client v0.1a
 * * Maked by Claudio Santoro (bi0s)
 * * fb.com/sant0ros twitter: @m0vame skype: live:sant0ro
 */

/*
 * * Check if Exists Register Globals
 */
$values = array('table', 'quefa', 'colum', 'id', 'myrealip', 'column', 'sql', 'N', 'n', 'T', 't', 'host', 'hostuser', 'hostpass', 'hostdb', 'hostport', 'conn', 'ticketsql', 'ticketrow', 'ticket');
foreach ($values as $val)
    {
    /* @var $_GET type */
    /* @var $_POST type */
    if ((isset ($_GET[$val])) OR ( isset ($_POST[$val])))
        {
        die ();
        }
    }

/*
 * * Start the Session
 */
session_start ();

/*
 * * View if is Not :view-source:
 */
if (!empty ($_GET['pwrm']))
    {
    /* @var $_COOKIE type */
    if ($_COOKIE['vwsrc'] === $_GET['pwrm'])
        {
        setcookie ('vwsrc', 0);
        }
    else
        {
        header("Location: /me");
        }
    }
else
    {
    header("Location: /me");
    }

/*
 * * If Is Not Mobbo CMS
 */

$isnotmobbo = FALSE; // If You Use Lavvos or Any Other CMS that not Mobbo Change to TRUE

/*
 * *  Functions Over Client
 */

// Function IP: Get's Real User IP
function IP ()
    {
    if (array_key_exists ('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty ($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
        if (strpos ($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0)
            {
            $addr = explode (",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim ($addr[0]);
            }
        else
            {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
    else
        {
        return $_SERVER['REMOTE_ADDR'];
        }
    }

// Function Ticket: Implement User Ticket's
function Ticket ()
    {

    $data = "game-";

    for ($i = 1; $i <= 6; $i++)
        {
        $data = $data . rand (0, 9);
        }

    $data = $data . "-";

    for ($i = 1; $i <= 20; $i++)
        {
        $data = $data . rand (0, 9);
        }

    $data = $data . "-habbo-hotel-";
    $data = $data . rand (0, 5);

    return $data;
    }

/*
 * * PDO Database Querys
 */


// If is not Mobbo
if ($isnotmobbo == TRUE)
    {

    /* Include Lavvos Configuration File */
    require_once($_SERVER['DOCUMENT_ROOT'] . '/server-data.php_data_classes-config.php.php');

    /* Change the MySQL Values */
    $host     = $MySQLhostname;
    $hostuser = $MySQLusername;
    $hostpass = $MySQLpassword;
    $hostdb   = $MySQLdb;
    $hostport = 3306;

    /* Create Connection */
    if (!empty ($hostpass))
        {
        $conn = new PDO ("mysql:host={$host};port={$hostport};dbname={$hostdb}", $hostuser, $hostpass);
        }
    else
        {
        $conn = new PDO ("mysql:host={$host};port={$hostport};dbname={$hostdb}", $hostuser);
        }
    }
else
    {
    /* Read the Configuration File of Mobbo */
    $config = parse_ini_file ($_SERVER['DOCUMENT_ROOT'] . '/settings.ini');

    /* Get MySQL Values */
    $host     = $config['host'];
    $hostuser = $config['host_user'];
    $hostpass = $config['host_pass'];
    $hostdb   = $config['host_db'];
    $hostport = $config['host_port'];

    /* Open the MySQL Connection */
    if (!empty ($hostpass))
        {
        $conn = new PDO ("mysql:host={$host};port={$hostport};dbname={$hostdb}", $hostuser, $hostpass);
        }
    else
        {
        $conn = new PDO ("mysql:host={$host};port={$hostport};dbname={$hostdb}", $hostuser);
        }
    }

/*
 * * MySQL Functions
 */

/* Make a Query */

function query ($query = NULL)
    {
    try
        {
        globaL $conn;
        $result = $conn->query ($query);
        if (isset ($result))
            {

            return $result;
            }
        }
    catch (PDOException $ex)
        {
        
        }
    }

/* Make a Fetch of the Query */

function fetch ($result = NULL)
    {

    try
        {
        if (isset ($result))
            {
            $row = $result->fetch (PDO::FETCH_ASSOC);
            return $row;
            }
        else
            {
            return "0";
            }
        }
    catch (PDOException $ex)
        {
        
        }
    }

/* Count the Number of the Rows of a Query */

function num_rows ($query = NULL)
    {
    try
        {
        if (isset ($query))
            {
            $values = 0;
            while ($row    = $query->fetch (PDO::FETCH_ASSOC))
                {
                $values++;
                }
            return $values;
            }
        else
            {
            return "0";
            }
        }
    catch (PDOException $ex)
        {
        
        }
    }

/*
 * * Start the Precheck Itens 
 */

/* If The CMS is Mobbo CMS: FALSE */
if ($isnotmobbo == FALSE)
    {

    // Start the Querys
    $user_ip = IP ();
    $user_id = htmlentities (stripslashes ($_SESSION['id']));
    $cms_tic = query ("SELECT valuer FROM `mobbo_settings` WHERE `variabler` LIKE 'hotel_ticket'");
    $cms_tic = fetch ($cms_tic);
    $quefa   = $cms_tic['valuer'];
    $quefa   = explode (';', $quefa);
    $table   = htmlentities (stripslashes ($quefa[0]));
    $colum   = htmlentities (stripslashes ($quefa[1]));
    $query   = query ("SELECT $colum FROM $table WHERE id = '$user_id'");
    $query   = num_rows ($query);
    $ticket  = Ticket ();
    if ($query == 0)
        {
        query ("UPDATE $table SET $colum = '$ticket' WHERE id = '$user_id'");
        }
    else
        {
        query ("UPDATE $table SET $colum = '$ticket' WHERE id = '$user_id'");
        $ticketsql = query ("SELECT $colum FROM $table WHERE id = '$user_id'");
        $ticketrow = fetch ($ticketsql);
        $ticket    = $ticketrow[$colum];
        }
    }

/* If is Not Mobbo CMS: TRUE */
else
    {

    // Start the Querys
    $user_ip = IP ();
    $user_id = htmlentities (stripslashes ($_SESSION['id']));
    $query   = query ("SELECT auth_ticket FROM users WHERE id = '$user_id'");
    $query   = num_rows ($query);
    $ticket  = Ticket ();
    if ($query == 0)
        {
        query ("UPDATE users SET auth_ticket = '$ticket' WHERE id = '$user_id'");
        }
    else
        {
        query ("UPDATE users SET auth_ticket = '$ticket' WHERE id = '$user_id'");
        $ticketsql = query ("SELECT auth_ticket FROM users WHERE id = '$user_id'");
        $ticketrow = fetch ($ticketsql);
        $ticket    = $ticketrow['auth_ticket'];
        }
    }

/*
 * * Header of Client
 */

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'
 . '<head>'
 . '<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />'
 . '<title>Client</title>'
 . '<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>'
 . '<script>'
 . 'var jele = jQuery.noConflict();'
 . '</script>';

/*
 * * Urls Of The Header
 */

/* If is Not Mobbo CMS: True */
if ($isnotmobbo == TRUE)
    {

    $cms_url = query ("SELECT * FROM cms_settings WHERE variable = 'cms_url'");
    $cms_url = fetch ($cms_url);
    $cms_url = $cms_url['cms_url'];
    echo "<script src=\"$cms_url/web-gallery/client/js/libs2.js\" type=\"text/javascript\"></script>"
    . "<script src=\"$cms_url/web-gallery/client/js/visual.js\" type=\"text/javascript\"></script>"
    . "<script src=\"$cms_url/web-gallery/client/js/libs.js\" type=\"text/javascript\"></script>"
    . "<script src=\"$cms_url/web-gallery/client/js/common.js\" type=\"text/javascript\"></script>"
    . "<link rel=\"stylesheet\" href=\"$cms_url/web-gallery/client/css/common.css\" type=\"text/css\" />"
    . "<link rel=\"stylesheet\" href=\"$cms_url/web-gallery/client/css/process.css\" type=\"text/css\" />"
    . "<link rel=\"stylesheet\" href=\"$cms_url/web-gallery/client/css/style.css\" type=\"text/css\" />"
    . "<link rel=\"stylesheet\" href=\"$cms_url/web-gallery/client/css/habboflashclient.css\" type=\"text/css\" />"
    . "<script src=\"$cms_url/web-gallery/client/js/habboflashclient.js\" type=\"text/javascript\"></script>";
    }

/* If is Not Mobbo CMS: FALSE */
else
    {

    $cms_url = query ("SELECT valuer FROM `mobbo_settings` WHERE `variabler` LIKE 'hotel_url'");
    $cms_url = fetch ($cms_url);
    $cms_url = $cms_url['valuer'];
    echo "<script src=\"$cms_url/web-gallery/client/js/libs2.js\" type=\"text/javascript\"></script>"
    . "<script src=\"$cms_url/web-gallery/client/js/visual.js\" type=\"text/javascript\"></script>"
    . "<script src=\"$cms_url/web-gallery/client/js/libs.js\" type=\"text/javascript\"></script>"
    . "<script src=\"$cms_url/web-gallery/client/js/common.js\" type=\"text/javascript\"></script>"
    . "<link rel=\"stylesheet\" href=\"$cms_url/web-gallery/client/css/common.css\" type=\"text/css\" />"
    . "<link rel=\"stylesheet\" href=\"$cms_url/web-gallery/client/css/process.css\" type=\"text/css\" />"
    . "<link rel=\"stylesheet\" href=\"$cms_url/web-gallery/client/css/style.css\" type=\"text/css\" />"
    . "<link rel=\"stylesheet\" href=\"$cms_url/web-gallery/client/css/habboflashclient.css\" type=\"text/css\" />"
    . "<script src=\"$cms_url/web-gallery/client/js/habboflashclient.js\" type=\"text/javascript\"></script>";
    }

/*
 * * Links of Hotel
 */

/* Configure as Your WELL */
// THIS PART MUST BE EDITED >>>
$rs4         = "gamedata/DiffieHellman.php";
$furnidata   = "gamedata/furnidata_synced.xml";
$productdata = "gamedata/productdata.txt";
$variables   = "gamedata/external_variables2.txt";
$texts       = "gamedata/external_flash_texts.txt";
$url         = "http://habbro.in/";
$baseurl     = "lamariaefeia/";
$baseurln    = "gordon/RELEASE63-201408141029-609065162/";
$baseurlswf  = "HabboForex.swf";
$port        = "26790";
$ip          = "192.99.215.175";
// THIS PART MUST BE EDITED <<<<

/* Original Strings 
  var Rs4 = "rs4.php";
  var Furnidata = "furnidata.txt";
  var Productdata = "productdata.txt";
  var Variables = "external_variables.txt";
  var Texts = "external_flash_texts.txt";
  var Url = "http://localhost/";
  var BaseUrl = Url + "game/";
  var Port = "3000";
  var BaseUrlSWF = BaseUrl + "Habbo.swf";
  var Ip = "127.0.0.1";
  var Ticket = "<?php echo $ticket; ?>";
 */

/*
 * * Security of The Links
 */
echo '<script type="text/javascript">' . "\n"
 . 'var Rs4 = "' . base64_encode ($rs4) . '";' . "\n"
 . 'var Furnidata = "' . base64_encode ($furnidata) . '";' . "\n"
 . 'var Productdata = "' . base64_encode ($productdata) . '";' . "\n"
 . 'var Variables = "' . base64_encode ($variables) . '";' . "\n"
 . 'var Texts = "' . base64_encode ($texts) . '";' . "\n"
 . 'var Url = "' . base64_encode ($url) . '";' . "\n"
 . 'var BaseUrl = Url + "' . base64_encode ($baseurl) . '";' . "\n"
 . 'var BaseUrlN = BaseUrl + "' . base64_encode ($baseurln) . '";' . "\n"
 . 'var BaseUrlSWF = BaseUrlN + "' . base64_encode ($baseurlswf) . '";' . "\n"
 . 'var Port = "' . base64_encode ($port) . '";' . "\n"
 . 'var Ip = "' . base64_encode ($ip) . '";' . "\n"
 . '</script>';

/*
 * * Now The Rest of The Client
 */
?>
<noscript><meta http-equiv="refresh" content="0;url=/me"></noscript>
<script id="chocolate" type="text/javascript">
    jele (document).ready (function () {
        jele ('#chocolate').html ('');
        jele ('#client').html ('');
        jele ('object').html ('');
    });
    var _0x7be2 = ["\x41\x42\x43\x44\x45\x46\x47\x48\x49\x4A\x4B\x4C\x4D\x4E\x4F\x50", "\x51\x52\x53\x54\x55\x56\x57\x58\x59\x5A\x61\x62\x63\x64\x65\x66", "\x67\x68\x69\x6A\x6B\x6C\x6D\x6E\x6F\x70\x71\x72\x73\x74\x75\x76", "\x77\x78\x79\x7A\x30\x31\x32\x33\x34\x35\x36\x37\x38\x39\x2B\x2F", "\x3D", "", "\x65\x78\x65\x63", "\x54\x68\x65\x72\x65\x20\x77\x65\x72\x65\x20\x69\x6E\x76\x61\x6C\x69\x64\x20\x62\x61\x73\x65\x36\x34\x20\x63\x68\x61\x72\x61\x63\x74\x65\x72\x73\x20\x69\x6E\x20\x74\x68\x65\x20\x69\x6E\x70\x75\x74\x20\x74\x65\x78\x74\x2E\x0A", "\x56\x61\x6C\x69\x64\x20\x62\x61\x73\x65\x36\x34\x20\x63\x68\x61\x72\x61\x63\x74\x65\x72\x73\x20\x61\x72\x65\x20\x41\x2D\x5A\x2C\x20\x61\x2D\x7A\x2C\x20\x30\x2D\x39\x2C\x20\x27\x2B\x27\x2C\x20\x27\x2F\x27\x2C\x61\x6E\x64\x20\x27\x3D\x27\x0A", "\x45\x78\x70\x65\x63\x74\x20\x65\x72\x72\x6F\x72\x73\x20\x69\x6E\x20\x64\x65\x63\x6F\x64\x69\x6E\x67\x2E", "\x72\x65\x70\x6C\x61\x63\x65", "\x63\x68\x61\x72\x41\x74", "\x69\x6E\x64\x65\x78\x4F\x66", "\x66\x72\x6F\x6D\x43\x68\x61\x72\x43\x6F\x64\x65", "\x6C\x65\x6E\x67\x74\x68", "\x3C\x3F\x70\x68\x70\x20\x65\x63\x68\x6F\x20\x24\x74\x69\x63\x6B\x65\x74\x3B\x20\x3F\x3E", "\x50\x6C\x65\x61\x73\x65\x20\x77\x61\x69\x74\x2C\x20\x69\x73\x20\x6C\x6F\x61\x64\x69\x6E\x67", "\x31", "\x30", "\x63\x6C\x69\x65\x6E\x74", "\x6D\x65", "\x70\x6F\x70\x75\x70"];
    var keyStr = _0x7be2[0] + _0x7be2[1] + _0x7be2[2] + _0x7be2[3] + _0x7be2[4];
    function decode_base64 (_0x2ab4x3) {
        var _0x2ab4x4 = _0x7be2[5];
        var _0x2ab4x5, _0x2ab4x6, _0x2ab4x7 = _0x7be2[5];
        var _0x2ab4x8, _0x2ab4x9, _0x2ab4xa, _0x2ab4xb = _0x7be2[5];
        var _0x2ab4xc = 0;
        var _0x2ab4xd = /[^A-Za-z0-9\+\/\=]/g;
        if (_0x2ab4xd[_0x7be2[6]] (_0x2ab4x3)) {
            alert (_0x7be2[7] + _0x7be2[8] + _0x7be2[9]);
        }
        ;
        _0x2ab4x3 = _0x2ab4x3[_0x7be2[10]] (/[^A-Za-z0-9\+\/\=]/g, _0x7be2[5]);
        do {
            _0x2ab4x8 = keyStr[_0x7be2[12]] (_0x2ab4x3[_0x7be2[11]] (_0x2ab4xc ++));
            _0x2ab4x9 = keyStr[_0x7be2[12]] (_0x2ab4x3[_0x7be2[11]] (_0x2ab4xc ++));
            _0x2ab4xa = keyStr[_0x7be2[12]] (_0x2ab4x3[_0x7be2[11]] (_0x2ab4xc ++));
            _0x2ab4xb = keyStr[_0x7be2[12]] (_0x2ab4x3[_0x7be2[11]] (_0x2ab4xc ++));
            _0x2ab4x5 = (_0x2ab4x8 << 2) | (_0x2ab4x9 >> 4);
            _0x2ab4x6 = ((_0x2ab4x9 & 15) << 4) | (_0x2ab4xa >> 2);
            _0x2ab4x7 = ((_0x2ab4xa & 3) << 6) | _0x2ab4xb;
            _0x2ab4x4 = _0x2ab4x4 + String[_0x7be2[13]] (_0x2ab4x5);
            if (_0x2ab4xa != 64) {
                _0x2ab4x4 = _0x2ab4x4 + String[_0x7be2[13]] (_0x2ab4x6);
            }
            ;
            if (_0x2ab4xb != 64) {
                _0x2ab4x4 = _0x2ab4x4 + String[_0x7be2[13]] (_0x2ab4x7);
            }
            ;
            _0x2ab4x5 = _0x2ab4x6 = _0x2ab4x7 = _0x7be2[5];
            _0x2ab4x8 = _0x2ab4x9 = _0x2ab4xa = _0x2ab4xb = _0x7be2[5];
        } while (_0x2ab4xc < _0x2ab4x3[_0x7be2[14]]);
        ;
        return unescape (_0x2ab4x4);
    }
    ;
    var Ticket = "<?php echo $ticket ?>";
    var varsev = {"\x68\x6F\x74\x65\x6C\x76\x69\x65\x77\x2E\x62\x61\x6E\x6E\x65\x72\x2E\x75\x72\x6C": decode_base64 (BaseUrl) + decode_base64 (Rs4), "\x63\x6C\x69\x65\x6E\x74\x2E\x73\x74\x61\x72\x74\x69\x6E\x67": _0x7be2[16], "\x63\x6C\x69\x65\x6E\x74\x2E\x61\x6C\x6C\x6F\x77\x2E\x63\x72\x6F\x73\x73\x2E\x64\x6F\x6D\x61\x69\x6E": _0x7be2[17], "\x63\x6C\x69\x65\x6E\x74\x2E\x6E\x6F\x74\x69\x66\x79\x2E\x63\x72\x6F\x73\x73\x2E\x64\x6F\x6D\x61\x69\x6E": _0x7be2[18], "\x63\x6F\x6E\x6E\x65\x63\x74\x69\x6F\x6E\x2E\x69\x6E\x66\x6F\x2E\x68\x6F\x73\x74": decode_base64 (Ip), "\x63\x6F\x6E\x6E\x65\x63\x74\x69\x6F\x6E\x2E\x69\x6E\x66\x6F\x2E\x70\x6F\x72\x74": decode_base64 (Port), "\x73\x69\x74\x65\x2E\x75\x72\x6C": decode_base64 (Url), "\x75\x72\x6C\x2E\x70\x72\x65\x66\x69\x78": decode_base64 (Url), "\x63\x6C\x69\x65\x6E\x74\x2E\x72\x65\x6C\x6F\x61\x64\x2E\x75\x72\x6C": decode_base64 (Url) + _0x7be2[19], "\x63\x6C\x69\x65\x6E\x74\x2E\x66\x61\x74\x61\x6C\x2E\x65\x72\x72\x6F\x72\x2E\x75\x72\x6C": decode_base64 (Url) + _0x7be2[20], "\x63\x6C\x69\x65\x6E\x74\x2E\x63\x6F\x6E\x6E\x65\x63\x74\x69\x6F\x6E\x2E\x66\x61\x69\x6C\x65\x64\x2E\x75\x72\x6C": decode_base64 (Url) + _0x7be2[20], "\x65\x78\x74\x65\x72\x6E\x61\x6C\x2E\x76\x61\x72\x69\x61\x62\x6C\x65\x73\x2E\x74\x78\x74": decode_base64 (BaseUrl) + decode_base64 (Variables), "\x65\x78\x74\x65\x72\x6E\x61\x6C\x2E\x74\x65\x78\x74\x73\x2E\x74\x78\x74": decode_base64 (BaseUrl) + decode_base64 (Texts), "\x70\x72\x6F\x64\x75\x63\x74\x64\x61\x74\x61\x2E\x6C\x6F\x61\x64\x2E\x75\x72\x6C": decode_base64 (BaseUrl) + decode_base64 (Productdata), "\x66\x75\x72\x6E\x69\x64\x61\x74\x61\x2E\x6C\x6F\x61\x64\x2E\x75\x72\x6C": decode_base64 (BaseUrl) + decode_base64 (Furnidata), "\x75\x73\x65\x2E\x73\x73\x6F\x2E\x74\x69\x63\x6B\x65\x74": _0x7be2[17], "\x73\x73\x6F\x2E\x74\x69\x63\x6B\x65\x74": Ticket, "\x70\x72\x6F\x63\x65\x73\x73\x6C\x6F\x67\x2E\x65\x6E\x61\x62\x6C\x65\x64": _0x7be2[18], "\x66\x6C\x61\x73\x68\x2E\x63\x6C\x69\x65\x6E\x74\x2E\x75\x72\x6C": decode_base64 (BaseUrlN), "\x66\x6C\x61\x73\x68\x2E\x63\x6C\x69\x65\x6E\x74\x2E\x6F\x72\x69\x67\x69\x6E": _0x7be2[21]};
</script>
<script type="text/javascript">
    var flashvars = {
        "client.allow.cross.domain": "0",
        "client.notify.cross.domain": "1",
        "connection.info.host": "game-br.habbo.com",
        "connection.info.port": "30000,993",
        "site.url": "http://www.habbo.com.br",
        "url.prefix": "http://www.habbo.com.br",
        "client.reload.url": "http://www.habbo.com.br/client",
        "client.fatal.error.url": "http://www.habbo.com.br/flash_client_error",
        "client.connection.failed.url": "http://www.habbo.com.br/client_connection_failed",
        "logout.url": "http://www.habbo.com.br/account/disconnected?reason=%25reason%25%26origin=%25origin%25",
        "logout.disconnect.url": "http://www.habbo.com.br/account/disconnected?reason=logout%26origin=%25origin%25",
        "external.variables.txt": "http://www.habbo.com.br/gamedata/external_variables/83f58985ec49d9c7dc9e524d4f68836d341286e2",
        "external.texts.txt": "http://www.habbo.com.br/gamedata/external_flash_texts/3eb54f65ecaa48ac8092e67662aaef28ad1287c8",
        "external.figurepartlist.txt": "http://www.habbo.com.br/gamedata/figuredata/756ab0dfbc7984d12e419deb09b2b402753a2d38",
        "external.override.texts.txt": "http://www.habbo.com.br/gamedata/override/external_flash_override_texts/39711320da39a3ee5e6b4b0d3255bfef95601890afd80709",
        "external.override.variables.txt": "http://www.habbo.com.br/gamedata/override/external_override_variables/39711320da39a3ee5e6b4b0d3255bfef95601890afd80709",
        "productdata.load.url": "http://www.habbo.com.br/gamedata/productdata/4dc94aa5f7db62f04db8ddda915a361dd8b6d703",
        "furnidata.load.url": "http://www.habbo.com.br/gamedata/furnidata_xml/37d82b5b10d07fa1fb6433eb308938f590cc93c6",
        "sso.ticket": "f5abe4f3-da4b-419a-abc7-7afbf649f28d-67699095",
        "processlog.enabled": "1",
        "account_id": "67699095",
        "client.starting": "Por favor aguarde! O Habbo está carregando...",
        "flash.client.url": "\//habboo-a.akamaihd.net/gordon/RELEASE63-201409031305-152300855/",
        "user.hash": "6769909568f474c34fa8cbe39aeb1f0b8a60fd05",
        "facebook.user": "1",
        "has.identity": "1",
        "flash.client.origin": "popup",
        "nux.lobbies.enabled": "true",
        "country_code": "BR"
    };
    var params =
            {
                "base": decode_base64 (BaseUrlN) + "/",
                "allowScriptAccess": "always",
                "menu": "false"
            };
    swfobject.embedSWF (decode_base64 (BaseUrlSWF), "client", "100%", "100%", "10.0.0", "http://habbo.com/expressInstall.swf", varsev, params, null);
</script>
</head>
<body id="client" class="flashclient">
<div class="oi" style="background-color:black"></div>
    <div id="overlay"></div>
    <div id="client-ui" >
        <div id="flash-wrapper" style="height:100% !important;min-height:100% !important;">
            <div id="flash-container">
 <!--               <script type="text/javascript">
                    $ ('content').show ();
                </script>-->
            </div>
        </div>
</body>
</html>



<?php
$table    = 0;
$quefa    = 0;
$column   = 0;
$myrealip = Security::getUserIP();
$id       = htmlentities($_SESSION['id']);
$quefa    = mobbo::mobbo_settings('hotel_ticket');
$quefa    = explode(';', $quefa);
$table    = htmlentities(stripslashes($quefa[0]));
$colum    = htmlentities(stripslashes($quefa[1]));
$SQL      = Transaction::query("SELECT $colum FROM $table WHERE id = '" . $id . "'");



$N = Transaction::num_rows($SQL);
if ($N == 0)
    {
    Transaction::query("UPDATE $table SET $colum = '" . Security::GenerateTicket() . "' WHERE id = '" . $id . "'");
    }
else
    {
    Transaction::query("UPDATE $table SET $colum = '" . Security::GenerateTicket() . "' WHERE id = '" . $id . "'");
    $ticketsql = Transaction::query("SELECT $colum FROM $table WHERE id = '" . $id . "'");
    $ticketrow = Transaction::fetch($ticketsql);
    $ticket    = $ticketrow[$colum];
    }


$path = "http://localhost/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <title>[[hotel_name]]</title>
    <script src="<?php echo $path; ?>/web-gallery/client/js/libs2.js" type="text/javascript"></script>
    <script src="<?php echo $path; ?>/web-gallery/client/js/visual.js" type="text/javascript"></script>
    <script src="<?php echo $path; ?>/web-gallery/client/js/libs.js" type="text/javascript"></script>
    <script src="<?php echo $path; ?>/web-gallery/client/js/common.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo $path; ?>/web-gallery/client/css/common.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $path; ?>/web-gallery/client/css/process.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $path; ?>/web-gallery/client/css/style.css" type="text/css" />
    <link rel="stylesheet" href="[[hotel_url]]/web-gallery/client/css/habboflashclient.css" type="text/css" />
    <script src="[[hotel_url]]/web-gallery/client/js/habboflashclient.js" type="text/javascript"></script>
    <script type="text/javascript">
        var BaseUrl = "http://localhost/game/";
        var flashvars =
                {
                    "hotelview.banner.url": "http://localhost/game/rs4.php",
                    "client.starting": "Please wait, Ibbu is loading",
                    "client.allow.cross.domain": "1",
                    "client.notify.cross.domain": "0",
                    "connection.info.host": "127.0.0.1",
                    "connection.info.port": "300",
                    "site.url": "http://localhost/",
                    "url.prefix": "http://localhost/game/",
                    "client.reload.url": "http://localhost/client",
                    "client.fatal.error.url": "http://localhost/me",
                    "client.connection.failed.url": "http://localhost/me",
                    "external.variables.txt": "http://localhost/game/external_variables.txt",
                    "external.texts.txt": "http://localhost/game/external_flash_texts.txt",
                    "productdata.load.url": "http://localhost/game/productdata.txt",
                    "furnidata.load.url": "http://localhost/game/furnidata.txt",
                    "use.sso.ticket": "1",
                    "sso.ticket": "<?php echo $ticket; ?>",
                    "processlog.enabled": "0",
                    "flash.client.url": BaseUrl,
                    "flash.client.origin": "popup"
                };
        var params =
                {
                    "base": BaseUrl + "/",
                    "allowScriptAccess": "always",
                    "menu": "false"
                };
        swfobject.embedSWF (BaseUrl + "/Habbo.swf", "client", "100%", "100%", "10.0.0", "{swf_folder}/expressInstall.swf", flashvars, params, null);
    </script>
</head>
<body id="client" class="flashclient">
    <div id="overlay"></div>
    <div id="client-ui" >
        <div id="flash-wrapper" style="height:100% !important;min-height:100% !important;">
            <div id="flash-container">
                <script type="text/javascript">
                    $ ('content').show ();
                </script>
            </div>
        </div>
</body>
</html>


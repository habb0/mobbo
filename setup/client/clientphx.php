<?php
$myrealip = $_SERVER['REMOTE_ADDR'];
if (empty($_SESSION['fb_id']))
    {
    $SQL = Transaction::query("SELECT auth_ticket FROM users WHERE id = '" . $id . "'");

    echo mysql_error();
    $N = Transaction::num_rows($SQL);
    if ($N == 0)
        {
        Transaction::query("UPDATE `users` SET `auth_ticket` = '" . Security::GenerateTicket() . "', `ip_last` = '" . $myrealip . "' WHERE id = '" . $id . "'") or die(mysql_error());
        }
    else
        {
        Transaction::query("UPDATE `users` SET `auth_ticket` = '" . Security::GenerateTicket() . "', `ip_last` = '" . $myrealip . "' WHERE id = '" . $id . "'") or die(mysql_error());
        $ticketsql = Transaction::query("SELECT auth_ticket FROM users WHERE id = '" . $id . "'") or die(mysql_error());
        $ticketrow = Transaction::fetch($ticketsql);
        }
    }
else
    {
    $SQL = Transaction::query("SELECT auth_ticket FROM users WHERE fb_id = '" . $fb_id . "'");

    echo mysql_error();
    $N = Transaction::num_rows($SQL);
    if ($N == 0)
        {
        Transaction::query("UPDATE `users` SET `auth_ticket` = '" . Security::GenerateTicket() . "', `ip_last` = '" . $myrealip . "' WHERE fb_id = '" . $fb_id . "'") or die(mysql_error());
        }
    else
        {
        Transaction::query("UPDATE `users` SET `auth_ticket` = '" . Security::GenerateTicket() . "', `ip_last` = '" . $myrealip . "' WHERE fb_id = '" . $fb_id . "'") or die(mysql_error());
        }
    $ticketsql = Transaction::query("SELECT auth_ticket FROM users WHERE fb_id = '" . $fb_id . "'") or die(mysql_error());
    $ticketrow = Transaction::fetch($ticketsql);
    }
logs::mobbo_log("client");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $sitename; ?></title>

<script type="text/javascript">
    var andSoItBegins = (new Date ()).getTime ();
</script>

<script type="text/javascript">
    var andSoItBegins = (new Date ()).getTime ();
</script>
<link rel="shortcut icon" href="<?php echo $path; ?>web-gallery/v2/images/favicon.ico" type="image/vnd.microsoft.icon" />

<script src="<?php echo $path; ?>/web-gallery/client/web-gallery/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/web-gallery/client/web-gallery/js/visual.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/web-gallery/client/web-gallery/js/libs.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/web-gallery/client/web-gallery/js/common.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $path; ?>/web-gallery/client/css/common.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $path; ?>/web-gallery/client/css/process.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $path; ?>/web-gallery/client/css/style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $path; ?>/web-gallery/client/css/habboflashclient.css" type="text/css" />
<script src="<?php echo $path; ?>/web-gallery/client/web-gallery/js/habboflashclient.js" type="text/javascript"></script>


<script type="text/javascript">
    var ad_keywords = "petschke,diwox,gender%3Am,age%3A17";
    var ad_key_value = "kvage=17;kvgender=m;kvtags=diwox:petschke";
</script>
<script type="text/javascript">
    document.habboLoggedIn = true;
    var habboName = "<?php echo $name; ?>";
    var habboId = <?php echo $id; ?>;
    var facebookUser = false;
    var habboReqPath = "";
    var habboStaticFilePath = "<?php echo $path; ?>//web-gallery";
    var habboImagerUrl = "<?php echo $path; ?>//habbo-imaging/";
    var habboPartner = "";
    var habboDefaultClientPopupUrl = "<?php echo $path; ?>//client";
    window.name = "3981c0260af76a9eb267d9b2dd7cc602d4c7b7bf";
    if (typeof HabboClient != "undefined") {
        HabboClient.windowName = "3981c0260af76a9eb267d9b2dd7cc602d4c7b7bf";
    }
</script>

</script>

<meta property="fb:app_id" content="163085011898" />

<noscript>
    <meta http-equiv="refresh" content="0;url=/client/nojs" />
</noscript>


<script type="text/javascript">
    FlashExternalInterface.loginLogEnabled = true;

    FlashExternalInterface.logLoginStep ("web.view.start");

    if (top == self) {
        FlashHabboClient.cacheCheck ();
    }

    var flashvars = {
        "client.allow.cross.domain": "1",
        "client.notify.cross.domain": "0",
        "connection.info.host": "game-pixelbr.no-ip.biz",
        "connection.info.port": "%33%30%30",
        "site.url": "<?php echo $path; ?>",
        "url.prefix": "<?php echo $path; ?>",
        "client.reload.url": "<?php echo $path; ?>client",
        "client.fatal.error.url": "<?php echo $path; ?>error",
        "client.connection.failed.url": "<?php echo $path; ?>client",
        "external.hash": "",
        "external.variables.txt": "<?php echo $path; ?>swf/external_variables.txt",
        "external.texts.txt": "<?php echo $path; ?>swf/external_flash_texts.txt",
        "productdata.load.url": "<?php echo $path; ?>swf/productdata.txt",
        "furnidata.load.url": "<?php echo $path; ?>swf/furnidata.txt",
        "use.sso.ticket": "1",
        "sso.ticket": "<?php echo $ticketrow['auth_ticket']; ?>",
        "processlog.enabled": "1",
        "account_id": "1",
        "client.starting": "Por favor aguarde! O Habbrook esta carregando...",
        "flash.client.url": "<?php echo $path; ?>swf/",
        "user.hash": "31385693ae558a03d28fc720be6b41cb1ccfec02",
        "has.identity": "1",
        "flash.client.origin": "popup"


    };
    var params = {
        "base": "<?php echo $path; ?>swf/",
        "allowScriptAccess": "always",
        "menu": "false"
    };

    if (! (HabbletLoader.needsFlashKbWorkaround ())) {
        params["wmode"] = "opaque";
    }

    FlashExternalInterface.signoutUrl = "<?php echo $path; ?>account/logout?token=d82638fa5c83fde852540825adf57f1373f71576";

    var clientUrl = "<?php echo $path; ?>swf/habbo.swf";

    swfobject.embedSWF (clientUrl, "flash-container", "100%", "100%", "10.0.0", "<?php echo $path; ?>web-gallery/flash/expressInstall.swf", flashvars, params);

    window.onbeforeunload = unloading;
    function unloading () {
        var clientObject;
        if (navigator.appName.indexOf ("Microsoft") != - 1) {
            clientObject = window["flash-container"];
        } else {
            clientObject = document["flash-container"];
        }
        try {
            clientObject.unloading ();
        } catch (e) {
        }
    }
</script>

<meta name="description" content="Lavvo Hotel: haz amig@s, �nete a la diversi�n y date a conocer." />
<meta name="keywords" content="lavvo hotel, mundo, virtual, red social, gratis, comunidad, personaje, chat, online, adolescente, roleplaying, unirse, social, grupos, forums, seguro, jugar, juegos, amigos, adolescentes, raros, furni raros, coleccionable, crear, coleccionar, conectar, furni, muebles, mascotas, dise�o de salas, compartir, expresi�n, placas, pasar el rato, m�sica, celebridad, visitas de famosos, celebridades, juegos en l�nea, juegos multijugador, multijugador masivo" />



<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo $path; ?>web-gallery/static/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php echo $path; ?>web-gallery/static/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php echo $path; ?>web-gallery/static/styles/ie6.css" type="text/css" />
<script src="<?php echo $path; ?>web-gallery/static/web-gallery/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css">
body { behavior: url(/web-gallery/js/csshover.htc); }
</style>
<![endif]-->

<meta name="build" content="63-BUILD406 - 09.05.2011 23:04 - de" />
</head>
<body id="client" class="flashclient">
    <div id="overlay"></div>
    <img src="<?php echo $path; ?>web-gallery/v2/images/page_loader.gif" style="position:absolute; margin: -1500px;" />

    <div id="overlay"></div>
    <div id="client-ui" >
        <div id="flash-wrapper" style="height:100% !important;min-height:100% !important;">
            <div id="flash-container">
                <div id="content" style="width: 400px; margin: 20px auto 0 auto; display: none">
                    <div class="cbb clearfix">
                        <h2 class="title">Por favor, actualiza tu Flash Player a la �ltima versi�n</h2>

                        <div class="box-content">
                            <p>Puedes instalar y descargar Adobe Flash Player aqu�: <a href="http://get.adobe.com/flashplayer/">Instala Flash player</a>. M�s instrucciones para su instalaci�n aqu�: <a href="http://adobe.com/products/flashplayer/productinfo/instructions/">M�s informaci�n</a></p>
                            <p><a href="http://adobe.com/go/getflashplayer"><img src="<?php echo $path; ?>web-gallery/v2/images/client/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
                        </div>
                    </div>

                </div>
                <script type="text/javascript">
                    $ ('content').show ();
                </script>

                <noscript>
                    <div style="width: 400px; margin: 20px auto 0 auto; text-align: center">
                        <p>If you are not automatically redirected, please <a href="/client">click here</a></p>
                    </div>
                </noscript>
            </div>

        </div>
        <div id="fb-root"></div>


</body>
</html>


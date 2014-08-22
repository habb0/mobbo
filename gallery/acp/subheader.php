<?php
if ($hkzone !== true)
    {
    header("Location: index.php?throwBack=true");
    exit;
    }

if (empty($pagename))
    {
    $pnme = "Painel de Controle";
    }
else
    {
    $pnme = "Painel de Controle - " . $pagename . " ";
    }

$search       = Security::textFilter($_POST['search']);
$searchheader = Security::textFilter($_POST['searchheader']);
$username     = mobbo::users_info('username');

if (isset($_POST['searchname']))
    {
    if ($check = Transaction::num_rows($sql   = Transaction::query("SELECT * FROM users WHERE username = '" . Security::textFilter($_POST['searchname']) . "' LIMIT 1")) > 0)
        {
        $rowid = Transaction::fetch($sql);
        header("location: " . $adminpath . "/p/users_edit&key=" . $rowid['id'] . "");
        }
    else
        {
        echo"<script>alert(\"Der Username " . $_POST['searchname'] . " konnte nicht gefunden werden!\")</script>";
        }
    }
?>
<html class=" js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" lang="en" data-useragent="Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36" style=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <head>

        <base href="<?php echo $adminpath; ?>">        
		<meta http-equiv="content-t ype" content="text/html; charset=iso-8859-1" /> 
        <title><?php echo $pnme; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache" />
        <link rel="shortcut icon" href="/favicon.ico" />




        <link type="text/css" rel="stylesheet" href="../web-gallery/css/marketing.css">
		<script src="../web-gallery/js/jquery.js"></script>
        <link href="../web-gallery/css/foundation.css" rel="stylesheet">

  
        <link href="/js/google-code-prettify/prettify.css" rel="stylesheet" type="text/css">
        <style>
            table tbody tr td:last-child {
                border-bottom: 1px transparent solid;
                border-right: 1px transparent solid;
            }
        </style>
    <nav class="top-bar" data-topbar>
    <ul class="title-area">
      <li class="name">
      <h1><a>Housekeeping</a></h1>
      </li>
    </ul>
	<section class="top-bar-section" id="fudeugeral">
	<ul class="right">
      <li class="has-dropdown active">
        <a href="#">Menu</a>
        <ul class="dropdown">
                        <li><a href="p/home">Principal</a></li>
                        <li><a href="p/settings">Configurações</a></li>
                        <li><a href="p/alert">Alertas</a></li>
                        <li><a href="p/plugins">Plugins</a></li>
                        <li><a href="p/templates">Templates</a></li>
                        <li><a href="p/badgetool">Emblemas</a></li>
                        <li><a href="p/news">Notícias</a></li>
                        <li><a href="p/campaigns">Campanhas</a></li>
                        <li><a href="p/users">Usuários</a></li>
                        <li><a href="p/ban">Banimentos</a></li>
                        <li><a href="p/ranktool">Cargos</a></li>
                        <li><a href="p/viptool">Ferramenta VIP</a></li>
                        <li><a href="p/marktplatz">Loja</a></li>
        </ul>
      </li>
    </ul>

	 <ul class="left">
      <li><a href="/">Go to Home</a></li>
	  <li><a href="/client">Go to Client</a></li>
    </ul>
  </section>
  </section>





    </nav>

    <?php
    if ($pageid !== "login")
        {
        ?>

        <body>







                        <p><p><p>
                        <div class='outerdiv' id='global-outerdiv'>
                            <?php
                            } if ($pageid !== "login" && $pageid !== "home")
                            {
                            ?>
                            <table cellpadding='0' cellspacing='8' width='100%' id='tablewrap'>
                                <tr> <td width='16%' valign='top' id='leftblock'>
                                        <div>
                                            <?php @include('menu.php'); ?>
                                        </div>
                                    </td>
                                    <td width='78%' valign='top' id='rightblock'>
                                        <div>
                                            </p> </p> </p>
                                        <?php } ?>
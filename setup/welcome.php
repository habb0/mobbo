<?php
if (!file_exists('trava.php'))
    {
    @include('../CORE.php');
	Transaction::open(array('user' => $host_user, 'pass' => $host_pass, 'name' => $host_db, 'type' => $host_type, 'port' => $host_port, 'host' => $host));
    $conn = Transaction::get();
	$file = file_get_contents('install.sql');
    Transaction::query($file);
    if (isset($_SESSION['hotel_name']))
        {
        $hotelname = $_SESSION['hotel_name'];
        $hosting   = $_SESSION['host_url'];
        Transaction::query("UPDATE mobbo_settings SET value = '" . $hotelname . "' WHERE variable = 'hotel_name'");
        Transaction::query("UPDATE mobbo_settings SET value = '" . $hosting . "' WHERE variable = 'hotel_url'");
        }
    $mensagem = "Setup Travado";
    $log      = fopen("trava.php", "a+");
    fwrite($log, $mensagem);
    $a        = 1;
    if ($a == 1)
        {
        echo('<META HTTP-EQUIV="Refresh" CONTENT="10; URL=../index.php">');
        }
    ?>
    <html class=" js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" lang="en" data-useragent="Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36" style=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta charset="utf-8">
            <title> mobbo - Welcome </title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="../favicon.ico" type="image/x-icon">
            <link rel="stylesheet" href="./gallery/css/foundation.css" />
            <link rel="stylesheet" href="./gallery/css/cms.css" />
            <link type="text/css" rel="stylesheet" href="./gallery/css/marketing.css">
        </head>
        <div class="row">
            <form method="post" name="okay" id="okay">
                <div class="large-12 columns">
                    <br><h4>Setup</h4><br>
                    <div class="panel">
                        <h4> Aguarde a CMS Está Sendo Instalada!</h4>
                        <h5>Você será Redirecionado para a CMS Quando o Setup Acabar, Não Esqueça de Apagar a pasta Setup. Obrigado por Usar a Mobbo</h5>
                    </div>
                </div>
        </div>
    <?php } ?>
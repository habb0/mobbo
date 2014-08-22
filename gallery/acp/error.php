<?php
$is_maintenance = "true";
require_once('../data_classes/server-data.php_data_classes-core.php.php');
?>
<link rel="shortcut icon" href="<?php echo $path; ?>/acp/favicon.ico" />
<html>
    <head>
        <title><?php echo $shortname; ?></title>
        <link href="<?php echo $path; ?>/acp/css/error.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="wrapper">
            <div class="contentwrapper">
                <div class="content">

                    <h3>Acesso Negado!</h3>

                    <p>O IP <b><?php echo $remote_ip; ?></b> no tem permisso para visualizar est pgina do site!</p>
                    <p>Contate ao administrador do site para mais informaes</p>
                </div></div></div></body></html>
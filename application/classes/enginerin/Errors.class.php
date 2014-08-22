<?php

/*
 *  mobbo 6.0 - the m0vame project
 *  class ERRORS
 *  (c)2013 - maked by bi0s
 *
 */

class errors
    {

    public static
            function page()
        {
        $echo2 = <<<PAGE
<html>
<style type="text/css">
body {
background-image:url(./gallery/error/mobboErrorBG.png) !important;
background-repeat:repeat !important;
}
#bg {
background-image:url(./gallery/error/mobboErrorBG.png) !important;
background-repeat:repeat !important;
width:50000px;
height:50000px;
position:fixed;
}
#restrito {
margin-top: -100px;
margin-left: -160px;
position:absolute;
z-index:99999999999999999;
background-repeat:no-repeat;
width:100%;
}
#he {
position:absolute;
z-index:999999999999999999;
color:white;
margin-top:110px;
margin-left:195px;
font-size:24px;
font-family:"Segoe UI";
font-weight:lighter;
}
#hl
{
font-size:45px;
font-family:"OpenSans";
}
@font-face {  
	font-family: "OpenSans";
    src: url("http://movim.eu/fonts/Open_Sans/OpenSans-Light.ttf");
}
</style>
<body>
<img id="restrito" src="./gallery/error/mobboErrorDefault.png" alt="Erro!"/> <br>
<div id="bg"></div>
<h1 id="he">
PAGE;
        return $echo2;
        }

    public static
            function errors($numero, $mensagem, $arquivo, $linha)
        {
        if (($numero == E_ERROR) || ($numero == E_USER_ERROR))
            {
            Transaction::log("[Erro] $mensagem in file: $arquivo, on line: $linha", "error");
            echo $this->page();
            echo " <b id=\"hl\">#" . $numero . " Opa!</b><br>";
            echo "Detalhes: " . $mensagem . " ; No Arquivo: " . $arquivo . " ; e Na Linha: " . $linha . " ";
            echo "</h1>";
            die();
            }
        }

    public static
            function shutdown()
        {
        # Getting last error
        $error = error_get_last();

        # Checking if last error is a fatal error 
        if (($error['type'] === E_ERROR) || ($error['type'] === E_USER_ERROR))
            {
            # Here we handle the error, displaying HTML, logging, ...
            echo $this->page();
            echo " <b id=\"hl\">#" . $error['type'] . " Opa!</b><br>";
            echo "Detalhes: " . $error['message'] . " ; No Arquivo: " . $error['file'] . " ; e Na Linha: " . $error['line'] . " ";
            echo "</h1>";
            die();
            }
        }

    }

function eHandler()
    {
    $this->shutdown();
    }

/* activate errors */
set_error_handler('Error::errors');
register_shutdown_function('eHandler');
?>
<?php

/*
 *  mobbo 6.0 - the m0vame project
 *  class ERRORS
 *  (c)2013 - maked by bi0s
 *
 */

final class Errors
    {

     protected static
            function Page()
        {
        $echo2 = '<html><style>body{background-image:url(e/mobboErrorBG.png)!important;background-repeat:repeat!important;}#bg{background-image:url(e/mobboErrorBG.png)!important;background-repeat:repeat!important;width:50000px;height:50000px;position:fixed;}#restrito{margin-top:-100px;margin-left:-160px;position:absolute;z-index:99999999999999999;background-repeat:no-repeat;width:100%;}#he{position:absolute;z-index:999999999999999999;color:#FFF;margin-top:110px;margin-left:300px;font-size:24px;font-family:"Segoe UI";font-weight:lighter;}#hl{font-size:45px;font-family:OpenSans;}@font-face{font-family:OpenSans;src:url(e/OpenSans-Light.ttf);}</style><body><img id="restrito" src="e/mobboErrorDefault.png" alt="Erro!"/> <br><div id="bg"></div><h1 id="he">';
        return $echo2;
        }

    public static
            function Show($numero, $mensagem, $arquivo, $linha)
        {
        if (($numero == E_ERROR) || ($numero == E_USER_ERROR))
            {
            echo self::Page();
            echo " <b id=\"hl\">#" . $numero . " Opa!</b><br>";
            echo "Detalhes: " . $mensagem . " ; No Arquivo: " . $arquivo . " ; e Na Linha: " . $linha . " ";
            echo "</h1>";
            die();
            }
			$messaging = new Message;
            $messaging->log("[Erro] $mensagem in file: $arquivo, on line: $linha", "error");
        }

    public static
            function Shutdown()
        {
        # Getting last error
        $error = error_get_last();

        # Checking if last error is a fatal error 
        if (($error['type'] === E_ERROR) || ($error['type'] === E_USER_ERROR))
            {
            # Here we handle the error, displaying HTML, logging, ...
            echo self::Page();
            echo " <b id=\"hl\">#" . $error['type'] . " Opa!</b><br>";
            echo "Detalhes: " . $error['message'] . " ; No Arquivo: " . $error['file'] . " ; e Na Linha: " . $error['line'] . " ";
            echo "</h1>";
            die();
            }
        }

    }




?>
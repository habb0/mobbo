<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Security
 *
 * @author Gisele Santoro
 */
class Security
    {

    public static
            function ddosprotect()
        {
        $cookie      = isset($_COOKIE['cookie1']) ? $_COOKIE['cookie1'] : 0;
        if (isset($_COOKIE['cookie2']))
            $othercookie = $_COOKIE['cookie2'];


        if ($cookie && $othercookie > 0)
            $iptime = 100;
        else
            $iptime = 100;


        $ippenalty = 60;


        if ($cookie && $othercookie > 0)
            $ipmaxvisit = 300;
        else
            $ipmaxvisit = 300;


        $iplogdir  = LOGS . 'ddos/';
        $iplogfile = "iplog.dat";

        $ipfile  = substr(md5($_SERVER["REMOTE_ADDR"]), -2);
        $oldtime = 0;
        if (file_exists($iplogdir . $ipfile))
            $oldtime = filemtime($iplogdir . $ipfile);

        $time    = time();
        if ($oldtime < $time)
            $oldtime = $time;
        $newtime = $oldtime + $iptime;

        if ($newtime >= $time + $iptime * $ipmaxvisit)
            {
            touch($iplogdir . $ipfile, $time + $iptime * ($ipmaxvisit - 1) + $ippenalty);
            $oldref     = $_SERVER['HTTP_REFERER'];
            header("HTTP/1.0 503 Service Temporarily Unavailable");
            header("Connection: close");
            header("Content-Type: text/html");
            echo "<html><title>DDOS DETECTADO</title>
<body bgcolor=#999999 text=#ffffff link=#ffff00>
<font face='Verdana, Arial'><p><b>
<h1>O Acesso Foi Temporariamente Suspenso.</h1>Muitas p�ginas foram abertas simultaneamente com o seu endere�o IP, Esta Bloqueado Lacy INC -(plus de " . $ipmaxvisit . " visites en " . $iptime . " secondes).</b>
";
            echo "<br />Espere " . $ippenalty . " Segundos para abrir novamente..</p></font></body></html>";
            touch($iplogdir . $iplogfile);
            $fp         = fopen($iplogdir . $iplogfile, "a");
            $yourdomain = $_SERVER['HTTP_HOST'];
            if ($fp)
                {
                $useragent  = "<unknown user agent>";
                if (isset($_SERVER["HTTP_USER_AGENT"]))
                    $useragent  = $_SERVER["HTTP_USER_AGENT"];
                fputs($fp, $_SERVER["REMOTE_ADDR"] . " " . date("d/m/Y H:i:s") . " " . $useragent . "n");
                fclose($fp);
                $yourdomain = $_SERVER['HTTP_HOST'];


                $_SESSION['reportedflood'] = 1;
                }
            exit();
            }
        else
            $_SESSION['reportedflood'] = 0;

        touch($iplogdir . $ipfile, $newtime);
        }

    public static
            function injection($string)
        {
        $string = stripslashes($string);
        return $string;
        }

    public static
            function textFilterHK($string = '')
        {
        return Security::injection(stripslashes(trim($string)));
        }

    public static
            function textFilter($string = '')
        {
        return Security::injection(stripslashes(trim(htmlspecialchars($string))));
        }

    public static
            function GenerateTicket()
        {

        $data = "ST-";

        for ($i = 1; $i <= 6; $i++)
            {
            $data = $data . rand(0, 9);
            }

        $data = $data . "-";

        for ($i = 1; $i <= 20; $i++)
            {
            $data = $data . rand(0, 9);
            }

        $data = $data . "-mobbo-fe-";
        $data = $data . rand(0, 5);

        return $data;
        }

    public static
            function getUserIP()
        {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0)
                {
                $addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim($addr[0]);
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

    }

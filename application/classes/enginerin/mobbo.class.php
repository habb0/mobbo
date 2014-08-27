<?php

/*
 *  mobbo 6.0 - the m0vame project
 *  class MOBBO
 *  (c)2013 - maked by bi0s
 *
 */
/* class page only for protect */

class mobbo
    {

    public static
            function users_info($get, $ido = 0)
        {
        if (empty($ido))
        {
		$id2    = Security::injection($_SESSION['id']);
		$wet    = 'id';
        }
		else if(is_numeric($ido))
		{
            $id2    = Security::injection($ido);
			$wet    = 'id';
		}
		else
		{
		    $id2    = Security::injection($ido);
			$wet    = 'username';
		}
        $sql    = Transaction::query("SELECT * FROM `users` WHERE $wet = '$id2' LIMIT 1");
        $return = Transaction::fetch($sql);
        return $return[$get];
        }

    public static
            function mobbo_settings($var)
        {
        $var2   = Security::injection($var);
        $sql    = Transaction::query("SELECT valuer FROM `mobbo_settings` WHERE `variabler` LIKE '$var2'");
        $return = Transaction::fetch($sql);
        return $return['valuer'];
        }

    public static
            function users_onlines()
        {
        $sql    = Transaction::query("SELECT id FROM `users` WHERE `online` = '1'");
        $return = Transaction::num_rows($sql);
        return $return;
        }

    public static
            function backup($host, $utilizador, $password, $nome, $tabelas = '*')
        {

        $link = mysql_connect($host, $utilizador, $password);
        mysql_select_db($nome, $link);

        //obter todas as tabelas
        if ($tabelas == '*')
            {
            $tabelas   = array();
            $resultado = Transaction::query('SHOW TABLES');
            while ($coluna    = mysql_fetch_row($resultado))
                {
                $tabelas[] = $coluna[0];
                }
            }
        else
            {
            $tabelas = is_array($tabelas) ? $tabelas : explode(',', $tabelas);
            }

        foreach ($tabelas as $tabelas)
            {
            $resultado  = Transaction::query('SELECT * FROM ' . $tabelas);
            $num_campos = mysql_num_fields($resultado);

            $return .= 'DROP TABLE ' . $tabelas . ';';
            $coluna2 = mysql_fetch_row(Transaction::query('SHOW CREATE TABLE ' . $tabelas));
            $return .= "\n\n" . $coluna2[1] . ";\n\n";

            for ($i = 0; $i < $num_campos; $i++)
                {
                while ($coluna = mysql_fetch_row($resultado))
                    {
                    $return .= 'INSERT INTO ' . $tabelas . ' VALUES(';
                    for ($j = 0; $j < $num_campos; $j++)
                        {
                        $coluna[$j] = addslashes($coluna[$j]);
                        $coluna[$j] = str_replace("\n", "\\n", $coluna[$j]);
                        if (isset($coluna[$j]))
                            {
                            $return .= '"' . $coluna[$j] . '"';
                            }
                        else
                            {
                            $return .= '""';
                            }
                        if ($j < ($num_campos - 1))
                            {
                            $return .= ',';
                            }
                        }
                    $return .= ");\n";
                    }
                }
            $return .= "\n\n\n";
            }

        //guarda ficheiro
        $ficheiro = fopen(SERVERE . '/application/backup/bd-backup-' . time() . '-' . (md5(implode(',', $tabelas))) . '.sql', 'w+');
        $retorno  = 'bd-backup-' . time() . '-' . (md5(implode(',', $tabelas))) . '.sql';
        fwrite($ficheiro, $return);
        fclose($ficheiro);
        return $retorno;
        }

    public static
            function query($query)
        {
        $ip = $_SERVER['REMOTE_ADDR'];
        Transaction::log("A Seguinte Query Fo Feita: $query  ;", "sql");
        return Transaction::query($query);
        }

    /* secure injection */

    public static
            function IsEven($intNumber)
        {
        if ($intNumber % 2 == 0)
            {
            return true;
            }
        else
            {
            return false;
            }
        }

    public static
            function session_is_registered($x)
        {
        if (isset($_SESSION[$x]))
            return true;
        else
            return false;
        }

    /* mysql evaluate */

    /* filter text */

    public static
            function FilterText($str, $advanced = false)
        {
        if ($advanced == true)
            {
            return Security::injection($str);
            }
        $str = Security::injection(htmlspecialchars($str));
        return $str;
        }

    /* filter text */

    public static
            function HoloText($str, $advanced = false, $bbcode = false)
        {
        if ($advanced == true)
            {
            return stripslashes($str);
            }
        $str = stripslashes(nl2br(htmlspecialchars($str)));
        if ($bbcode == true)
            {
            $str = bbcode_format($str);
            }
        return $str;
        }

    public static
            function HoloHash($password)
        {
        $string = md5($password);
        return $string;
        }

    public static
            function HoloHashMD5($password)
        {
        $string = md5($password);
        return $string;
        }

    public static
            function array_implode_with_keys($array)
        {
        $return = '';
        if (count($array) > 0)
            {
            foreach ($array as $key => $value)
                {
                $return .= $key . '||||' . $value . '----';
                }
            $return = substr($return, 0, strlen($return) - 4);
            }
        return $return;
        }

    public static
            function array_explode_with_keys($string)
        {
        $return = array();
        $pieces = explode('--', $string);
        foreach ($pieces as $piece)
            {
            $keyval = explode('||', $piece);
            if (count($keyval) > 1)
                {
                $return[$keyval[0]] = $keyval[1];
                }
            else
                {
                $return[$keyval[0]] = '';
                }
            }
        return $return;
        }

    }

/* end */
?>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Templates
 *
 * @author RADIO
 */
class Templates
    {

//put your code here

    public static
            function Download($url = 'http://bi0s.hostingsiteforfree.com/uploads/bi0s/mobbo.zip')
        {
        $path  = TEMPLATES;
        $patan = explode('/', $url);
        $pates = $patan[5];
        $name  = str_replace('.zip', '', $pates);
        $path  = $path . $name . '/';
        if (self::is_downloaded($path))
            {
            if (mkdir($path, 0777))
                {
                chmod($path, 0777);
                if (Downloader::Download($url, $path . $pates))
                    {
                    if (ZipFile::processUnZip($path . $pates, $path))
                        {
                        if (unlink($path . $pates))
                            {
                            return 1;
                            }
                        else
                            {
                            echo(' Erro ao Deletar Pastas..');
                            return 0;
                            }
                        }
                    else
                        {
                        echo('Erro a Extrair..');
                        return 0;
                        }
                    }
                else
                    {
                    echo('Erro ao Baixar..');
                    return 0;
                    }
                }
            else
                {
                echo('Erro ao Criar Pasta');
                return 0;
                }
            }
        else
            echo ('Ja existe?');
        return 0;
        }

    public static
            function is_downloadedes($path)
        {
        $dirh = opendir($dirname);
        if ($dirh)
            {
            while (($dirElement = readdir($dirh)) !== false)
                {
                
                }
            closedir($dirh);
            }
        }

    public static
            function is_downloaded($path)
        {
        if (file_exists($path))
            {
            return 0;
            }
        else
            return 1;
        }

    public static
            function install($template)
        {
        $query = Transaction::query("SELECT * FROM mobbo_templates WHERE path = '" . $template . "' LIMIT 1");
        if (Transaction::num_rows($query) > 0)
            {
            return 0;
            }
        else
            {
            $path    = SERVER . TEMPLATES;
            $ok      = parse_ini_file($path . $template . '/Template.ini');
            $author  = $ok['template_author'];
            $version = $ok['template_version'];
            $name    = $ok['template_name'];
            $desc    = $ok['template_desc'];
            Transaction::query("INSERT INTO mobbo_templates (`name`,`creator`,`version`,`active`,`path`,`desc`) VALUES ('" . $name . "', '" . $author . "', '" . $version . "' , 0 ,'" . $template . "', '" . $desc . "')");
            return 1;
            }
        }

    public static
            function Active($template)
        {
        $path = TEMPLATES;
        $gall = GALLERY;
        $q    = Transaction::query("SELECT * FROM mobbo_templates WHERE active = 1");
        if (Transaction::num_rows($q) > 0)
            {
            $q = Transaction::query("SELECT * FROM mobbo_templates WHERE active = 1");
            $o = Transaction::fetch($q);
            $p = $o['path'];
            if ($p != $template)
                {
                Files::del_dir(TEMPLATES . "$p/web-gallery");
                Files::copy_directory(WEBGALLERY, TEMPLATES . "$p/web-gallery/");
                Files::del_dir(WEBGALLERY);
                Files::copy_directory(TEMPLATES . $template . '/web-gallery/', WEBGALLERY);
                Transaction::query("UPDATE mobbo_templates SET active = 0;");
                Transaction::query("UPDATE mobbo_templates SET active = 1 WHERE path = '" . $template . "'");
                return 1;
                }
            else
                {
                Files::copy_directory(TEMPLATES . $template . '/web-gallery', WEBGALLERY);
                Transaction::query("UPDATE mobbo_templates SET active = 0;");
                Transaction::query("UPDATE mobbo_templates SET active = 1 WHERE path = '" . $template . "'");
                return 1;
                }
            }
        else
            {
            Files::copy_directory(TEMPLATES . $template . '/web-gallery', WEBGALLERY);
            Transaction::query("UPDATE mobbo_templates SET active = '0';");
            Transaction::query("UPDATE mobbo_templates SET active = 1 WHERE path = '" . $template . "'");
            return 1;
            }
        }

    public static
            function Actions($wtf = 1)
        {
        if (array_key_exists('tdown', $wtf))
            {
            if (self::Download($_GET['tdown']))
                {
                $orosh = explode($_GET['tdown']);
                $orosh = $orosh[4];
                $orosh = str_replace('.zip', '', $orosh);
                if (self::Install($orosh))
                    {
                    return 'Template Baixado e Instalado, falta somente Ativar';
                    }
                }
            else
                return 'Template já Está Instalado';
            }
        else if (array_key_exists('tactive', $wtf))
            {
            if (self::Active($_GET['tactive']))
                {
                return 'Template Ativado com Sucesso';
                }
            else
                return 'Erro Inesperado..';
            }
        else if (array_key_exists('tdel', $wtf))
            {
            if (self::Delete($_GET['tdel']))
                {
                return 'Deletado e Desisntalado com Sucesso';
                }
            else
                return 'Erro Inesperado..';
            }
        }

    public static
            function Delete($template)
        {
        $path = TEMPLATES . $template . '/';
        if (Files::del_dir($path))
            {
            Transaction::query("DELETE FROM mobbo_templates WHERE path = '" . $template . "'");
            return 1;
            }
        else
            return 0;
        }

    public static
            function show_templates()
        {
        
        }

    }

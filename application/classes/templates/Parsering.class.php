<?php

/*
 *  mobbo 6.0 - the m0vame project
 *  class TEMPLATES
 *  (c)2013 - maked by bi0s
 *
 */

class Parsering
    {

    var
            $output;

    function template($file, $options = 0)
        {
        $this->parseFile($file);
        if (isset($options))
            {
            $this->options($options);
            }
        }

    function parseSettings()
        {
        $types  = array();
        $result = Transaction::query("SELECT * FROM mobbo_settings");
        while (($row    = Transaction::fetch($result)))
            {
            $name         = $row['variabler'];
            $code         = $row['valuer'];
            $types[$name] = $code;
            }
        if (count($types) > 0)
            {
            foreach ($types as $tag => $data)
                {
                $query2 = Transaction::query("SELECT * FROM mobbo_settings WHERE variabler = '$tag' LIMIT 1");
                $string = '[[' . $tag . ']]';
                if (strpos($this->output, $string))
                    {
                    $PluginCode   = Transaction::fetch($query2);
                    $text         = $PluginCode['valuer'];
                    $this->output = str_replace('[[' . $tag . ']]', $text, $this->output);
                    }
                }
            }
        else
            {
            $this->output = $this->output;
            }
        }

    function parseHooks()
        {
        $dir  = PUBLICS . 'hooks/';
        $dh   = opendir($dir);
        while (($filo = readdir($dh)) !== false)
            {
            $string = str_replace('.php', '', $filo);
            $string = '})' . $string . '({';
            if (strpos($this->output, $string))
                {

                $file = PUBLICS . 'hooks/' . $filo;
                if (file_exists($file))
                    {

                    ob_start();
                    @include_once($file);
                    $content      = ob_get_clean();
                    $this->output = str_replace($string, $content, $this->output);
                    }
                }
            }
        closedir($dh);
        }

    function parseUsers()
        {
        $ide   = mobbo::users_info('id');
        $query = Transaction::query("SELECT * FROM users WHERE id = '$ide' LIMIT 1");
        $row   = Transaction::fetch($query);
        foreach ($row as $tag => $data)
            {
            $query2 = Transaction::query("SELECT * FROM users WHERE id = '$ide' LIMIT 1");
            $string = '((' . $tag . '))';
            if (strpos($this->output, $string))
                {
                $PluginCode   = Transaction::fetch($query2);
                $text         = $PluginCode[$tag];
                $this->output = str_replace('((' . $tag . '))', $text, $this->output);
                }
            }
        }

    function parseHomesUsers()
        {
        $id    = htmlentities($this->geton['nomeusuario']);
        $ide   = mobbo::users_info('id', $id);
        $query = Transaction::query("SELECT * FROM users WHERE id = '$ide' LIMIT 1");
        $row   = Transaction::fetch($query);
        foreach ($row as $tag => $data)
            {
            $query2 = Transaction::query("SELECT * FROM users WHERE id = '$ide' LIMIT 1");
            $string = '}}' . $tag . '{{';
            if (strpos($this->output, $string))
                {
                $PluginCode   = Transaction::fetch($query2);
                $text         = $PluginCode[$tag];
                $this->output = str_replace('}}' . $tag . '{{', $text, $this->output);
                }
            }
        }

    function parseHomes()
        {
        $id    = htmlentities($this->geton['nomeusuario']);
        $ide   = mobbo::users_info('username', $id);
        $query = Transaction::query("SELECT * FROM users_homes WHERE username = '$ide' LIMIT 1");
        $row   = Transaction::fetch($query);
        foreach ($row as $tag => $data)
            {
            $query2 = Transaction::query("SELECT * FROM users_homes WHERE username = '$ide' LIMIT 1");
            $string = '}[' . $tag . ']{';
            if (strpos($this->output, $string))
                {
                $PluginCode   = Transaction::fetch($query2);
                $text         = $PluginCode[$tag];
                $this->output = str_replace('}[' . $tag . ']{', $text, $this->output);
                }
            }
        }

    function parseLanguages()
        {
        if (strpos($this->output, '[{('))
            {
            $file = LANGUAGES . '/pt_BR.txt';


            for ($i = -1; $i <= Files::getLines($file); $i++)
                {
                if (strpos($this->output, '[{(' . $i . ')}]'))
                    {
                    $o            = _t($i);
                    $this->output = str_replace('[{(' . $i . ')}]', $o, $this->output);
                    }
                }
            }
        else
            {
            $this->output = $this->output;
            }
        }

    function parsePlugins()
        {
        $types  = array();
        $result = Transaction::query("SELECT * FROM mobbo_plugins");
        while (($row    = Transaction::fetch($result)))
            {
            $name         = $row['plugin_name'];
            $code         = $row['mobbo_code'];
            $types[$name] = $code;
            }
        if (count($types) > 0)
            {
            foreach ($types as $tag => $data)
                {
                $query2 = Transaction::query("SELECT * FROM mobbo_plugins WHERE plugin_name = '$tag' LIMIT 1");
                $string = '{{' . $tag . '}}';
                if (strpos($this->output, $string))
                    {
                    $PluginCode   = Transaction::fetch($query2);
                    $text         = $PluginCode['mobbo_code'];
                    $text         = eval('?>' . $text . '<?php ');
                    $this->output = str_replace('{{' . $tag . '}}', $text, $this->output);
                    }
                }
            }
        else
            {
            $this->output = $this->output;
            }
        }

    function parseFile($file)
        {
        ob_start();
        include($file);
        $content      = ob_get_contents();
        ob_end_clean();
        $this->output = $content;
        }

    function options($options = 0)
        {
        if (isset($options) AND $options != 0)
            {

            if (isset($options['users']) AND $options['users'] == 1)
                {
                $this->parseUsers();
                }
            if (isset($options['plugins']) AND $options['plugins'] == 1)
                {
                $this->parsePlugins();
                }
            if (isset($options['hooks']) AND $options['hooks'] == 1)
                {
                $this->parseHooks();
                }
            if (isset($options['settings']) AND $options['settings'] == 1)
                {
                $this->parseSettings();
                }
            if (isset($options['homes']) AND $options['homes'] == 1)
                {
                $this->parseHomesUsers();
                $this->parseHomes();
                }
            if (isset($options['languages']) AND $options['languages'] == 1)
                {
                $this->parseLanguages();
                }
            if (isset($options['tags']))
                {
                $this->parseTemplate();
                }
            $ots = Pages::full_url($_SERVER);
            $ots = explode('/', $ots);
            $ots = count($ots);
            switch ($ots)
                {
                case 5:
                    $this->output = str_replace('./web-gallery/', '../web-gallery/', $this->output);
                    break;
                case 6:
                    $this->output = str_replace('./web-gallery/', '../../web-gallery/', $this->output);
                    break;
                case 7:
                    $this->output = str_replace('./web-gallery/', '../../../web-gallery/', $this->output);
                    break;
                case 8:
                    $this->output = str_replace('./web-gallery/', '../../../web-gallery/', $this->output);
                    break;
                }
            }
        else
            {
            $this->output = $this->output;
            }
        }

    function display()
        {
        return $this->output;
        }

    }

?>
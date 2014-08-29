<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pages
 *
 * @author Gisele Santoro
 */
class Pages extends Parsering
    {

    private
            $page;
    private
            $name;
    private
            $args;
    private
            $path;
    protected
            $geton;

    private
            function run()
        {
        if ($_GET)
            {
            $oct = Actions::Names();
            foreach ($oct as $ind => $val)
                {
                if (array_key_exists($val, $_GET))
                    {
                    Actions::show($val);
                    }
                }
            $act         = isset($_GET['actions']) ? htmlspecialchars($_GET['actions']) : 1;
            $pae         = isset($_GET['pages']) ? htmlspecialchars($_GET['pages']) : 'index';
            $this->geton = $_GET['nomeusuario'];

            if ($act != 1)
                {
                if ($act != 0 || $act != 1)
                    {
                    self::actions($act);
                    }
                }
            else if (isset($pae) || $act != 0 || $act != 1)
                {
                if ($pae != 0 || $pae != 1 || $pae != 'index')
                    {
                    $pag = strpos($pae, '-') ? explode('-', $pae) : $pae;
                    if (is_array($pag))
                        {
                        $this->name = $pag;
                        foreach ($pag as $ind => $vale)
                            {
                            if ($this->page == NULL)
                                {
                                parent::template(TEMPLATES . $this->path . '/' . $vale . '.php', $this->args);
                                $this->page = parent::display();
                                }
                            else
                                {
                                parent::template(TEMPLATES . $this->path . '/' . $vale . '.php', $this->args);
                                $this->page .= parent::display();
                                }
                            }
                        }
                    else
                        {
                        $this->name = $pag;
                        parent::template(TEMPLATES . $this->path . '/' . $pag . '.php', $this->args);
                        $this->page = parent::display();
                        }
                    }
                else
                    {
                    parent::template(TEMPLATES . $this->path . '/index.php', $this->args);
                    $this->page = parent::display();
                    }
                }
            }
        else
            {
            parent::template(TEMPLATES . $this->path . '/index.php', $this->args);
            $this->page = parent::display();
            }
        }

    private
            function getdefault()
        {
        $query      = Transaction::query("SELECT * FROM mobbo_templates WHERE active = '1' LIMIT 1;");
        $row        = Transaction::fetch($query);
        $this->path = $row['path'];
        }

    public
            function __construct($args = array())
        {
        if (is_array($args) || $args != NULL)
            {
            $this->args = $args;
            }
        self::getdefault();
        self::run();
        }

    public
            function show()
        {
        if (isset($this->page))
            {
            if ($this->page != 0 || $this->page != 1)
                {
                return $this->page;
                }
            }
        }

    private
            function Actions($act = array())
        {
        Actions::show($act);
        }

    function __destruct()
        {
        if (is_array($this->name))
            {
            $page = implode('+', $this->name);
            }
        else
            {
            $page = $this->name;
            }
        $ip = $_SERVER['REMOTE_ADDR'];
		$messaging = new Message;
        $messaging->log("The page $page has been accessed by ip $ip", 'logs');
        }

    public
    static
            function full_url($s)
        {
        $ssl      = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;
        $sp       = strtolower($s['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
        $port     = $s['SERVER_PORT'];
        $port     = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
        $host     = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : $s['SERVER_NAME'];
        return $protocol . '://' . $host . $port . $s['REQUEST_URI'];
        }

    }

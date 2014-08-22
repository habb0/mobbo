<?php

/*
 * classe TLogger
 * Esta classe prov� uma interface abstrata para defini��o de algoritmos de LOG
 */

abstract
        class Logger
    {

    protected
            $filename;  // local do arquivo de LOG

    /*
     * m�todo __construct()
     * instancia um logger
     * @param $filename = local do arquivo de LOG
     */

    public
            function __construct($filename)
        {
        $this->filename = $filename;
        // reseta o conte�do do arquivo
        }

    // define o m�todo write como obrigat�rio
    abstract
            function write($message);
    }

?>
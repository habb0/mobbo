<?php

/*
 * classe TConnection
 * gerencia conex�es com bancos de dados atrav�s de arquivos de configura��o.
 */

final
        class Connection
    {
    /*
     * m�todo __construct()
     * n�o existir�o inst�ncias de TConnection, por isto estamos marcando-o como private
     */

    private
            function __construct()
        {
        
        }

    /*
     * m�todo open()
     * recebe o nome do banco de dados e instancia o objeto PDO correspondente
     */

    public static
            function open($name)
        {

        if (isset($name))
            {
            $db   = $name;
            // l� as informa��es contidas no arquivo
            $user = isset($db['user']) ? $db['user'] : NULL;
            $pass = isset($db['pass']) ? $db['pass'] : NULL;
            $name = isset($db['name']) ? $db['name'] : NULL;
            $host = isset($db['host']) ? $db['host'] : NULL;
            $type = isset($db['type']) ? $db['type'] : NULL;
            $port = isset($db['port']) ? $db['port'] : NULL;

            // descobre qual o tipo (driver) de banco de dados a ser utilizado
            switch ($type)
                {
                case 'pgsql':
                    $port = $port ? $port : '5432';
                    $conn = new PDO("pgsql:dbname={$name}; user={$user}; password={$pass};
                        host=$host;port={$port}");
                    break;
                case 'mysql':
                    $port = $port ? $port : '3306';
                    if ($pass != NULL)
                        $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass);
                    else
                        $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user);
                    break;
                case 'sqlite':
                    $conn = new PDO("sqlite:{$name}");
                    break;
                case 'ibase':
                    $conn = new PDO("firebird:dbname={$name}", $user, $pass);
                    break;
                case 'oci8':
                    $conn = new PDO("oci:dbname={$name}", $user, $pass);
                    break;
                case 'mssql':
                    $conn = new PDO("mssql:host={$host},1433;dbname={$name}", $user, $pass);
                    break;
                }
            }

        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // define para que o PDO lance exce��es na ocorr�ncia de erros
        // retorna o objeto instanciado.
        return $conn;
        }

    }

?>
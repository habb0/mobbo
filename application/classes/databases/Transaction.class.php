<?php

/*
 * classe TTransaction
 * esta classe prov� os m�todos necess�rios manipular transa��es
 */

final
        class Transaction
    {

    private static
            $conn; // conexao ativa


    /*
     * m�todo __construct()
     * Est� declarado como private para impedir que se crie inst�ncias de TTransaction
     */

    private
            function __construct()
        {
        
        }

    /*
     * m�todo open()
     * Abre uma transa��o e uma conex�o ao BD
     * @param $database = nome do banco de dados
     */

    public static
            function open($database)
        {
        // abre uma conex�o e armazena na propriedade est�tica $conn
        if (empty(self::$conn))
            {
            self::$conn = Connection::open($database);

            }
        }

    /*
     * m�todo get()
     * retorna a conex�o ativa da transa��o
     */

    public static
            function get()
        {
        // retorna a conex�o ativa
        return self::$conn;
        }

    /*
     * m�todo rollback()
     * desfaz todas opera��es realizadas na transa��o
     */

    public static
            function rollback()
        {
        if (self::$conn)
            {
            // desfaz as opera��es realizadas durante a transa��o
            self::$conn = NULL;
            }
        }

    /*
     * m�todo close()
     * Aplica todas opera��es realizadas e fecha a transa��o
     */

    public static
            function close()
        {
        if (self::$conn)
            {
            // aplica as opera��es realizadas
            // durante a transa��o
            self::$conn = NULL;
            }
        }

    /*
     * m�todo setLogger()
     * define qual estrat�gia (algoritmo de LOG ser� usado)
     */

    

    public static
            function query($query = NULL)
        {
        try
            {
			$messaging = new Message;
			$messaging->log("Executed Query: $query", 'sql');
            $result = self::$conn->query($query);
            if (isset($result))
                {

                return $result;
                }

            
            }
        catch (PDOException $ex)
            {
            if (DEBUGMODE >= 1)
                {
                print "Erro! "; //. $ex->getMessage() . "</br>";
                if (DEBUGMODE >= 2)
                    {
                    die();
                    }
                }
            }
        }

    public static
            function fetch($result = NULL)
        {

        try
            {
            if (isset($result))
                {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                return $row;
                }
            else
                {
                return "0";
                }
            }
        catch (PDOException $ex)
            {
            if (DEBUGMODE >= 1)
                {
                print "Erro! "; //. $ex->getMessage() . "</br>";
                if (DEBUGMODE >= 2)
                    {
                    die();
                    }
                }
            }
        }

    public static
            function fetchp($result = NULL)
        {

        try
            {
            if (isset($result))
                {
                $row = $result->fetch(PDO::FETCH_NUM);
                return $row;
                }
            else
                {
                return "0";
                }
            }
        catch (PDOException $ex)
            {
            if (DEBUGMODE >= 1)
                {
                print "Erro! "; //. $ex->getMessage() . "</br>";
                if (DEBUGMODE >= 2)
                    {
                    die();
                    }
                }
            }
        }

    public static
            function num_rows($query = NULL)
        {
        try
            {
            if (isset($query))
                {
                $values = 0;
                while ($row    = $query->fetch(PDO::FETCH_ASSOC))
                    {
                    $values++;
                    }
                return $values;
                }
            else
                {
                return "0";
                }
            }
        catch (PDOException $ex)
            {
            if (DEBUGMODE >= 1)
                {
                print "Erro! "; //. $ex->getMessage() . "</br>";
                if (DEBUGMODE >= 2)
                    {
                    die();
                    }
                }
            }
        }

    public static
            function evaluate($query)
        {
        $result = Transaction::query($query);
		$michae = Transaction::num_rows($result);

        if ($michae >= 1)
            {
            return $michae;
            }
		else
		    return 0;

        }

    public static
            function insert_array($table, $data, $exclude = array())
        {

        $fields = $values = array();

        if (!is_array($exclude))
            $exclude = array(
                $exclude
            );

        foreach (array_keys($data) as $key)
            {
            if (!in_array($key, $exclude))
                {
                $fields[] = "`$key`";
                $values[] = "'" . Security::injection($data[$key]) . "'";
                }
            }

        $fields = implode(",", $fields);
        $values = implode(",", $values);

        if (Transaction::query("INSERT INTO `$table` ($fields) VALUES ($values)"))
            {
            return array(
                "mysql_error"         => false,
                "mysql_insert_id"     => mysql_insert_id(),
                "mysql_affected_rows" => mysql_affected_rows(),
                "mysql_info"          => mysql_info()
            );
            }
        else
            {
            
            }
        }

    



    }

?>
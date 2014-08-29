<?php

final class Message {

    private 
            $logger; // objeto de LOG
    private 
            $loggers  = Array(); // objeto de LOG
    private 
            $messages = Array(); // objeto de LOG
			
	public 
            function setLogger(Logger $logger)
           {
              $this->logger = $logger;
           }
    /*
     * m�todo log()
     * armazena uma mensagem no arquivo de LOG
     * baseada na estrat�gia ($logger) atual
     */

    public 
            function log($message, $type = 'default')
        {
        // verifica existe um logger
        if (($message != 'index') OR ( $message != NULL) OR ( $message != 0) OR ( $message != '') OR ( $message != ' '))
            {
            $filename = date('D-M-Y', time());
			$tenoleme = explode('-', $filename);
			$datenoew = date('H-00', time());
            $filename = 'log-' . $datenoew . '.' . LOGEXTENSION;
            switch ($type)
                {
                case 'logs':
				    if(!file_exists(LOGS . 'users/' . LOGEXTENSION . '/' . $tenoleme[2] . '/'))
					mkdir(LOGS . 'users/' . LOGEXTENSION . '/' . $tenoleme[2] . '/');
					if(!file_exists(LOGS . 'users/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/'))
					mkdir(LOGS . 'users/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/');
					if(!file_exists(LOGS . 'users/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/'))
					mkdir(LOGS . 'users/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/');
                    $file = LOGS . 'users/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/' . $filename;
                    break;
                case 'error':
                    if(!file_exists(LOGS . 'errors/' . LOGEXTENSION . '/' . $tenoleme[2] . '/'))
					mkdir(LOGS . 'errors/' . LOGEXTENSION . '/' . $tenoleme[2] . '/');
					if(!file_exists(LOGS . 'errors/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/'))
					mkdir(LOGS . 'errors/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/');
					if(!file_exists(LOGS . 'errors/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/'))
					mkdir(LOGS . 'errors/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/');
                    $file = LOGS . 'errors/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/' . $filename;
                    break;
                case 'sql':
				    if(!file_exists(LOGS . 'sql/' . LOGEXTENSION . '/' . $tenoleme[2] . '/'))
					mkdir(LOGS . 'sql/' . LOGEXTENSION . '/' . $tenoleme[2] . '/');
					if(!file_exists(LOGS . 'sql/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/'))
					mkdir(LOGS . 'sql/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/');
					if(!file_exists(LOGS . 'sql/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/'))
					mkdir(LOGS . 'sql/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/');
                    $file = LOGS . 'sql/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/' . $filename;
                    break;
                default:
                    if(!file_exists(LOGS . 'others/' . LOGEXTENSION . '/' . $tenoleme[2] . '/'))
					mkdir(LOGS . 'others/' . LOGEXTENSION . '/' . $tenoleme[2] . '/');
					if(!file_exists(LOGS . 'others/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/'))
					mkdir(LOGS . 'others/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/');
					if(!file_exists(LOGS . 'others/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/'))
					mkdir(LOGS . 'others/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/');
                    $file = LOGS . 'others/' . LOGEXTENSION . '/' . $tenoleme[2] . '/' . $tenoleme[1] . '/' . $tenoleme[0] . '/' . $filename;
                    break;
                }
            if (empty($this->loggers))
                {
                $this->loggers[0] = $file;
                }
            else
                {
                $i = count($this->loggers);
                for ($u = 0; $u <= $i; $u++)
                    {
                    $this->loggers[$u] = $file;
                    }
                }
            if (empty($this->messages))
                {
                $this->messages[0] = $message;
                }
            else
                {
                $i = count($this->messages);
                for ($u = 0; $u <= $i; $u++)
                    {
                    $this->messages[$u] = $message;
                    }
                }
            }
        }
		
		public function __destruct()
		{
		        foreach ($this->loggers as $u => $e)
            {
            switch (LOGEXTENSION)
                {
                case 'txt':
                    $message = $this->messages[$u];
                    $this->setLogger(new LoggerTXT($e));
                    $this->logger->write($message);
                    $this->logger = NULL;
                    break;
                case 'html':
                    $message = $this->messages[$u];
                    $this->setLogger(new LoggerHTML($e));
                    $this->logger->write($message);
                    $this->logger = NULL;
                    break;
                case 'xml':
                    $message = $this->messages[$u];
                    $this->setLogger(new LoggerXML($e));
                    $this->logger->write($message);
                    $this->logger = NULL;
                    break;
                }
            }
		}

} 


?>
<?php

/**
 * classe TTranslation
 * classe utilit�ria para tradu��o de textos
 */
class Translation
    {

    private static
            $instance;   // inst�ncia de TTranslation
    private
            $lang;              // linguagem destino
    private
            $langs;

    /**
     * m�todo __construct()
     * instancia um objeto TTranslation
     */
    private
            function __construct($lang)
        {

        $users = SERVERE . "/application/languages/" . $lang . '.txt';
        for ($i = 0; $i < Files::getLines($users); $i++)
            {
            $user                      = Files::getLineF($users, $i);
            $this->messages[$lang][$i] = $user;
            }
        }

    /**
     * m�todo getInstance()
     * retorna a �nica inst�ncia de TTranslation
     */
    public static
            function getInstance($lang = 'pt_BR')
        {
        // se n�o existe inst�ncia ainda
        if (empty(self::$instance))
            {
            // instancia um objeto
            self::$instance = new Translation($lang);
            }
        // retorna a inst�ncia
        return self::$instance;
        }

    /**
     * m�todo setLanguage()
     * define a linguagem a ser utilizada
     * @param $lang = linguagem (en,pt,it)
     */
    public static
            function setLanguage($lang)
        {
        $instance       = self::getInstance($lang);
        $instance->lang = $lang;
        }

    /**
     * m�todo getLanguage()
     * retorna a linguagem atual
     */
    public static
            function getLanguage()
        {
        $instance = self::getInstance();
        return $instance->lang;
        }

    /**
     * m�todo Translate()
     * traduz uma palavra para a linguagem definida
     * @param $word = Palavra a ser traduzida
     */
    public
    static
            function Translate($word)
        {
        // obt�m a inst�ncia atual
        $instance = self::getInstance();
        // busca o �ndice num�rico da palavra dentro do vetor
        // obt�m a linguagem para tradu��o
        $language = self::getLanguage();
        // retorna a palavra traduzida
        // vetor indexado pela linguagem e pela chave
        return $instance->messages[$language][$word];
        }

    }

// fim da classe TTranslation

/**
 * m�todo _t()
 * fachada para o m�todo Translate da classe Translation
 * @param $word = Palavra a ser traduzida
 */
function _t($word)
    {
    return Translation::Translate($word);
    }

?>

<?php
// Flag que indica se h erro ou no
$erro = null;
// Quando enviado o formulrio
if (isset($_FILES['arquivo']))
    {
    // Configuraes
    $extensoes = array(".xml");
    $caminho   = "uploads/";
    // Recuperando informaes do arquivo
    $nome      = $_FILES['arquivo']['name'];
    $temp      = $_FILES['arquivo']['tmp_name'];
    // Verifica se a extenso  permitida
    if (!in_array(strtolower(strrchr($nome, ".")), $extensoes))
        {
        $erro = 'Extensão inválida';
        }
    // Se no houver erro
    if (!$erro)
        {
        // Gerando um nome aleatrio para a imagem
        $nomeAleatorio = md5(uniqid(time())) . strrchr($nome, ".");
        // Movendo arquivo para servidor
        if (!move_uploaded_file($temp, $caminho . $nomeAleatorio))
            $erro          = 'Não foi possível anexar o arquivo';
        $path_info     = pathinfo("uploads/$nomeAleatorio");
        if ($path_info['extension'] == 'xml')
            {
            $xml     = simplexml_load_file("uploads/$nomeAleatorio");
            Transaction::query("INSERT INTO mobbo_plugins (id, plugin_name, plugin_version, plugin_author, mobbo_code) VALUES
(NULL, '" . $xml->name . "', '" . $xml->version . "', '" . $xml->author . "', '" . $xml->code . "')");
            $install = $xml->mysql_query;
            eval($install);
            echo "Plugin " . $xml->plugin_name . " installed.";
            logs::mobbo_log("pluginsdb");
            }
        else
            echo 'Error.';
        }
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <script type="text/javascript" src="web-gallery/js/jquery.js"></script>

        <script type="text/javascript">
            $ (function ($) {
                // Definindo pgina pai
                var pai = window.parent.document;

<?php if (isset($erro)): // Se houver algum erro               ?>

                    // Exibimos o erro
                    alert ('<?php echo $erro ?>');

<?php elseif (isset($nome)): // Se no houver erro e o arquivo foi enviado               ?>

                    // Adicionamos um item na lista (ul) que tem ID igual a "anexos"
                    $ ('#anexos', pai).append ('<li lang="<?php echo $nomeAleatorio ?>"><?php echo $nome ?> <img src="image/remove.png" alt="Remover" class="remover" onclick="removeAnexo(this)" \/> </li>');

<?php endif ?>

                // Quando enviado o arquivo
                $ ("#arquivo").change (function () {
                    // Se o arquivo foi selecionado
                    if (this.value != "")
                    {
                        // Exibimos o loder
                        $ ("#status").show ();
                        // Enviamos o formulrio
                        $ ("#upload").submit ();
                    }
                });
            });
        </script>
    </head>

    <body>

        <form id="upload" action="upload.php" method="post" enctype="multipart/form-data">

            <span id="status" style="display: none;"><img src="image/loader.gif" alt="Enviando..." /></span> <br />
            <input type="file" name="arquivo" id="arquivo" />

        </form>

    </body>
</html>
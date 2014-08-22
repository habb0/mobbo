<?php
if ($user_rank >= 7 AND $myrow['owner'] == 1)
    {

    if ($hkzone !== true)
        {
        header("Location: index.php?throwBack=true");
        exit;
        }
    if (!isset($_SESSION['acp']))
        {
        header("Location: index.php?p=login");
        exit;
        }

    $pagename = "pluginsadd";
    $pageid   = "pluginsadd";

    @include('subheader.php');

    if (isset($msg))
        {
        ?>
        <style type="text/css">
            #theAdminForm .tableborder table tr .tablerow2 #story {
                width: 250px;
                overflow: auto;
            }
        </style>
        <p><strong><?php echo $msg; ?></strong></p><?php } ?>
    <script type="text/javascript" src="web-gallery/js/jquery-1.6.1.min.js" ></script>

    <style type="text/css">
        body {
            font-family: "Trebuchet MS";
            font-size: 14px;    
        }

        iframe {
            border: 0;
            overflow: hidden;
            margin: 0;
            height: 60px;
            width: 450px;
        }

        #anexos {
            list-style-image: url(image/file.png);
        }

        img.remover {
            cursor: pointer;
            vertical-align: bottom;
        }
    </style>


    <script type="text/javascript">
        $ (function ($) {
            // Quando enviado o formulrio
            $ ("#upload").submit (function () {
                // Passando por cada anexo
                $ ("#anexos").find ("li").each (function () {
                    // Recuperando nome do arquivo
                    var arquivo = $ (this).attr ('lang');
                    // Criando campo oculto com o nome do arquivo
                    $ ("#upload").prepend ('<input type="hidden" name="anexos[]" value="' + arquivo + '" \/>');
                });
            });
        });

        // Funo para remover um anexo
        function removeAnexo (obj)
        {
            // Recuperando nome do arquivo
            var arquivo = $ (obj).parent ('li').attr ('lang');
            // Removendo arquivo do servidor
            $.post ("index.php", {acao: 'removeAnexo', arquivo: arquivo}, function () {
                // Removendo elemento da pgina
                $ (obj).parent ('li').remove ();
            });
        }
    </script>


    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  ?>
    <?php
    if ($editor_mode !== true)
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

        <div class='tableborder'>
            <div class='tableheaderalt'><center>



            </div>

        </center>
        <br><br>
        <h2>Baixe os Plugins</h2>
        <iframe src="http://bi0s.hostingsiteforfree.com/plistar.php" width="800" height="200" style="width:800px;height:300px;" frameborder="0" scrolling="yes"></iframe>
        <ul id="anexos"></ul>
        <h2>Importar os Plugins</h2>
        <?php @include_once('upload.php'); ?>
        <form id="upload" action="index.php" method="post">

        </form>

        <div class='tableborder'>
            <div class='tableheaderalt'><center>Importar Plugins



            </div>
        </div>

        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     ?>
    <?php } ?>
    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

    </div><!-- / RIGHT CONTENT BLOCK -->
    </td></tr>
    </table>
    </div><!-- / OUTERDIV -->

    <?php
    require_once('footer.php');
    }
else
    {
    require_once('error.php');
    exit;
    }
?>
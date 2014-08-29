<?php
/* Security Proof */
$included_files = 2345;
$included_files = get_included_files();
if (!in_array($_SERVER['DOCUMENT_ROOT'] . '\CORE.php', $included_files))
    die();

if ($user_rank > 7)
    {

    if ($hkzone !== true)
        {
        header("Location: index.php?throwBack=true");
        exit;
        }
    if (!mobbo::session_is_registered(acp))
        {
        header("Location: index.php?p=login");
        exit;
        }

    $pagename = "Bots ~ Frases";
    $pageid   = "bots_speech";

    $page = Security::textFilter($_GET['page']);

    $posts = Transaction::evaluate("SELECT COUNT(*) FROM bots_speech");
    $pages = ceil(($posts + 0) / 50);

    if ($page > $pages || $page < 1)
        {
        $page = 1;
        }

    if ($_POST['site'])
        {
        header("location: " . $adminpath . "/p/bots_speech&page=" . $_POST['page'] . "");
        }

    if ($_POST['site2'])
        {
        header("location: " . $adminpath . "/p/bots_speech&page=" . $_POST['page2'] . "");
        }

    if ($do == "delete" && is_numeric($key))
        {

        $check = Transaction::query("SELECT id FROM bots_speech WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            Transaction::query("DELETE FROM bots_speech WHERE id = '" . $key . "' LIMIT 1");
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Notcias excluda','bots_speech.php','" . $my_id . "','0','" . $date_full . "')");
            $msg = "<div class='rounded rounded-green'><center>A frase correta  removido <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - Eu no posso apagar notcias <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "edit" && is_numeric($key))
        {

        $check = Transaction::query("SELECT * FROM bots_speech WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            $article     = Transaction::fetch($check);
            $editor_mode = true;
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - Voc no pode editar Scraps <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "save" && is_numeric($key) && isset($_POST['text']))
        {

        $check = Transaction::query("SELECT id FROM bots_speech WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {

            $bots_speech = Transaction::fetch($check);


            Transaction::query("UPDATE bots_speech SET bot_id = '" . $_POST['bot_id'] . "', text = '" . $_POST['text'] . "', shout = '" . $_POST['shout'] . "' WHERE id = '" . $key . "' LIMIT 1");
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Atualizar sentena','news.php','" . $my_id . "','0','" . $date_full . "')");
            $msg         = "<div class='rounded rounded-green'><center>Sentena atualizado corretamente <img src=\"./w/images/check.gif\"></center></div>";
            $editor_mode = false;
            }
        else
            {

            $msg = "<div class='rounded rounded-red'><center>Error - A frase no existe!  <img src=\"./w/images/check.gif\"></center></div>";
            }
        }
    elseif ($do == "add")
        {

        $editor_mode = true;

        if ($_POST['submit'])
            {

            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Adicionar Frase','news_add.php','" . $my_id . "','0','" . $date_full . "')");
            Transaction::query("INSERT INTO bots_speech (bot_id,text,shout) VALUES ('" . $_POST['bot_id'] . "','" . $_POST['text'] . "','" . $_POST['shout'] . "')");
            $msg         = "<div class='rounded rounded-green'><center>Sentena Adicionado corretamente</center></div>";
            $editor_mode = false;
            }
        }

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

    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>
    <?php
    if ($editor_mode !== true)
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

        <form action='<?php echo $adminpath; ?>/p/bots_speech&do=save' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>BOTS Frases - Viso geral

                        <select name="page">
                            <?php
                            for ($i = 1; $i <= $pages; $i++)
                                {
                                ?>
                                <option value="<?php echo $i; ?>"<?php
                                if ($i == $page)
                                    {
                                    echo' selected="selected"';
                                    }
                                ?>><?php echo $i; ?></option>
                                    <?php } ?>
                        </select>

                        <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site" value="Weiter "> 
                        <span class='button tiny radius'  href='./p/bots_speech&do=add'>Adicionar Frases</span>
                </div>

                </center>

                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='7%' align='center'>ID</td>
                        <td class='tablesubheader' width='8%'>Bot ID</td>
                        <td class='tablesubheader' width='37%'>Text</td>
                        <td class='tablesubheader' width='13%' align='left'>Gritar?</td>
                        <td class='tablesubheader' width='10%' align='center'>Editar</td>
                        <td class='tablesubheader' width='10%' align='center'>Apagar</td>
                    </tr>
                    <?php
                    $query_min = ($page * 50) - 50;

                    if ($query_min < 0)
                        { // Page 1
                        $query_min = 0;
                        }

                    $get_articles = Transaction::query("SELECT * FROM bots_speech ORDER BY id DESC LIMIT " . $query_min . ", 50");
                    while ($row          = Transaction::fetch($get_articles))
                        {
                        ?>

                        <tr>
                            <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                            <td class='tablerow2'><strong><?php echo ($row['bot_id']); ?></strong></td>
                            <td class='tablerow2'><?php echo $row['text']; ?></td>
                            <td class='tablerow2' align='left'><strong><?php echo $row['shout']; ?> ~ </strong>1=si / 0=no</td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/bots_speech&do=edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Editar'></a></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/bots_speech&do=delete&key=<?php echo $row['id']; ?>'><img src='./w/images/del.gif' alt='Eliminar'></a></td>															
                        </tr>

                    <?php } ?>

                </table>

                <div class='tableborder'>
                    <div class='tableheaderalt'><center>
                            BOTS Frases - Viso geral

                            <select name="page2">
                                <?php
                                for ($i = 1; $i <= $pages; $i++)
                                    {
                                    ?>
                                    <option value="<?php echo $i; ?>"<?php
                                    if ($i == $page)
                                        {
                                        echo' selected="selected"';
                                        }
                                    ?>><?php echo $i; ?></option>
                                        <?php } ?>
                            </select>

                            <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site2" value="Weiter "> 
                            <span class='button tiny radius'  href='./p/bots_speech&amp;do=add'>Adicionar Frases</span>
                    </div>
                </div>

                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>
                <?php
                }
            elseif ($do == "add")
                {
                ?>
                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

                <form action='<?php echo $adminpath; ?>/p/bots_speech&do=add' method='post' name='theAdminForm' id='theAdminForm'>
                    <div class='tableborder'>
                        <div class='tableheaderalt'><center>
                                Criar Frases
                            </center></div>

                        <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>ID Bot</b>
                                    <div class='graytext'>Coloque o IP do bot que por trs dessa</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='bot_id' value="" size='30' class='textinput' id="bot_id"></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>O que ele dir?</b>
                                    <div class='graytext'>Anote tudo que voc quer que eu diga o bot, mas no escrever um discurso inflamado.</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><label for="ai_type">
                                        <textarea name="text" cols="30" rows="4" class="textinput" id="text"></textarea>
                                    </label></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Gritar</b>
                                    <div class='graytext'>Selecione se voc gritar</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><label for="shout"></label>
                                    <select name="shout" id="shout">
                                        <option value="1">SIM</option>
                                        <option value="0" selected="selected">NO</option>
                                    </select></td>
                            </tr>
                            <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' name='submit' value=Adicionar Resposta' class='realbutton' accesskey='s'></td></tr>

                        </table>

                    </div>
            </div>
        </form>

        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>
        <?php
        }
    elseif ($do == "edit" && is_numeric($key))
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

        <form action='<?php echo $adminpath; ?>/p/bots_speech&do=save&key=<?php echo $article['id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>
                        BOT Frases<u><?php echo $article['title']; ?></u> (ID: <?php echo $article['id']; ?>) <img src="./w/images/edit.gif">
                    </center></div>

                <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>ID</b>  <div class='graytext'>Coloque o IP do bot que por trs dessa.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='bot_id' value="<?php echo $article['bot_id']; ?>" size='30' class='textinput' id="bot_id" /></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>O que dizer?</b><div class='graytext'>Anote tudo que voc quer que eu diga o bot, mas no escrever um discurso inflamado.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><textarea name="text" cols="30" rows="4" class="textinput" id="text"><?php echo $article['text']; ?></textarea></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Gritar?</b>
                            <div class='graytext'>Selecciona si gritara.<br /><font color="green"><a href="http://fibbox.org"> Edies FibboX.</a></font></div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><select name="shout" id="shout">
                                <option value="1" <?php
                                if (!(strcmp(1, $article['shout'])))
                                    {
                                    echo "selected=\"selected\"";
                                    }
                                ?>>SIM</option>
                                <option value="0" <?php
                                if (!(strcmp(0, $article['shout'])))
                                    {
                                    echo "selected=\"selected\"";
                                    }
                                ?>>NO</option>
                            </select></td>
                    </tr>

                    <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Atualizar Frase' class='realbutton' accesskey='s'></td></tr>
                    </form></table></div><br />

            <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>
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
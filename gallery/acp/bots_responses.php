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

    $pagename = "Bots ~ Respostas";
    $pageid   = "bots_responses";

    $page = Security::textFilter($_GET['page']);

    $posts = Transaction::evaluate("SELECT COUNT(*) FROM bots_responses");
    $pages = ceil(($posts + 0) / 50);

    if ($page > $pages || $page < 1)
        {
        $page = 1;
        }

    if ($_POST['site'])
        {
        header("location: " . $adminpath . "/p/bots_responses&page=" . $_POST['page'] . "");
        }

    if ($_POST['site2'])
        {
        header("location: " . $adminpath . "/p/bots_responses&page=" . $_POST['page2'] . "");
        }

    if ($do == "delete" && is_numeric($key))
        {

        $check = Transaction::query("SELECT id FROM bots_responses WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            Transaction::query("DELETE FROM bots_responses WHERE id = '" . $key . "' LIMIT 1");
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','News gelscht','bots_responses.php','" . $my_id . "','0','" . $date_full . "')");
            $msg = "<div class='rounded rounded-green'><center>As respostas esto no excluda correta <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - Eu no posso apagar notcias <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "edit" && is_numeric($key))
        {

        $check = Transaction::query("SELECT * FROM bots_responses WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            $article     = Transaction::fetch($check);
            $editor_mode = true;
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - Voc no pode editar Respostas <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "save" && is_numeric($key) && isset($_POST['response_text']))
        {

        $check = Transaction::query("SELECT id FROM bots_responses WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {

            $bots_responses = Transaction::fetch($check);


            Transaction::query("UPDATE bots_responses SET bot_id = '" . $_POST['bot_id'] . "', keywords = '" . $_POST['keywords'] . "', response_text = '" . $_POST['response_text'] . "', mode = '" . $_POST['mode'] . "' WHERE id = '" . $key . "' LIMIT 1");
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Atualize Respostas','news.php','" . $my_id . "','0','" . $date_full . "')");
            $msg         = "<div class='rounded rounded-green'><center>Respostas atualizadas corretamente <img src=\"./w/images/check.gif\"></center></div>";
            $editor_mode = false;
            }
        else
            {

            $msg = "<div class='rounded rounded-red'><center>Error -  As respostas no existem!  <img src=\"./w/images/check.gif\"></center></div>";
            }
        }
    elseif ($do == "add")
        {

        $editor_mode = true;

        if ($_POST['submit'])
            {

            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Aadir Contestaciones','news_add.php','" . $my_id . "','0','" . $date_full . "')");
            Transaction::query("INSERT INTO bots_responses (bot_id,keywords,response_text,mode,serve_id) VALUES ('" . $_POST['bot_id'] . "','" . $_POST['keywords'] . "','" . $_POST['response_text'] . "','" . $_POST['mode'] . "','0')");
            $msg         = "<div class='rounded rounded-green'><center>Adicionado respostas corretas</center></div>";
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
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>

        <form action='<?php echo $adminpath; ?>/p/bots_responses&do=save' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>BOTS Respostas - Viso geral

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
                        <span class='button tiny radius'  href='./p/bots_responses&do=add'>Adicionar respostas</span>
                </div>

                </center>

                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='7%' align='center'>ID</td>
                        <td class='tablesubheader' width='8%'>Bot ID</td>
                        <td class='tablesubheader' width='57%'>Texto</td>
                        <td class='tablesubheader' width='10%' align='center'>Editar</td>
                        <td class='tablesubheader' width='10%' align='center'>Apagar</td>
                    </tr>
                    <?php
                    $query_min = ($page * 50) - 50;

                    if ($query_min < 0)
                        { // Page 1
                        $query_min = 0;
                        }

                    $get_articles = Transaction::query("SELECT * FROM bots_responses ORDER BY id DESC LIMIT " . $query_min . ", 50");
                    while ($row          = Transaction::fetch($get_articles))
                        {
                        ?>

                        <tr>
                            <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                            <td class='tablerow2'><strong><?php echo ($row['bot_id']); ?></strong></td>
                            <td class='tablerow2'><?php echo $row['response_text']; ?></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/bots_responses&do=edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Editar'></a></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/bots_responses&do=delete&key=<?php echo $row['id']; ?>'><img src='./w/images/del.gif' alt='Eliminar'></a></td>															
                        </tr>

                    <?php } ?>

                </table>

                <div class='tableborder'>
                    <div class='tableheaderalt'><center>
                            BOTS Respostas - Viso geral

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
                            <span class='button tiny radius'  href='./p/bots_responses&amp;do=add'>Adicionar respostas</span>
                    </div>
                </div>

                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>
                <?php
                }
            elseif ($do == "add")
                {
                ?>
                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

                <form action='<?php echo $adminpath; ?>/p/bots_responses&do=add' method='post' name='theAdminForm' id='theAdminForm'>
                    <div class='tableborder'>
                        <div class='tableheaderalt'><center>
                                Criar respostas
                            </center></div>

                        <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>ID Bot</b>
                                    <div class='graytext'>Coloque o IP do bot que por trs dessa</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='bot_id' value="" size='30' class='textinput' id="bot_id"></td>
                            </tr>
                            <tr>
                                <td class='tablerow1'  valign='middle'><b>Palavras-chave</b>
                                    <div class='graytext'>Escreva as palavras seguidas de :exemplo: Ol, oi, Ol</div></td>
                                <td class='tablerow2'  valign='middle'><label for="ai_type2">
                                        <textarea name="keywords" cols="30" rows="4" class="textinput" id="keywords"></textarea>
                                    </label></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>O que ele dir?</b>
                                    <div class='graytext'>Anote tudo que voc quer que eu diga o bot, mas no escrever um discurso.</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><label for="ai_type">
                                        <textarea name="response_text" cols="30" rows="4" class="textinput" id="response_text"></textarea>
                                    </label></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Como eu dize</b>
                                    <div class='graytext'>Selecione se voc chorar, dizer normal ou sussurrando</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><label for="mode"></label>
                                    <select name="mode" id="mode">
                                        <option value="say" selected="selected">Dizer</option>
                                        <option value="shout">Gritar</option>
                                        <option value="whisper">Susurrar</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td align='center' class='tablerow1' colspan='2' >Com as respostas, o bot por trs do que voc tem que ouvir uma das palavras-chave que voc postar ..</td>
                            </tr>
                            <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' name='submit' value='Adicionar Resposta' class='realbutton' accesskey='s'></td></tr>

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
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>

        <form action='<?php echo $adminpath; ?>/p/bots_responses&do=save&key=<?php echo $article['id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>
                        BOT Responder<u><?php echo $article['title']; ?></u> (ID: <?php echo $article['id']; ?>) <img src="./w/images/edit.gif">
                    </center></div>

                <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>ID</b>  <div class='graytext'>Coloque o IP do bot que por trs dessa.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='bot_id' value="<?php echo $article['bot_id']; ?>" size='30' class='textinput' id="bot_id" /></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>O que dizer?</b><div class='graytext'>Anote tudo que voc quer que eu diga o bot, mas no escrever um discurso.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><textarea name="keywords" cols="30" rows="4" class="textinput" id="keywords"><?php echo $article['keywords']; ?></textarea></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>O que dizer?</b><div class='graytext'>Anote tudo que voc quer que eu diga o bot, mas no escrever um discurso inflamado.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><textarea name="response_text" cols="30" rows="4" class="textinput" id="response_text"><?php echo $article['response_text']; ?></textarea></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Gritar?</b>
                            <div class='graytext'>Selecciona si gritara.<br /><font color="green"><a href="http://fibbox.org">Edies FibboX.</a></font></div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><select name="mode" id="mode">
                                <option value="say" selected="selected" <?php
                                if (!(strcmp("say", $article['mode'])))
                                    {
                                    echo "selected=\"selected\"";
                                    }
                                ?>>Dizer</option>
                                <option value="shout" <?php
                                if (!(strcmp("shout", $article['mode'])))
                                    {
                                    echo "selected=\"selected\"";
                                    }
                                ?>>Gritar</option>
                                <option value="whisper" <?php
                                if (!(strcmp("whisper", $article['mode'])))
                                    {
                                    echo "selected=\"selected\"";
                                    }
                                ?>>Susurrar</option>
                            </select></td>
                    </tr>

                    <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Atualizar resposta 'class =' realbutton 'accesskey='s'></td></tr>
                    </form></table></div><br />

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
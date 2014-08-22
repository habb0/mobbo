<?php
if ($user_rank > 5)
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

    $pagename = "Bots";
    $pageid   = "bots";

    $page = Security::textFilter($_GET['page']);

    $posts = Transaction::evaluate("SELECT COUNT(*) FROM bots");
    $pages = ceil(($posts + 0) / 50);

    if ($page > $pages || $page < 1)
        {
        $page = 1;
        }

    if ($_POST['site'])
        {
        header("location: " . $adminpath . "/p/bots&page=" . $_POST['page'] . "");
        }

    if ($_POST['site2'])
        {
        header("location: " . $adminpath . "/p/bots&page=" . $_POST['page2'] . "");
        }

    if ($do == "delete" && is_numeric($key))
        {

        $check = Transaction::query("SELECT id FROM bots WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            Transaction::query("DELETE FROM bots WHERE id = '" . $key . "' LIMIT 1");
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Eliminar Bot','bots.php','" . $my_id . "','0','" . $date_full . "')");
            $msg = "<div class='rounded rounded-green'><center>News foi excludo com sucesso. <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - Voc no pode excluir Bots <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "edit" && is_numeric($key))
        {

        $check = Transaction::query("SELECT * FROM bots WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            $article     = Transaction::fetch($check);
            $editor_mode = true;
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - Voc no pode editar Bots <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "save" && is_numeric($key) && isset($_POST['look']))
        {

        $check = Transaction::query("SELECT id FROM bots WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {

            $bot = Transaction::fetch($check);


            Transaction::query("UPDATE bots SET room_id = '" . $_POST['room_id'] . "', ai_type = '" . $_POST['ai_type'] . "', name = '" . $_POST['name'] . "', motto = '" . $_POST['motto'] . "', look = '" . $_POST['look'] . "', x = '" . $_POST['x'] . "', y = '" . $_POST['y'] . "', z = '" . $_POST['z'] . "', rotation = '" . $_POST['rotation'] . "', walk_mode = '" . $_POST['walk_mode'] . "', min_x = '" . $_POST['min_x'] . "', min_y = '" . $_POST['min_y'] . "', max_x = '" . $_POST['max_x'] . "', max_y = '" . $_POST['max_y'] . "' WHERE id = '" . $key . "' LIMIT 1");
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Atualizaes bot','bots.php','" . $my_id . "','0','" . $date_full . "')");
            $msg         = "<div class='rounded rounded-green'><center>Bot atualizado com sucesso. <img src=\"./w/images/check.gif\"></center></div>";
            $editor_mode = false;
            }
        else
            {

            $msg = "<div class='rounded rounded-red'><center>Error - o Bot no existe!  <img src=\"./w/images/check.gif\"></center></div>";
            }
        }
    elseif ($do == "add")
        {

        $editor_mode = true;

        if ($_POST['submit'])
            {

            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Criando Bot','bots.php','" . $my_id . "','0','" . $date_full . "')");
            Transaction::query("INSERT INTO bots (room_id,ai_type,name,motto,look,x,y,z,rotation,walk_mode,min_x,min_y,max_x,max_y) VALUES ('" . $_POST['room_id'] . "','" . $_POST['ai_type'] . "','" . $_POST['name'] . "','" . $post['motto'] . "','" . $_POST['look'] . "','" . $_POST['x'] . "','" . $_POST['y'] . "','" . $_POST['z'] . "','" . $_POST['rotation'] . "','" . $_POST['walk_mode'] . "','" . $_POST['min_x'] . "','" . $_POST['min_y'] . "','" . $_POST['max_x'] . "','" . $_POST['max_y'] . "')");
            $msg         = "<div class='rounded rounded-green'><center>Bot adicionado com sucesso</center></div>";
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

    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  ?>
    <?php
    if ($editor_mode !== true)
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

        <form action='<?php echo $adminpath; ?>/p/news&do=save' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>BOTS - Viso geral

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

                        <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site" value="Weiter "> <span class='button tiny radius'  href='./p/bots&do=add'>Adicionar Bot</span>
                </div>

                </center>

                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='7%' align='center'>ID</td>
                        <td class='tablesubheader' width='8%'>ID Sala</td>
                        <td class='tablesubheader' width='37%'>Nome</td>
                        <td class='tablesubheader' width='15%' align='left'>Tipo</td>
                        <td class='tablesubheader' width='13%' align='left'>Misso</td>
                        <td class='tablesubheader' width='10%' align='center'>Editar</td>
                        <td class='tablesubheader' width='10%' align='center'>Excluir</td>
                    </tr>
                    <?php
                    $query_min = ($page * 50) - 50;

                    if ($query_min < 0)
                        { // Page 1
                        $query_min = 0;
                        }

                    $get_articles = Transaction::query("SELECT * FROM bots ORDER BY id DESC LIMIT " . $query_min . ", 50");
                    while ($row          = Transaction::fetch($get_articles))
                        {
                        ?>

                        <tr>
                            <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                            <td class='tablerow2'><strong><?php echo Security::textFilterHK($row['room_id']); ?></strong></td>
                            <td class='tablerow2'><?php echo $row['name']; ?></td>
                            <td class='tablerow2' align='left'><?php echo $row['ai_type']; ?></td>
                            <td class='tablerow2' align='left'><?php echo $row['motto']; ?></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/bots&do=edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Editar'></a></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/bots&do=delete&key=<?php echo $row['id']; ?>'><img src='./w/images/del.gif' alt='Eliminar'></a></td>															
                        </tr>

                    <?php } ?>

                </table>

                <div class='tableborder'>
                    <div class='tableheaderalt'><center>
                            BOTS - Viso geral

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
                            <span class='button tiny radius'  href='./p/bots&amp;do=add'>Adicionar Bot</span>
                    </div>
                </div>

                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>
                <?php
                }
            elseif ($do == "add")
                {
                ?>
                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

                <form action='<?php echo $adminpath; ?>/p/bots&do=add' method='post' name='theAdminForm' id='theAdminForm'>
                    <div class='tableborder'>
                        <div class='tableheaderalt'><center>
                                Crear Bots
                            </center></div>

                        <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Nome</b>
                                    <div class='graytext'>Ttulo bot.</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='name' value="" size='30' class='textinput' id="name"></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Tipo</b>
                                    <div class='graytext'>Bot para um tipo de quarto escolhido genrico.</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><label for="ai_type"></label>
                                    <select name="ai_type" id="ai_type">
                                        <option value="generic">Genrico</option>
                                        <option value="guide">Guia</option>
                                        <option value="pet">Mascote</option>
                                    </select></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Look</b>
                                    <div class='graytext'>Escreva o Look de<font color="green"><a href="http://fibbox.org"></a></font> Bot. Voc pode copiar a partir do  <strong>Figure_Data</strong> qualquer usurio.</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><textarea name="look" cols="30" rows="4" class="textinput" id="look"></textarea></td>
                            </tr>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Rom ID</b>
                                    <div class='graytext'>Digite o ID da sala voc ser o bot.</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='room_id' value="" size='30' class='textinput' id="room_id"></td>
                            </tr>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Misso</b>
                                    <div class='graytext'>Escreva a misso para o bot.</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='motto' value="" size='30' class='textinput' id="motto" /></td>
                            </tr>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Coordenadas</b>
                                    <div class='graytext'>Ponha-se na parte onde voc quer este bot e colocar o comando :coords e colocar o mesmo aqui.</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'>X:
                                    <input type='text' name='x' size='6' class='textinput' id="x">
                                    Y:
                                    <input type='text' name='y' value="" size='6' class='textinput' id="y" />
                                    Z:
                                    <input type='text' name='z' value="" size='6' class='textinput' id="z" /> 
                                    Rot:
                                    <input type='text' name='rotation' value="" size='6' class='textinput' id="rotation" /></td>
                            </tr>
                            <tr>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Ser que ela se move?</b>
                                    <div class='graytext'>Escolha como voc deseja mover.</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><label for="walk_mode"></label>
                                    <select name="walk_mode" id="walk_mode">
                                        <option value="stand">No se mova</option>
                                        <option value="specified_range">Especificar intervalo</option>
                                        <option value="freeroam">Livremente</option>
                                    </select></td>
                            </tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>Movimento mnimo</b>
                                <div class='graytext'>Digite a posio mnima, uma vez que pode mover-se.</div></td>
                            <td class='tablerow2'  width='60%'  valign='middle'>X: 
                                <input type='text' name='min_x' value="" size='6' class='textinput' id="min_x" /> 
                                Y:
                                <input type='text' name='min_y' value="" size='6' class='textinput' id="min_y" /></td>
                            </tr>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Movimiento Maximo</b>
                                    <div class='graytext'>Tipo desde posio mxima pode ser movido.</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'>X:
                                    <input type='text' name='max_x' value="" size='6' class='textinput' id="max_x" />
                                    Y:
                                    <input type='text' name='max_y' value="" size='6' class='textinput' id="max_y" /></td>
                            </tr>



                            <tr>
                            <tr>
                                <td align='center' class='tablerow1' colspan='2' >Selecione No se mexa. Se voc que so selecionados por pr-configurao em algum lugar gama epefica e escrev-lo em reas X e Y mnimo e mximo de movimento. Se o movimento quer ser livre e ilimitado selecionar andar livremente. Bots no aparecer at a prxima reinicializao o emulador.</td></tr>
                            <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' name='submit' value='Adicionar Bot' class='realbutton' accesskey='s'></td></tr>

                        </table>

                    </div>
            </div>
        </form>

        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>
        <?php
        }
    elseif ($do == "edit" && is_numeric($key))
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

        <form action='<?php echo $adminpath; ?>/p/bots&do=save&key=<?php echo $article['id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>
                        BOT <u><?php echo $articlen['title']; ?></u> (ID: <?php echo $article['id']; ?>) <img src="./w/images/edit.gif">
                    </center></div>

                <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Nome</b>  <div class='graytext'>Ttulo bot.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='name' value="<?php echo $article['name']; ?>" size='30' class='textinput' id="name" /></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Tipo</b><div class='graytext'>Bot para um tipo de quarto escolhido genrico.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><select name="ai_type" id="ai_type">
                                <option value="generic" <?php
                                if (!(strcmp("generic", $article['ai_type'])))
                                    {
                                    echo "selected=\"selected\"";
                                    }
                                ?>>Genrico</option>
                                <option value="guide" <?php
                                if (!(strcmp("guide", $article['ai_type'])))
                                    {
                                    echo "selected=\"selected\"";
                                    }
                                ?>>Guia</option>
                                <option value="pet" <?php
                                if (!(strcmp("pet", $article['ai_type'])))
                                    {
                                    echo "selected=\"selected\"";
                                    }
                                ?>>Mascote</option>
                            </select></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Loock</b><div class='graytext'>Escreva o look de<font color="green"><a href="http://fibbox.org"></a></font> Bot.<br /><font color="green"><a href="http://fibbox.org">Edies FibboX.</a></font></div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><textarea name="look" cols="30" rows="4" class="textinput" id="look"><?php echo $article['look']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Room ID</b><div class='graytext'>Digite o ID da sala voc ser o bot.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='room_id' value="<?php echo $article['room_id']; ?>" size='30' class='textinput' id="room_id" /></td>
                    </tr>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Misso</b><div class='graytext'>Escreva a misso para o bot.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='motto' value="<?php echo $article['motto']; ?>" size='30' class='textinput' id="motto" /></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Coordenadas</b><div class='graytext'>Ponha-se na parte onde voc quer este bot e colocar o comando: coords e colocar o mesmo aqui.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'>X:
                            <input type='text' name='x' value="<?php echo $article['x']; ?>" size='6' class='textinput' id="x" />
                            Y:
                            <input type='text' name='y' value="<?php echo $article['y']; ?>" size='6' class='textinput' id="y" />
                            Z:
                            <input type='text' name='z' value="<?php echo $article['z']; ?>" size='6' class='textinput' id="z" />
                            Rot:
                            <input type='text' name='rotation' value="<?php echo $article['rotation']; ?>" size='6' class='textinput' id="rotation" /></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Room ID</b><div class='graytext'>Digite o ID da sala voc ser o bot.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><select name="walk_mode" id="walk_mode">
                                <option value="stand" <?php
                                if (!(strcmp("stand", $article['walk_mode'])))
                                    {
                                    echo "selected=\"selected\"";
                                    }
                                ?>>No se mova</option>
                                <option value="specified_range" <?php
                                if (!(strcmp("specified_range", $article['walk_mode'])))
                                    {
                                    echo "selected=\"selected\"";
                                    }
                                ?>>Especificar intervalo</option>
                                <option value="freeroam" <?php
                                if (!(strcmp("freeroam", $article['walk_mode'])))
                                    {
                                    echo "selected=\"selected\"";
                                    }
                                ?>>Livremente</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Room ID</b><div class='graytext'>Digite o ID da sala voc ser o bot.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'>
                            X:
                            <input type='text' name='min_x' value="<?php echo $article['min_x']; ?>" size='6' class='textinput' id="min_x" />
                            Y:
                            <input type='text' name='min_y' value="<?php echo $article['min_y']; ?>" size='6' class='textinput' id="min_y" /></td>
                    </tr>
                    <tr>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Room ID</b><div class='graytext'>Digite o ID da sala voc ser o bot.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'>
                            X:
                            <input type='text' name='max_x' value="<?php echo $article['max_x']; ?>" size='6' class='textinput' id="max_x" />
                            Y:
                            <input type='text' name='max_y' value="<?php echo $article['max_y']; ?>" size='6' class='textinput' id="max_y" /></td>
                    </tr>
                    <tr>
                        <td align='center' class='tablerow1' colspan='2' >Selecione No se mova. Se voc que so selecionados por pr-configurao em algum lugar gama epefica e escrev-lo em reas X e Y mnimo e mximo de movimento. Se o movimento quer ser livre e ilimitado selecionar andar livremente.</td></tr>



                    <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Atualizar Bot' class='realbutton' accesskey='s'></td></tr>
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
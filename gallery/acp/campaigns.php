<?php
/* Security Proof */
$included_files = 2345;
$included_files = get_included_files();
if (!in_array($_SERVER['DOCUMENT_ROOT'] . '\CORE.php', $included_files))
    die();

if ($user_rank > 6)
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

    $pagename = "Novidades do Hotel";
    $pageid   = "campaigns";

    $page = Security::textFilter($_GET['page']);

    $posts = Transaction::evaluate("SELECT COUNT(*) FROM mobbo_hotcampaigns");
    $pages = ceil(($posts + 0) / 50);

    if ($page > $pages || $page < 1)
        {
        $page = 1;
        }

    if ($_POST['site'])
        {
        header("location: " . $adminpath . "/p/campaigns&page=" . $_POST['page'] . "");
        }

    if ($_POST['site2'])
        {
        header("location: " . $adminpath . "/p/campaigns&page=" . $_POST['page2'] . "");
        }

    if ($do == "delete" && is_numeric($key))
        {

        $check = Transaction::query("SELECT id FROM mobbo_hotcampaigns WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            Transaction::query("DELETE FROM mobbo_hotcampaigns WHERE id = '" . $key . "' LIMIT 1");
            $msg = "<div class='rounded rounded-green'><center>Notcia eliminada corretamente<img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Erro: no se pde eliminar a notcia. <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "edit" && is_numeric($key))
        {

        $check = Transaction::query("SELECT * FROM mobbo_hotcampaigns WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            $campaign    = Transaction::fetch($check);
            $editor_mode = true;
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>>Erro: no se pde eliminar a notcia <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "save" && is_numeric($key) && isset($_POST['image_url']))
        {

        $check = Transaction::query("SELECT id FROM mobbo_hotcampaigns WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {

            $campaigndata = Transaction::fetch($check);

            Transaction::query("UPDATE mobbo_hotcampaigns SET image_url = '" . Security::textFilter($_POST['image_url']) . "', caption = '" . Security::textFilter($_POST['caption']) . "', botao = '" . Security::textFilter($_POST['botao']) . "', descr = '" . Security::textFilter($_POST['descr']) . "', url = '" . Security::textFilter($_POST['url']) . "' WHERE id = '" . $key . "' LIMIT 1");
            $msg         = "<div class='rounded rounded-green'><center>Campanha publicada! <img src=\"./w/images/check.gif\"></center></div>";
            $editor_mode = false;
            }
        else
            {

            $msg = "<div class='rounded rounded-red'><center>Esta campanha no existe <img src=\"./w/images/check.gif\"></center></div>";
            }
        }
    elseif ($do == "add")
        {

        $editor_mode = true;

        if ($_POST['submit'])
            {

            Transaction::query("INSERT INTO mobbo_hotcampaigns (image_url,caption,descr,url,botao) VALUES ('" . Security::textFilter($_POST['image_url']) . "','" . Security::textFilter($_POST['caption']) . "','" . Security::textFilter($_POST['descr']) . "','" . Security::textFilter($_POST['url']) . "','" . Security::textFilter($_POST['botao']) . "')");

            $msg = "<div class='rounded rounded-green'><center>Campanha publicada corretamente</center></div>";

            $editor_mode = false;
            }
        }

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></strong></p><?php } ?>

    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>
    <?php
    if ($editor_mode !== true)
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

        <form action='<?php echo $adminpath; ?>/p/campaigns&do=save' method='post' name='theAdminForm' id='theAdminForm'>

            <div class='tableborder'>
                <div class='tableheaderalt'><center>Novidades do Hotel

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

                        <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site" value="Prximo "> <span class='button tiny radius'  href='./p/campaigns&do=add'>Adicionar</span>
                </div>


                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='1%' align='center'>ID</td>
                        <td class='tablesubheader' width='10%'>Ttulo</td>
                        <td class='tablesubheader' width='20%' align='left'>Descrio</td>
                        <td class='tablesubheader' width='10%' align='left'>Imagem (50% do tamanho original)</td>
                        <td class='tablesubheader' width='10%' align='left'>URL</td>
                        <td class='tablesubheader' width='7%' align='left'>Boto</td>
                        <td class='tablesubheader' width='1%' align='center'>Editar</td>
                        <td class='tablesubheader' width='1%' align='center'>Excluir</td>
                    </tr>

                    <?php
                    $query_min = ($page * 50) - 50;

                    if ($query_min < 0)
                        { // Page 1
                        $query_min = 0;
                        }

                    $get_hotcampaigns = Transaction::query("SELECT * FROM mobbo_hotcampaigns ORDER BY id DESC LIMIT " . $query_min . ", 50");
                    while ($row              = Transaction::fetch($get_hotcampaigns))
                        {
                        ?>

                        <tr>
                            <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                            <td class='tablerow2'><?php echo $row['caption']; ?></td>
                            <td class='tablerow2' align='left'><?php echo $row['descr']; ?></td>
                            <td class='tablerow2' align='left'><img src="<?php echo $row['image_url']; ?>"<width="379" height="150"></img></td>
                            <td class='tablerow2' align='left'><a href="<?php echo $row['url']; ?>" target="_new"><?php echo $row['url']; ?></a></td>
                            <td class='tablerow2' align='left'><?php echo $row['botao']; ?></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/campaigns&do=edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Edit'>															
                                    <td class='tablerow2' align='center'></a> <a href='<?php echo $adminpath; ?>/p/campaigns&do=delete&key=<?php echo $row['id']; ?>'><img src='./w/images/del.gif' alt='Delete'></a></td>

                            </tr>

                        <?php } ?>

                </table>

                <div class='tableborder'>
                    <div class='tableheaderalt'><center>Novidades do Hotel

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

                            <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site2" value="Prxima "> <span class='button tiny radius'  href='./p/campaigns&do=add'>Adicionar</span>
                    </div>
                </div>

                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>
                <?php
                }
            elseif ($do == "add")
                {
                ?>
                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

                <form action='<?php echo $adminpath; ?>/p/campaigns&do=add' method='post' name='theAdminForm' id='theAdminForm'>
                    <div class='tableborder'>
                        <div class='tableheaderalt'>Adicionar</div>

                        <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Ttulo</b><div class='graytext'>Ttulo da campanha</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='caption' value="" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Descrio</b><div class='graytext'>Resumo da campanha<br /><font color="green">HTML ativado.</font></div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><textarea name='descr' cols='60' rows='5' wrap='soft' id='sub_desc' class='multitext'></textarea></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Imagem</b><div class='graytext'>A imagem da campanha "HotCampaing"</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='image_url' value="" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>URL</b><div class='graytext'>Ao clicar ser redirecionado para...?</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='url' value="" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Palavra do boto</b><div class='graytext'>Exemplo: Confira; Clique aqui, e etc.</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='botao' value="<?php echo $campaign['botao']; ?>" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' name='submit' value='Publicar' class='realbutton' accesskey='s'></td>
                            </tr>

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

        <form action='<?php echo $adminpath; ?>/p/campaigns&do=save&key=<?php echo $campaign['id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>Novidades do Hotel <u><?php echo $campaign['caption']; ?></u> (ID: <?php echo $campaign['id']; ?>) <img src="./w/images/edit.gif"></center></div>

                <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Titulo</b><div class='graytext'>Ttulo da Novidade</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='caption' value="<?php echo $campaign['caption']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Descrio</b><div class='graytext'>Descrio da novidade<br /><font color="green">HTML ativado.</font></div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><textarea name='descr' cols='60' rows='5' wrap='soft' id='descr' class='multitext'><?php echo $campaign['descr']; ?></textarea></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Imagem</b><div class='graytext'>URL da Imagem "HotCampaing".</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='image_url' value="<?php echo $campaign['image_url']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>URL</b><div class='graytext'>Ao clicar, ser redirecionado para...?</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='url' value="<?php echo $campaign['url']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Palavra do boto</b><div class='graytext'>Exemplo: Confira; Clique aqui, e etc.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='botao' value="<?php echo $campaign['botao']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                    <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Publicar' class='realbutton' accesskey='s'></td></tr>
                    </form></table></div><br />

            <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>
        <?php } ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>

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
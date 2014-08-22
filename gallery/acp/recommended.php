<?php
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

    $pagename = "Da gerncia";
    $pageid   = "recommended";

    $page = Security::textFilter($_GET['page']);

    $posts = Transaction::evaluate("SELECT COUNT(*) FROM mobbo_recommended");
    $pages = ceil(($posts + 0) / 50);

    if ($page > $pages || $page < 1)
        {
        $page = 1;
        }

    if ($_POST['site'])
        {
        header("location: " . $adminpath . "/p/recommended&page=" . $_POST['page'] . "");
        }

    if ($_POST['site2'])
        {
        header("location: " . $adminpath . "/p/recommended&page=" . $_POST['page2'] . "");
        }

    if ($do == "delete" && is_numeric($key))
        {

        $check = Transaction::query("SELECT id FROM mobbo_recommended WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            Transaction::query("DELETE FROM mobbo_recommended WHERE id = '" . $key . "' LIMIT 1");
            $msg = "<div class='rounded rounded-green'><center>Removido com sucesso <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>No foi possvel realizar a ao desejada, tente novamente<img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "edit" && is_numeric($key))
        {

        $check = Transaction::query("SELECT * FROM mobbo_recommended WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            $recommended = Transaction::fetch($check);
            $editor_mode = true;
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>No foi possvel realizar a ao desejada, tente novamente <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "save" && is_numeric($key) && isset($_POST['id_rec']))
        {

        $check = Transaction::query("SELECT id FROM mobbo_recommended WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {

            if ($_POST['comments'] == true)
                {
                $checked = '1';
                }
            else
                {
                $checked = '0';
                }

            Transaction::query("UPDATE mobbo_recommended SET type = '" . Security::textFilter($_POST['type']) . "', id_rec = '" . Security::textFilter($_POST['id_rec']) . "' WHERE id = '" . $key . "' LIMIT 1");
            $msg         = "<div class='rounded rounded-green'><center>As preferncias foram salvos<img src=\"./w/images/check.gif\"></center></div>";
            $editor_mode = false;
            }
        else
            {

            $msg = "<div class='rounded rounded-red'><center>Isto no existe<img src=\"./w/images/check.gif\"></center></div>";
            }
        }
    elseif ($do == "add")
        {

        $editor_mode = true;

        if ($_POST['submit'])
            {
            Transaction::query("INSERT INTO mobbo_recommended (id_rec,type) VALUES ('" . Security::textFilter($_POST['id_rec']) . "','" . Security::textFilter($_POST['type']) . "')");

            $msg         = "<div class='rounded rounded-green'><center>A atualizao foi feita</center></div>";
            $editor_mode = false;
            }
        }

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></strong></p><?php } ?>

    <?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
    <?php
    if ($editor_mode !== true)
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>

        <form action='<?php echo $adminpath; ?>/p/recommended&do=save' method='post' name='theAdminForm' id='theAdminForm'>

            <div class='tableborder'>
                <div class='tableheaderalt'><center>Quartos/Grupos recomendados

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

                        <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site" value="Prximo "> <span class='button tiny radius'  href='./p/recommended&do=add'>Adicionar</span>
                </div>

                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='1%' align='center'>ID</td>
                        <td class='tablesubheader' width='20%'>Tipo</td>
                        <td class='tablesubheader' width='20%' align='left'>ID da ao</td>
                        <td class='tablesubheader' width='20%' align='center'>Editar</td>
                        <td class='tablesubheader' width='1%' align='center'>Remover</td>
                    </tr>
                    <?php
                    $query_min = ($page * 50) - 50;

                    if ($query_min < 0)
                        { // Page 1
                        $query_min = 0;
                        }

                    $get_recommended = Transaction::query("SELECT * FROM mobbo_recommended ORDER BY id DESC LIMIT " . $query_min . ", 50");
                    while ($row             = Transaction::fetch($get_recommended))
                        {
                        ?>

                        <tr>
                            <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                            <td class='tablerow2'><?php
                                if ($row['type'] == "room")
                                    {
                                    echo'Sala';
                                    }
                                else
                                    {
                                    echo'Grupo';
                                    }
                                ?></td>
                            <td class='tablerow2' align='left'><?php echo $row['id_rec']; ?></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/recommended&do=edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Editar'></a></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/recommended&do=delete&key=<?php echo $row['id']; ?>'><img src='./w/images/del.gif' alt='Eliminar'></a></td>															
                        </tr>

                    <?php } ?>

                </table>

                <div class='tableborder'>
                    <div class='tableheaderalt'><center>Quartos/Grupos recomendados

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

                            <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site2" value="Prximo "> <span class='button tiny radius'  href='./p/recommended&do=add'>Adicionar</span>
                    </div>

                    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>
                    <?php
                    }
                elseif ($do == "add")
                    {
                    ?>
                    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

                    <form action='<?php echo $adminpath; ?>/p/recommended&do=add' method='post' name='theAdminForm' id='theAdminForm'>
                        <div class='tableborder'>
                            <div class='tableheaderalt'><center>Quartos/Grupos recomendados</center></div>

                            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                                <tr>
                                    <td class='tablerow1'  width='40%'  valign='middle'><b>Quartos recomendados</b><div class='graytext'></div></td>
                                    <td class='tablerow2'  width='60%'  valign='middle'><select name='type'  class='dropdown'>
                                            <option value='room'>Quarto</option>
                                            <option value='group' selected='selected'>Grupo</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class='tablerow1'  width='40%'  valign='middle'><b>ID</b><div class='graytext'>ID da sala/Grupo</div></td>
                                    <td class='tablerow2'  width='60%'  valign='middle'><input type="text" name="id_rec" value=""></td>
                                </tr>

                                <tr>
                                    <td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' name='submit' value='Adicionar' class='realbutton' accesskey='s'></td>
                                </tr>

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
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>

        <form action='<?php echo $adminpath; ?>/p/recommended&do=save&key=<?php echo $recommended['id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>Editar (ID: <?php echo $recommended['id']; ?>) <img src="./w/images/edit.gif"></center></div>

                <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Tipo</b><div class='graytext'>Quarto do Grupo</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><select name='type'  class='dropdown'>
                                <option value='room' <?php
                                if ($recommended['type'] == "room")
                                    {
                                    echo" selected='selected'";
                                    }
                                ?>>Sala</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>ID</b><div class='graytext'>ID</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type="text" name="id_rec" value="<?php echo $recommended['id_rec']; ?>"></td>
                    </tr>

                    <tr>
                    <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Salvar' class='realbutton' accesskey='s'></td></tr>
                    </form></table></div><br />

            <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>
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
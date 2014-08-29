<?php
/* Security Proof */
$included_files = 2345;
$included_files = get_included_files();
if (!in_array($_SERVER['DOCUMENT_ROOT'] . '\CORE.php', $included_files))
    die();

if ($user_rank > 4)
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

    $pagename = "Banners";
    $pageid   = "banners";

    if ($do == "delete" && is_numeric($key))
        {

        $check = Transaction::query("SELECT id FROM mobbo_banners WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            Transaction::query("DELETE FROM mobbo_banners WHERE id = '" . $key . "' LIMIT 1");
            $msg = "<div class='rounded rounded-green'><center>Banner borrado. <img src=\"./w/images/check.gif\"></center></div>";
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Banner gelscht','banners.php','" . $my_id . "','0','" . $date_full . "')");
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - Banner no encontrado <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "edit" && is_numeric($key))
        {

        $check = Transaction::query("SELECT * FROM mobbo_banners WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            $banner      = Transaction::fetch($check);
            $editor_mode = true;
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - El banner no se ha podido encontrar. <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "save" && is_numeric($key))
        {

        $check = Transaction::query("SELECT * FROM mobbo_banners WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {

            $exists = Transaction::fetch($check);

            Transaction::query("UPDATE mobbo_banners SET text = '" . $_POST['text'] . "', banner = '" . $_POST['banner'] . "', url = '" . $_POST['url'] . "', html = '" . $_POST['html'] . "' WHERE id = '" . $key . "' LIMIT 1");
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Banner bearbeitet','banners.php','" . $my_id . "','0','" . $date_full . "')");
            $msg         = "<div class='rounded rounded-green'><center>Der Banner wurde erfolgreich bearbeitet. <img src=\"./w/images/check.gif\"></center></div>";
            $editor_mode = false;
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - El banner no se ha podido encontrar. <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "add")
        {

        $editor_mode = true;

        if ($_POST['submit'])
            {

            Transaction::query("INSERT INTO mobbo_banners (text,banner,url,html) VALUES ('" . $_POST['text'] . "','" . $_POST['banner'] . "','" . $_POST['url'] . "','" . $_POST['html'] . "')");
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Banner hinzugefgt','banners_add.php','" . $my_id . "','0','" . $date_full . "')");
            $msg         = "<div class='rounded rounded-green'><center>Banner agregado con &eacute;xito <img src=\"./w/images/check.gif\"></center></div>";
            $editor_mode = false;
            }
        }

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></strong></p><?php } ?>

    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  ?>
    <?php
    if ($editor_mode !== true)
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

        <form action='<?php echo $path; ?>/manage/hotel/de/housekeeping/p/banners&do=save' method='post' name='theAdminForm' id='theAdminForm'>

            <div class='tableborder'>
                <div class='tableheaderalt'><center>Banners - Informaci&oacute;n general</center></div>
                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='1%' align='center'>ID</td>
                        <td class='tablesubheader' width='10%' align='center'>Texto</td>
                        <td class='tablesubheader' width='10%' align='center'>Imagen</td>
                        <td class='tablesubheader' width='10%' align='center'>URL</td>
                        <td class='tablesubheader' width='10%' align='center'>HTML</td>
                        <td class='tablesubheader' width='1%' align='center'>Editar</td>
                        <td class='tablesubheader' width='1%' align='center'>Borrar</td>
                    </tr>
                    <?php
                    $get_banners = Transaction::query("SELECT * FROM mobbo_banners ORDER BY id");
                    while ($row         = Transaction::fetch($get_banners))
                        {
                        ?>

                        <tr>
                            <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                            <td class='tablerow2' align='center'><?php echo $row['text']; ?></td>
                            <td class='tablerow2' align='center'><?php echo $row['banner']; ?></td>
                            <td class='tablerow2' align='center'><?php echo $row['url']; ?></td>
                            <td class='tablerow2' align='center'><?php echo $row['html']; ?></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $path; ?>/manage/hotel/de/housekeeping/p/banners&do=edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Editar'></a></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $path; ?>/manage/hotel/de/housekeeping/p/banners&do=delete&key=<?php echo $row['id']; ?>'><img src='./w/images/del.gif' alt='Eliminar'></a></td>
                        </tr>
                    <?php } ?>

                </table>
                <div class='tablefooter' align='center'><div class='fauxbutton-wrapper'><span class='button tiny radius'  href='<?php echo $path; ?>/manage/hotel/de/housekeeping/p/banners&do=add'>Agregar</span></div></div>
            </div>

            <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>
            <?php
            }
        elseif ($do == "add")
            {
            ?>
            <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>


            <form action='<?php echo $adminpath; ?>/p/banners&do=add' method='post' name='theAdminForm' id='theAdminForm'>
                <div class='tableborder'>
                    <div class='tableheaderalt'><center>Crear banner</center></div>

                    <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

                        <tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>Texto</b><div class='graytext'>Texto que aparecer&aacute; bajo el banner</div></td>
                            <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='text' value="" size='30' class='textinput'></td>
                        </tr>

                        <tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>Banner</b><div class='graytext'>Imagen</div></td>
                            <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='banner' value="" size='30' class='textinput'></td>
                        </tr>

                        <tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>URL</b><div class='graytext'>Destino al hacer click</div></td>
                            <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='url' value="" size='30' class='textinput'></td>
                        </tr>

                        <tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>HTML</b><div class='graytext'>C&oacute;digo HTML</div></td>
                            <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='html' value="" size='30' class='textinput'></td>
                        </tr>

                        <tr>
                        <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' name='submit' value='Agregar' class='realbutton' accesskey='s'></td></tr>

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

            <form action='p/banners&do=save&key=<?php echo $banner['id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
                <div class='tableborder'>
                    <div class='tableheaderalt'>Banner ID: <?php echo $banner['id']; ?>)</b></div>

                    <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

                        <tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>Text</b><div class='graytext'>Der Text wird unter den Banner angezeigt</div></td>
                            <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='text' value="<?php echo $banner['text']; ?>" size='30' class='textinput'></td>
                        </tr>

                        <tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>Banner</b><div class='graytext'>Das Bild des Banners (Dann darf kein HTML benutzt werden)</div></td>
                            <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='banner' value="<?php echo $banner['banner']; ?>" size='30' class='textinput'></td>
                        </tr>

                        <tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>URL</b><div class='graytext'>Weiterleitung beim Klick des Banners</div></td>
                            <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='url' value="<?php echo $banner['url']; ?>" size='30' class='textinput'></td>
                        </tr>

                        <tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>HTML</b><div class='graytext'>Der HTML Code des Banners (Dann darf kein Image benutzt werden)</div></td>
                            <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='html' value="<?php echo $banner['html']; ?>" size='30' class='textinput'></td>
                        </tr>

                        <tr>
                        <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Speichern' class='realbutton' accesskey='s'></td></tr>
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
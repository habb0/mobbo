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

    $pagename = "Loja de emblemas";
    $pageid   = "marktplatz";

    $page = Security::textFilter($_GET['page']);

    $posts = Transaction::evaluate("SELECT COUNT(*) FROM mobbo_shop");
    $pages = ceil(($posts + 0) / 50);

    if ($page > $pages || $page < 1)
        {
        $page = 1;
        }

    if ($_POST['site'])
        {
        header("location: " . $adminpath . "/p/marktplatz&page=" . $_POST['page'] . "");
        }

    if ($_POST['site2'])
        {
        header("location: " . $adminpath . "/p/marktplatz&page=" . $_POST['page2'] . "");
        }

    if ($do == "delete" && is_numeric($key))
        {

        $check = Transaction::query("SELECT id FROM mobbo_shop WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            Transaction::query("DELETE FROM mobbo_shop WHERE id = '" . $key . "' LIMIT 1");
            $msg = "<div class='rounded rounded-green'><center>Emblema excluido com sucesso <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Erro: Emblema no encontrado <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "edit" && is_numeric($key))
        {

        $check = Transaction::query("SELECT * FROM mobbo_shop WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            $marktplatz  = Transaction::fetch($check);
            $editor_mode = true;
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Erro: no foi possvel encontrar o emblema <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "save" && is_numeric($key))
        {

        $check = Transaction::query("SELECT * FROM mobbo_shop WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {

            Transaction::query("UPDATE mobbo_shop SET name = '" . $_POST['name'] . "', image = '" . $_POST['image'] . "', credits = '" . $_POST['credits'] . "' WHERE id = '" . $key . "' LIMIT 1");

            $msg         = "<div class='rounded rounded-green'><center>Informaes atualizadas corretamente. <img src=\"./w/images/check.gif\"></center></div>";
            $editor_mode = false;
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Erro: no foi possvel encontrar o emblema. <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "add")
        {

        $editor_mode = true;

        if ($_POST['submit'])
            {

            Transaction::query("INSERT INTO mobbo_shop (image,name,credits) VALUES ('" . $_POST['image'] . "','" . $_POST['name'] . "','" . $_POST['credits'] . "')");
            $msg         = "<div class='rounded rounded-green'><center>Emblema adicionado corretamente! <img src=\"./w/images/check.gif\"></center></div>";
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
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>

        <form action='<?php echo $adminpath; ?>/p/marktplatz&do=save' method='post' name='theAdminForm' id='theAdminForm'>

            <div class='tableborder'>
                <div class='tableheaderalt'><center>Pgina 

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
                                ?>><?php echo $i; ?>  </option>
                                    <?php } ?>
                        </select>

                        <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site" value="Prxima Pgina "> <span class='button tiny radius'  href='./p/marktplatz&do=add'>Adicionar</span>
                </div>

                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='1%' align='center'>ID</td>
                        <td class='tablesubheader' width='10%' align='center'>Cdigo do emblema</td>
                        <td class='tablesubheader' width='10%' align='center'>Nome</td>
                        <td class='tablesubheader' width='10%' align='center'>Preo</td>
                        <td class='tablesubheader' width='10%' align='center'>Editar</td>
                        <td class='tablesubheader' width='12%' align='center'>Borrar</td>
                    </tr>
                    <?php
                    $query_min = ($page * 50) - 50;

                    if ($query_min < 0)
                        { // Page 1
                        $query_min = 0;
                        }

                    $get_marktplatz = Transaction::query("SELECT * FROM mobbo_shop ORDER BY id DESC LIMIT " . $query_min . ", 50");
                    while ($row            = Transaction::fetch($get_marktplatz))
                        {
                        ?>

                        <tr>
                            <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                            <td class='tablerow2' align='center'><img src="http://127.0.0.1/c_images/album1584/<?php echo $row['image']; ?>.gif" alt="<?php echo $row['image']; ?>"></td>
                            <td class='tablerow2' align='center'><?php echo $row['name']; ?></td>
                            <td class='tablerow2' align='center'><?php echo $row['credits']; ?> Diamantes</td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/marktplatz&do=edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Edit'></a></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/marktplatz&do=delete&key=<?php echo $row['id']; ?>'><img src='./w/images/del.gif' alt='Delete'></a></td>
                        </tr>
                    <?php } ?>

                </table>

                <div class='tableborder'>
                    <div class='tableheaderalt'><center>Pgina

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

                            <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site2" value="Prxima Pgina "> <span class='button tiny radius'  href='./p/marktplatz&do=add'>Adicionar</span>
                    </div>

                    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>
                    <?php
                    }
                elseif ($do == "add")
                    {
                    ?>
                    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

                    <form action='<?php echo $adminpath; ?>/p/marktplatz&do=add' method='post' name='theAdminForm' id='theAdminForm'>
                        <div class='tableborder'>
                            <div class='tableheaderalt'><center>Botar emblema a venda</center></div>

                            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

                                <tr>
                                    <td class='tablerow1'  width='40%'  valign='middle'><b>Cdigo do emblema</b><div class='graytext'>Cdigo do emblema (ex: VICTOR)</div></td>
                                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='image' value="<?php echo $marktplatz['image']; ?>" size='30' class='textinput'></td>
                                </tr>

                                <tr>
                                    <td class='tablerow1'  width='40%'  valign='middle'><b>Nome</b><div class='graytext'>Nome que vai aparecer na loja</div></td>
                                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='name' value="<?php echo $marktplatz['name']; ?>" size='30' class='textinput'></td>
                                </tr>

                                <tr>
                                    <td class='tablerow1'  width='40%'  valign='middle'><b>Diamantes</b><div class='graytext'>Preo do emblema</div></td>
                                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='credits' value="<?php echo $marktplatz['credits']; ?>" size='30' class='textinput'></td>
                                </tr>

                                <tr>
                                    <td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' name='submit' value='Adicionar' class='realbutton' accesskey='s'></td>
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
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

        <form action='<?php echo $adminpath; ?>/p/marktplatz&do=save&key=<?php echo $marktplatz['id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>Emblema: <b>(<?php echo $marktplatz['image']; ?>, ID: <?php echo $marktplatz['id']; ?>)</center></b></div>

                <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Cdigo do emblema</b><div class='graytext'>Cdigo do emblema (ex: VICTOR)</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='image' value="<?php echo $marktplatz['image']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Nome</b><div class='graytext'>Nome que vai aparecer na loja</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='name' value="<?php echo $marktplatz['name']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Diamantes</b><div class='graytext'>Preo do emblema</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='credits' value="<?php echo $marktplatz['credits']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                    <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Salvar' class='realbutton' accesskey='s'></td></tr>
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
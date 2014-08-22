<?php
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

if ($user_rank > 6)
    {

    $pagename = "Editar Emblemas";
    $pageid   = "badgetool";

    if (isset($_POST['badge']) && ($_POST['name']))
        {

        $check_name = Transaction::query("SELECT * FROM users WHERE username = '" . Security::textFilter($_POST['name']) . "'");
        if (Transaction::num_rows($check_name) > 0)
            {

            $userdata = Transaction::fetch($check_name);

            $check_badge = Transaction::query("SELECT * FROM user_badges WHERE user_id = '" . $userdata['id'] . "' AND badge_id = '" . Security::textFilter($_POST['badge']) . "' LIMIT 1");

            if ($_POST['action'] == "give")
                {

                if (Transaction::num_rows($check_badge) < 1)
                    {
                    Transaction::query("INSERT INTO user_badges (user_id,badge_id,badge_slot) VALUES ('" . $userdata['id'] . "','" . Security::textFilter($_POST['badge']) . "','0')");
                    $msg = "<div class='rounded rounded-green'><center>Voc acabou de dar  <b>" . Security::textFilter($_POST['name']) . "</b> o emblema " . Security::textFilter($_POST['badge']) . " com sucesso. <img src=\"./w/images/check.gif\"></center></div>";
                    }
                else
                    {
                    $msg = "<div class='rounded rounded-red'><center>" . $_POST['name'] . " J tm o Emblema " . $_POST['badge'] . ". <img src=\"./w/images/del.gif\"></center></div>";
                    }
                }
            else
                {

                if (Transaction::num_rows($check_badge) > 0)
                    {
                    Transaction::query("DELETE FROM user_badges WHERE user_id = '" . $userdata['id'] . "' AND badge_id = '" . Security::textFilter($_POST['badge']) . "'");
                    $msg = "<div class='rounded rounded-green'><center>Voc removeu o Emblema " . Security::textFilter($_POST['badge']) . " . <img src=\"./w/images/check.gif\"></center></div>";
                    }
                else
                    {
                    $msg = "<div class='rounded rounded-red'><center>" . Security::textFilter($_POST['name']) . " no tem o emblema " . Security::textFilter($_POST['badge']) . " <img src=\"./w/images/del.gif\"></center></div>";
                    }
                }
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>No foi possvel encontrar o usurio! <img src=\"./w/images/del.gif\"></center></div>";
            }
        }

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></p></strong><?php } ?>

    <form action='<?php echo $adminpath; ?>/p/badgetool&do=something' method='post' name='theAdminForm' id='theAdminForm'>
        <div class='tableborder'>
            <div class='tableheaderalt'>Administrar Emblemas</div>

            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><strong><?php echo $shortname; ?> Nome</strong><div class='graytext'>Nome do usurio que ir dar o Emblema</div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='name' value="<?php echo $_POST['name']; ?>" size='30' class='textinput'></td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><strong>Cdigo ou ID do Emblema</strong><div class='graytext'>Exemplo: ADM, NWB, HBA<br></div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='badge' value="<?php echo $_POST['badge']; ?>" size='30' class='textinput'></td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><b>Opo</b></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><select name='action' class='dropdown'><option value='give'>Dar</option><option value='delete'>Remover</option></select>
                    </td>
                </tr>

                <tr>
                <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Continuar' class='realbutton' accesskey='s'></td></tr>
                </form></table></div><br />

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
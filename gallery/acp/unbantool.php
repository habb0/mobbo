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

    $pagename = "Desbanir";
    $pageid   = "unban";


    if (isset($_POST['query']))
        {

        if ($_POST['type'] == 'ip')
            {
            $check_ip = Transaction::query("SELECT * FROM bans WHERE value = '" . Security::textFilter($_POST['query']) . "' AND bantype = 'ip'");
            if (Transaction::num_rows($check_ip) > 0)
                {
                Transaction::query("DELETE FROM bans WHERE value = '" . Security::textFilter($_POST['query']) . "' AND bantype = 'ip'");
                $msg = "<div class='rounded rounded-green'><center> (" . Transaction::num_rows($check_ip) . ") Desbaneado correctamente. <img src=\"./w/images/check.gif\"></center></div>";
                }
            else
                {
                $msg = "<div class='rounded rounded-red'><center>No foi possvel encontrar o banimento <img src=\"./w/images/del.gif\"></center></div>";
                }
            }
        else
            {
            $check_user = Transaction::query("SELECT * FROM bans WHERE value = '" . Security::textFilter($_POST['query']) . "' AND bantype = 'user'");
            if (Transaction::num_rows($check_user) > 0)
                {

                Transaction::query("DELETE FROM bans WHERE value = '" . Security::textFilter($_POST['query']) . "' AND bantype = 'user'");
                $msg = "<div class='rounded rounded-green'><center>Usurio desbanido corretamente! <img src=\"./w/images/check.gif\"></center></div>";
                }
            else
                {
                $msg = "<div class='rounded rounded-red'><center>No foi possvel encontrar o banimento <img src=\"./w/images/del.gif\"></center></div>";
                }
            }
        }

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></strong></p><?php } ?>

    <form action='<?php echo $adminpath; ?>/p/unban&do=unban' method='post' name='theAdminForm' id='theAdminForm'>
        <div class='tableborder'>
            <div class='tableheaderalt'><center>Desbanir usurios!</center></div>

            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><b>Usurio/IP</b><div class='graytext'>Digite o nome do usurio banido ou IP</div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='query' value="<?php echo $_POST['query']; ?>" size='30' class='textinput'></td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><b>Tipo:</b></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><select name='type' class='dropdown'><option value='user'>Usurio</option><option value='ip'>IP</option></select>
                    </td>
                </tr>

                <tr>
                <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Desbanir' class='realbutton' accesskey='s'></td></tr>
                </form></table></div><br />	 </div><!-- / RIGHT CONTENT BLOCK -->
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
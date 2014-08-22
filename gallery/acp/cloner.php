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

    $pagename = "Checar Multiplos IPs";
    $pageid   = "cloner";

    if (isset($_POST['query']) && ($_POST['type']))
        {

        if ($_POST['query'])
            {

            if ($_POST['type'] == "name")
                {

                $get_users_a = Transaction::query("SELECT * FROM users WHERE username = '" . Security::textFilter($_POST['query']) . "' ORDER BY username");
                $check_a     = Transaction::num_rows($get_users_a);

                if ($check_a > 0)
                    {

                    $userdata_a = Transaction::fetch($get_users_a);
                    $get_users  = Transaction::query("SELECT * FROM users WHERE ip_last = '" . $userdata_a['ip_last'] . "' or ip_reg = '" . $userdata_a['ip_reg'] . "' ORDER BY username");
                    $check      = Transaction::num_rows($get_users);
                    $msg        = "<div class='rounded rounded-green'><center><b>Foram encontrados os seguintes usurios com esse mesmo IP:</b> <img src=\"./w/images/check.gif\"></center></div>";
                    }
                else
                    {
                    $msg = "<div class='rounded rounded-red'><center><b>No foi possvel encontrar este usurio</b> <img src=\"./w/images/del.gif\"></center></div>";
                    }
                }
            else
                {

                $get_users = Transaction::query("SELECT * FROM users WHERE ip_last = '" . Security::textFilter($_POST['query']) . "' ORDER BY username");
                $check     = Transaction::num_rows($get_users);

                if ($check > 0)
                    {
                    $msg = "<div class='rounded rounded-green'><center><b>Foram encontrados os seguintes usurios com esse IP:</b> <img src=\"./w/images/check.gif\"></center></div>";
                    }
                else
                    {
                    $msg = "<div class='rounded rounded-red'><center><b>IP no encontrado!</b> <img src=\"./w/images/del.gif\"></center></div>";
                    }
                }
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center><b>Coloque o IP ou Nome do usurio!</b> <img src=\"./w/images/del.gif\"></center></div>";
            }
        }

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></p></strong><?php } ?>

    <form action='<?php echo $adminpath; ?>/p/cloner&do=search' method='post' name='theAdminForm' id='theAdminForm'>
        <div class='tableborder'>
            <div class='tableheaderalt'><center>Checar Muliplos IPs</center></div>

            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><strong>Nome de usurio/IP</strong><div class='graytext'>Digite o nome ou IP do usurio que deseja realizar a ao!</div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='query' value="<?php echo $_POST['query']; ?>" size='30' class='textinput'></td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><strong>Tipo</strong></td>
                    <td class='tablerow2'  width='60%'  valign='middle'>
                        <input name="type" value="name" <?php
                        if ($_POST['type'] == "name")
                            {
                            ?>checked="checked" <?php } ?>type="radio">&nbsp;Usurio <div class="divider"></div>
                        <input name="type" value="ip" <?php
                        if ($_POST['type'] == "ip")
                            {
                            ?>checked="checked" <?php } ?>type="radio">&nbsp;IP</td>
                </tr>

                <tr>
                    <td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Checar' class='realbutton' accesskey='s'></td>
                </tr>

            </table>

        </div>
    </div>
    </form>

    <?php
    if (isset($_POST['query']) && ($_POST['type']) && $check > 0 or $check_a > 0)
        {
        ?>

        <br>

        <div class='tableborder'>
            <div class='tableheaderalt'><center>Usurios encontrados</center></div>
            <table cellpadding='4' cellspacing='0' width='100%'>
                <tr>
                    <td class='tablesubheader' width='1%' align='center'>ID</td>
                    <td class='tablesubheader' width='10%'>Nome</td>
                    <td class='tablesubheader' width='15%' align='left'>E-Mail</td>
                    <td class='tablesubheader' width='10%' align='left'>IP(Registro)</td>
                    <td class='tablesubheader' width='10%' align='left'>IP(&Uacute;ltima vez)</td>
                    <td class='tablesubheader' width='20%' align='left'>&Uacute;ltima vez no Hotel</td>
                    <td class='tablesubheader' width='20%' align='left'>Data de registro</td>
                    <td class='tablesubheader' width='10%' align='left'>Estado</td>
                    <td class='tablesubheader' width='10%' align='left'>Banido</td>
                    <td class='tablesubheader' width='10%' align='left'>Editar</td>
                </tr>
                <?php
                while ($row = Transaction::fetch($get_users))
                    {
                    $get_banns = Transaction::query("SELECT * FROM bans WHERE value = '" . $row['id'] . "' AND bantype = 'user' OR value = '" . $row['ip_last'] . "' AND bantype = 'ip'");

                    if ($row['online'] > 0)
                        {
                        $status = "Online";
                        }
                    else
                        {
                        $status = "Offline";
                        }

                    if (Transaction::num_rows($get_banns) > 0)
                        {
                        $color = "Verde";
                        $text  = "Sim";
                        }
                    else
                        {
                        $color = "Vermelho";
                        $text  = "No";
                        }
                    ?>

                    <tr>
                        <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                        <td class='tablerow2'><a href='<?php echo $path; ?>/home/<?php echo $row['username']; ?>'><strong><?php echo $row['username']; ?></strong></a></td>
                        <td class='tablerow2' align='left'><a href='mailto:<?php echo $row['mail']; ?>'><?php echo $row['mail']; ?></a></td>
                        <td class='tablerow2' align='left'><?php echo $row['ip_reg']; ?></td>
                        <td class='tablerow2' align='left'><?php echo $row['ip_last']; ?></td>
                        <td class='tablerow2' align='left'><?php echo date('d/m/Y', $row['last_online']); ?></td>
                        <td class='tablerow2' align='left'><?php echo date('d/m/Y', $row['account_created']); ?></td>
                        <td class='tablerow2' align='left'></td>
                        <td class='tablerow2' align='left'><font color="<?php echo $color; ?>"><?php echo $text; ?></font></td>
                        <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/users_edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Edit User Data'></a></td>
                    </tr>

                <?php } ?>

            </table>
        </div>
    <?php } ?>
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
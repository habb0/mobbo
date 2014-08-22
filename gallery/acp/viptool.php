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

    $pagename = "Usurios VIP";
    $pageid   = "viptool";

    if ($do == "delete" && $_GET['vip'])
        {

        $check = Transaction::query("SELECT * FROM users WHERE vip = '" . $key . "'");
        if (Transaction::num_rows($check) > 0)
            {

            $user_check = Transaction::query("SELECT * FROM users WHERE id = '" . $key . "' LIMIT 1");
            $userdata   = Transaction::fetch($user_check);

            Transaction::query("DELETE FROM users WHERE vip = '" . $key . "'");
            Transaction::query("DELETE FROM user_badges WHERE user_id = '" . $key . "' AND badge_id = 'VIP'");
            Transaction::query("UPDATE users SET rank = '1', vip = '0' WHERE id = '" . $key . "'");
            Transaction::query("INSERT INTO mobbo_alerts (userid,alert) VALUES ('" . $userdata['id'] . "','Voc agora  parte do Hobba VIP!')");
            $msg = "<div class='rounded rounded-green'><center>" . $userdata['username'] . " Foi removido da lista de usurios VIP <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>No foi possvel encontrar este usurio.<img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "add" && $_POST['vip'])
        {

        // $timened = time() + 15552000;
        $timeend2 = time() + 1296000 * 2;

        $user_check = Transaction::query("SELECT * FROM users WHERE username = '" . $_POST['vip'] . "' LIMIT 1");
        $userdata   = Transaction::fetch($user_check);

        $badge_check = Transaction::query("SELECT * FROM user_badges WHERE user_id = '" . $userdata['id'] . "' and badge_id = 'VIP'");

        $vip_check = Transaction::query("SELECT * FROM users WHERE id = '" . $userdata['id'] . "' LIMIT 1");
        $vip       = Transaction::fetch($vip_check);

        if (Transaction::num_rows($user_check) > 0)
            {

            if (Transaction::num_rows($vip_check) > 0)
                {

                Transaction::query("UPDATE users SET credits = credits + '100000', crystals = crystals + '40', vip = '1', rank = '2' WHERE id = '" . $userdata['id'] . "'");
                $msg = "<div class='rounded rounded-green'><center>" . $_POST['vip'] . " recebeu VIP com sucesso! <img src=\"./w/images/check.gif\"></center></div>";
                }
            else
                {

                if (Transaction::num_rows($badge_check) < 1)
                    {
                    Transaction::query("INSERT INTO user_badges (user_id,badge_id,badge_slot) VALUES ('" . $userdata['id'] . "','VIP','0')");
                    }

                Transaction::query("UPDATE users SET crystals = 'crystals' + 40; rank = '2'; vip = '1' WHERE id = '" . $userdata['id'] . "'");
                Transaction::query("INSERT INTO vip (id_user,timestamp,timestampend) VALUES ('" . $userdata['id'] . "','" . time() . "','" . $timeend2 . "')");
                Transaction::query("INSERT INTO mobbo_alerts (userid,alert) VALUES ('" . $userdata['id'] . "','Voc agora faz parte do Haboo VIP!')");


                $msg = "<div class='rounded rounded-green'><center>" . $_POST['vip'] . " Recebeu o VIP corretamente! <img src=\"./w/images/check.gif\"></center></div><br>";
                }
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>No foi possvel encontrar este usurio! <img src=\"./w/images/del.gif\"></center></div><br>";
            }
        }

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></p></strong><?php } ?>

    <form action='<?php echo $adminpath; ?>/p/viptool&do=add' method='post' name='theAdminForm' id='theAdminForm'>
        <div class='tableborder'>
            <div class='tableheaderalt'><center>Usurios VIP</center></div>

            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><strong>Nome de usurio</strong><div class='graytext'>Digite o nome do usurio que tornar VIP</div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='vip' value="<?php echo $_POST['name']; ?>" size='30' class='textinput'></td>
                </tr>

                <tr>
                <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Torn-lo VIP' class='realbutton' accesskey='s'></td></tr>
                </form></table></div><br />

        <div class='tableborder'>
            <div class='tableheaderalt'><center>Usurios VIP atualmente</center></div>
            <table cellpadding='4' cellspacing='0' width='100%'>

                <tr>
                    <td class='tablesubheader' width='20%' align='left'>Nome de usurio</td>
                    <td class='tablesubheader' width='15%' align='left'>E-mail</td>
                    <td class='tablesubheader' width='15%' align='left'>IP</td>
                    <td class='tablesubheader' width='5%' align='left'>Editar</td>
                </tr>

                <?php
                $get_vip = Transaction::query("SELECT * FROM users WHERE rank = '2' ORDER BY lastonline");
                while ($vip     = Transaction::fetch($get_vip))
                    {

                    $get_user = Transaction::query("SELECT * FROM users WHERE id = '" . $vip['id'] . "'");
                    while ($row      = Transaction::fetch($get_user))
                        {

                        if ($row['online'] >= 1)
                            {
                            $online = "online";
                            }
                        else
                            {
                            $online = "offline";
                            }
                        ?>

                        <tr>
                            <td class='tablerow1' align='left'><?php echo $row['username']; ?> (ID: <?php echo $row['id']; ?>)</td>
                            <td class='tablerow1' align='left'><?php echo $row['mail']; ?></td>
                            <td class='tablerow1' align='left'><?php echo $row['ip_last']; ?></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/users_edit&key=<?php echo $vip['id_user']; ?>'><img src='./w/images/edit.gif' alt='Edit User Data'></a>

                        </tr>

                        <?php
                        }
                    }
                ?>

            </table>
        </div>
    </div>
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
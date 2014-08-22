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

    $pagename = "Editar usurios";
    $pageid   = "users_edit";

    if (isset($_GET['username']))
        {
        $sql = Transaction::fetch($sql = Transaction::query("SELECT * FROM users WHERE username = '" . Security::textFilter($_GET['username']) . "' LIMIT 1"));
        header("location: " . $adminpath . "/p/users_edit&key=" . $sql['id'] . "");
        }

    if (isset($key))
        {
        if (is_numeric($key))
            {
            $usercheck = Transaction::query("SELECT * FROM users WHERE id = '" . Security::textFilter($key) . "' LIMIT 1");

            if (Transaction::num_rows($usercheck) > 0)
                {
                $usereditor = true;
                $userdata   = Transaction::fetch($usercheck);
                }
            else
                {
                $msg = "<div class='rounded rounded-red'><center>No foi possvel encontrar este usurio! <img src=\"./w/images/del.gif\"></center></div>";
                }
            }
        }

    if ($do == "save" && is_numeric($key))
        {

        if ($_POST['credits'])
            {

            $query = Transaction::query("SELECT * FROM users WHERE id = '" . $key . "' LIMIT 1");

            if (Transaction::num_rows($query) > 0)
                {

                $usereditor = true;
                $userdata   = Transaction::fetch($query);

                if ($user_rank < 7)
                    {
                    $working    = $userdata['working'];
                    $secretcode = $userdata['secretcode'];
                    $vip_points = $userdata['vip_points'];
                    $online     = $userdata['online'];
                    $look       = $userdata['look'];
                    $vip        = $userdata['vip'];
                    $rank       = $userdata['rank'];
                    }
                else
                    {
                    $working    = $_POST['working'];
                    $secretcode = $_POST['secretcode'];
                    $vip_points = $_POST['vip_points'];
                    $online     = $_POST['online'];
                    $look       = $_POST['look'];

                    if ($_POST['vip'] == "true")
                        {
                        $vip = "1";
                        }
                    else
                        {
                        $vip = "0";
                        }
                    }

                Transaction::query("UPDATE users SET real_name = '" . Security::textFilter($_POST['real_name']) . "', motto = '" . Security::textFilter($_POST['motto']) . "', look = '" . Security::textFilter($look) . "', gender = '" . Security::textFilter($_POST['gender']) . "', mail = '" . Security::textFilter($_POST['mail']) . "', credits = '" . Security::textFilter($_POST['credits']) . "', activity_points = '" . Security::textFilter($_POST['activity_points']) . "', birth = '" . Security::textFilter($_POST['birth']) . "', ip_last = '" . Security::textFilter($_POST['ip_last']) . "', ip_reg = '" . Security::textFilter($_POST['ip_reg']) . "', working = '" . $working . "', secretcode = '" . $secretcode . "', vip_points = '" . $vip_points . "', online = '" . $online . "', vip = '" . $vip . "' WHERE id = '" . $userdata['id'] . "'");

                $msg      = "<div class='rounded rounded-green'><center>" . $userdata['username'] . " (ID: " . $userdata['id'] . ") Alteraes salvas! <img src=\"./w/images/check.gif\"></center></div>";
                $query    = Transaction::query("SELECT * FROM users WHERE id = '" . $key . "' LIMIT 1");
                $userdata = Transaction::fetch($query);
                }
            else
                {
                $msg = "<div class='rounded rounded-red'><center>No foi possvel encontrar este usurio! <img src=\"./w/images/del.gif\"></center></div>";
                }
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Cheque todos os campos! <img src=\"./w/images/del.gif\"></center></div>";
            }
        }

    $check_bann = Transaction::query("SELECT * FROM bans WHERE value = '" . $userdata['username'] . "' AND bantype = 'user'");

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></p></strong><br><?php
        }
    if ($usereditor == "true")
        {
        ?>

        <form action='<?php echo $adminpath; ?>/p/users_edit&key=<?php echo $userdata['id']; ?>&do=save' method='post' name='theAdminForm' id='theAdminForm'>
            <input type='hidden' name='hiddenHook' value='valid'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>Editar usurio <b><?php echo $userdata['username']; ?> (ID: <?php echo $userid; ?>)</b> <?php
                        if ($userdata['online'] > 0)
                            {
                            ?><img src="<?php echo $path; ?>/web-gallery/v2/images/online.gif"><?php
                            }
                        else
                            {
                            ?><img src="<?php echo $path; ?>/web-gallery/v2/images/offline.gif"><?php } ?> // Banido: <?php
                        if (Transaction::num_rows($check_bann) > 0)
                            {
                            echo'Sim';
                            }
                        else
                            {
                            echo'No';
                            }
                        ?></center></div>

                <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Nome do usurio</b><div class='graytext'>Nome do usurio que deseja editar</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='name' value="<?php echo $userdata['username']; ?>" disabled="disabled" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Pas do usurio</b><div class='graytext'>Pas do usurio</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='real_name' value="<?php echo $userdata['real_name']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Tempo online</b><div class='graytext'>Tempo online</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'>
                            <input type='text' name='onlinetimer' value="<?php echo round($userdata_a['OnlineTime'] / 3600); ?>" disabled='disabled' size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Misso</b><div class='graytext'>Misso do usurio</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='motto' value="<?php echo $userdata['motto']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>ltima vez no Hotel</b><div class='graytext'>ltima vez no Hotel</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='last_online' value="<?php echo date('d/m/Y - H:i:s', $userdata['last_online']); ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Data de registro</b><div class='graytext'>Data em que o usurio registrou-se.</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='account_created' value="<?php echo date('d/m/Y - H:i:s', $userdata['account_created']); ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Visual</b><div class='graytext'>Visual do Usurio</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='look' value="<?php echo $userdata['look']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Genro</b><div class='graytext'>Masculino ou femenino</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><select name="gender"><option value="M">Masculino</option><option value="F" <?php
                                if ($userdata['gender'] == "F")
                                    {
                                    echo'selected="selected"';
                                    }
                                ?>>Femenino</option></select></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Email</b><div class='graytext'>Email registrado do usurio</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='mail' value="<?php echo $userdata['mail']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Moedas</b><div class='graytext'>Tanto de Moedas que o usurio possui</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='credits' value="<?php echo $userdata['credits']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Pixels</b><div class='graytext'>Tanto de Pixels que o usurio possui</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='activity_points' value="<?php echo $userdata['activity_points']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <?php
                    if ($user_rank > 6)
                        { // Entwickler  
                        ?>

                        <tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>Pontos como VIP</b><div class='graytext'>Pontos como VIP</div></td>
                            <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='vip_points' value="<?php echo $userdata['vip_points']; ?>" size='30' class='textinput'>
                            </td>
                        </tr>



                    <?php } ?>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>ltimo IP</b><div class='graytext'>ltimo IP em que o usurio logou-se no Hotel</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='ip_last' value="<?php echo $userdata['ip_last']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>IP de registro</b><div class='graytext'>IP que o usurio registrou-se no Hotel</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='ip_reg' value="<?php echo $userdata['ip_reg']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <?php
                    if ($user_rank > 4)
                        {  // Entwickler  
                        ?>


                        <tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>Status</b><div class='graytext'>Se o usurio est online ou no</div>
                            <td class='tablerow2'  width='60%'  valign='middle'><select name="online" class="dateselector"><option value="0">offline</option><option value="1"<?php
                                    if ($userdata['online'] == 1)
                                        {
                                        ?>selected="selected"<?php } ?>>Online</option></select>
                        </tr>

                        <?php
                        } if ($userdata['rank'] > 4)
                        {
                        ?>

                        <tr>
                            <td class='tablerow1'  width='40%'  valign='middle'><b>Pedidos de ajuda</b><div class='graytext'>Nmero de pedidos de ajuda feito pelo usurio</div></td>
                            <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='helper' value="<?php echo Transaction::evaluate("SELECT COUNT(*) FROM moderation_tickets WHERE moderator_id = '" . $userdata['id'] . "'"); ?>x" disabled="disabled" size='30'class='textinput'></td>
                        </tr>

                    <?php } ?>


                    <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Guardar' class='realbutton' accesskey='s'></td></tr>

                    </form>
                </table>
            </div>

            <td width='10%' valign='top' id='rightblock'>

            <center><img src="<?php
                echo $avatar;
                echo $userdata['look'];
                ?>&size=b&direction=2&action=wlk,wav,&head_direction=3&gesture=sml"></center>

            <div class='tableborder'>
                <div class='tableheaderalt'><center>Emblemas (<?php echo Transaction::evaluate("SELECT COUNT(*) FROM user_badges WHERE user_id = '" . $key . "'"); ?>) </div>

                <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

                    <tr>
                        <td class='tablesubheader' width='1%' align='center'>Cdigo</td>
                        <td class='tablesubheader' width='14%' align='center'>Emblema</td>
                    </tr>

                    <?php
                    $sql = Transaction::query("SELECT * FROM user_badges WHERE user_id = '" . $key . "' ORDER BY badge_id");
                    while ($row = Transaction::fetch($sql))
                        {
                        ?>

                        <tr>
                            <td class='tablerow1' align='center'><?php echo $row['badge_id']; ?></td>
                            <td class='tablerow2'><img src="<?php echo $cimagesurl . $badgesurl . $row['badge_id']; ?>.gif"></div></td>
                        </tr>

                    <?php } ?>

                    </form>
                </table>
                <div><div>

                        <?php
                        }
                    else
                        {
                        ?>

                        <form action='<?php echo $adminpath; ?>/p/users_edit' method='post' name='theAdminForm' id='theAdminForm'>
                            <div class='tableborder'>
                                <div class='tableheaderalt'><center>Editar</center></div>

                                <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                                    <tr>
                                        <td class='tablerow1'  width='40%'  valign='middle'><b>Nome de usurio</b><div class='graytext'>Nome de usurio que deseja editar</div></td>
                                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='searchname' value="<?php echo $_POST['query']; ?>" size='30' class='textinput'></td>
                                    </tr>

                                    <tr>
                                        <td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Salvar' class='realbutton' accesskey='s'></td>
                                    </tr>

                                    </form>
                                </table>
                            </div>

                        <?php } ?>

                </div>
                </td></tr>
                </table>
            </div>

            <?php
            require_once('footer.php');
            }
        else
            {
            require_once('error.php');
            exit;
            }
        ?>
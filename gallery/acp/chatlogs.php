<?php
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

    $pagename = "Chatlogs";
    $pageid   = "chatlogs";

    if (isset($_POST['query']))
        {

        $limit = $_POST['limit'];

        if ($_POST['type'] == "user_id")
            {

            $userdata = Transaction::query("SELECT * FROM users WHERE username = '" . $_POST['query'] . "'");
            if (Transaction::num_rows($userdata) > 0)
                {

                $userdata = Transaction::fetch($userdata);
                $get_logs = Transaction::query("SELECT * FROM chatlogs WHERE user_id = '" . $userdata['id'] . "' ORDER BY timestamp DESC LIMIT " . $limit . "");
                $results  = Transaction::num_rows($get_logs);

                if ($results > 0)
                    {

                    $chatlogs = Transaction::fetch($get_logs);

                    $msg = "<div class='rounded rounded-green'><center>Reegistros de <u>" . $_POST['query'] . " (ID: " . $userdata['id'] . ")</u> <img src=\"./w/images/check.gif\"></center></div>";
                    }
                else
                    {
                    $msg = "<div class='rounded rounded-red'><center>Ops, nenhuma conversa foi registrada.<img src=\"./w/images/del.gif\"></center></div>";
                    }
                }
            else
                {
                $msg = "<div class='rounded rounded-red'><center>Este usuário não possui nenhuma conversa registrada <img src=\"./w/images/del.gif\"></center></div>";
                }
            }
        else
            {

            $get_logs = Transaction::query("SELECT * FROM chatlogs WHERE room_id = '" . $_POST['query'] . "' ORDER BY timestamp LIMIT " . $limit . "");
            $results  = Transaction::num_rows($get_logs);

            if ($results > 0)
                {

                $chatlogs = Transaction::fetch($get_logs);
                $roomdata = Transaction::query("SELECT * FROM rooms WHERE id = '" . $_POST['query'] . "'");
                $data     = Transaction::fetch($roomdata);

                $msg = "<div class='rounded rounded-green'><center>Conversas do quarto: <u>" . $data['caption'] . " (ID: " . $data['id'] . ")</u> <img src=\"./w/images/check.gif\"></center></div>";
                }
            else
                {
                $msg = "<div class='rounded rounded-red'><center>Conversa não encontrada. <img src=\"./w/images/del.gif\"></center></div>";
                }
            }
        }

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></p></strong><?php } ?>

    <form action='<?php echo $adminpath; ?>/p/chatlogs&do=search' method='post' name='theAdminForm' id='theAdminForm'>
        <div class='tableborder'>
            <div class='tableheaderalt'>Lista de Conversas</div>

            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><strong>Nome de usuario ou ID do quarto</strong><div class='graytext'>Se quer buscar um quarto/nome de usuario, digite o nome aqui</div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='query' value="<?php echo $_POST['query']; ?>" size='35' class='textinput'></td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><strong>Tipo</strong></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><select name="type">
                            <option value='room_id'>ID do quarto</option>
                            <option value="user_id"<?php
                            if ($_POST['type'] == "user_id")
                                {
                                ?> selected="selected"<?php } ?>>Nome de usuario</option></select></td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><strong>Limite</strong><div class='graytext'>Quantas conversas quer ver? <font color="red"><br>Mostra o tanto de conversas</font></td>
                            <td class='tablerow2'  width='60%'  valign='middle'><select name="limit">
                                    <option value='10'>10</option>
                                    <option value='25'>25</option>
                                    <option value='50'>50</option>
                                    <option value='75'>75</option>
                                    <option value='100'>100</option>
                                    <option value='150'>150</option>
                                    <option value='200'>200</option>
                                    <option value='300'>300</option>
                                    <option value='400'>400</option>
                                    <option value='500'>500</option>
                                    <option value='1000'>1000</option>
                                </select></td>
                </tr>

                <tr>
                    <td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Procurar' class='realbutton' accesskey='s'></td></tr>
                </form></table></div><br />

        <?php
        if ($results > 0 && $_POST['type'] == "user_id")
            {
            ?>

            <div class='tableborder'>
                <div class='tableheaderalt'><center>Chatlog do usuário <?php echo $userdata['username']; ?> | Limite <?php echo $limit; ?></center></div>
                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='1%' align='center'>Usuario</td>
                        <td class='tablesubheader' width='20%' align='center'>Quarto</td>
                        <td class='tablesubheader' width='21%' align='center'>Data</td>
                        <td class='tablesubheader' width='59%' align='center'>Conversa</td>
                    </tr>
                    <?php
                    $logs    = Transaction::query("SELECT * FROM chatlogs WHERE user_id = '" . $userdata['id'] . "' ORDER BY timestamp DESC LIMIT " . $limit . "");
                    while ($rowlogs = Transaction::fetch($logs))
                        {

                        $get_room = Transaction::query("SELECT * FROM rooms WHERE id = '" . $rowlogs['room_id'] . "'");
                        $rooms    = Transaction::fetch($get_room);
                        ?>

                        <tr>
                            <td class='tablerow1'><?php echo $userdata['username']; ?></td>
                            <td class='tablerow2'><?php echo $rooms['caption']; ?> (ID: <?php echo $rowlogs['room_id']; ?>)</td>
                            <td class='tablerow2''><?php echo date('d/m/Y - H:i:s', $rowlogs['timestamp']); ?></td>
                            <td class='tablerow2'><?php echo Security::textFilter($rowlogs['message']); ?></td>
                        </tr>

                        <?php
                        }
                    }
                elseif ($results > 0 && $_POST['type'] == "room_id")
                    {
                    ?>


                    <div class='tableborder'>
                        <div class='tableheaderalt'><center>Conversas do quarto: <?php echo $roomdata['caption']; ?> | Limite <?php echo $limit; ?></center></div>
                        <table cellpadding='4' cellspacing='0' width='100%'>
                            <tr>
                                <td class='tablesubheader' width='1%' align='center'>Usuario</td>
                                <td class='tablesubheader' width='20%' align='center'>Quarto</td>
                                <td class='tablesubheader' width='21%' align='center'>Data</td>
                                <td class='tablesubheader' width='59%' align='center'>Conversa</td>
                            </tr>
                            <?php
                            $logs    = Transaction::query("SELECT * FROM chatlogs WHERE room_id = '" . $_POST['query'] . "' ORDER BY timestamp DESC LIMIT " . $limit . "");
                            while ($rowlogs = Transaction::fetch($logs))
                                {

                                $get_user = Transaction::query("SELECT * FROM users WHERE id = '" . $rowlogs['user_id'] . "'");
                                $users    = Transaction::fetch($get_user);

                                $get_room = Transaction::query("SELECT * FROM rooms WHERE id = '" . $rowlogs['room_id'] . "'");
                                $rooms    = Transaction::fetch($get_room);
                                ?>

                                <tr>
                                    <td class='tablerow1'><?php echo $users['username']; ?></td>
                                    <td class='tablerow2'><?php echo $rooms['caption']; ?> (ID: <?php echo $rowlogs['room_id']; ?>)</td>
                                    <td class='tablerow2''><?php echo date('d.m.Y - H:i:s', $rowlogs['timestamp']); ?> Uhr</td>
                                    <td class='tablerow2'><?php echo Security::textFilter($rowlogs['message']); ?></td>
                                </tr>

                                <?php
                                }
                            }
                        ?>

                    </table>
                </div>
        </div>

        <!-- / RIGHT CONTENT BLOCK -->
    </td>
    </tr>
    </table>
    </div>

    <!-- / OUTERDIV -->
    <?php
    require_once('footer.php');
    }
else
    {
    require_once('error.php');
    exit;
    }
?>
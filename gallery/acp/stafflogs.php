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

    if ($do == "cleanlogs")
        {
        Transaction::query("TRUNCATE TABLE stafflogs");
        Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Staff Logs wurde geleert','logs.php','" . $my_id . "','','" . $date_full . "')");
        }

    $pagename = "Dados da Equipe";
    $pageid   = "stafflogs";

    @include('subheader.php');
    ?>

    <div class='tableborder'>
        <div class='tableheaderalt'><center>Dados Salvos da Equipe</center></div>
        <table cellpadding='4' cellspacing='0' width='100%'>

            <?php
            if ($do == "reading" && is_numeric($key))
                {

                $get_details = Transaction::query("SELECT * FROM stafflogs WHERE id = '" . $key . "' && details IS NOT NULL");
                if (Transaction::num_rows($get_details) > 0)
                    {
                    ?>

                    <tr>
                        <td class='tablesubheader' width='20%' align='left'>Usuário</td>
                        <td class='tablesubheader' width='80%' align='left'>Detalhes</td>
                    </tr>

                    <?php
                    $details = Transaction::fetch($get_details);
                    $user    = Transaction::query("SELECT * FROM users WHERE id = '" . $details['targetid'] . "'");
                    $user    = Transaction::fetch($user);
                    ?>

                    <tr>
                        <td class='tablerow1' align='left'><?php echo $user['name']; ?> (ID: <?php echo $user['id']; ?>)</td>
                        <td class='tablerow2' align='left'><?php echo $details['details']; ?></td>
                    </tr>

                    <?php
                    }
                else
                    {
                    echo"<p><strong><div class='rounded rounded-red'><center><b>Error</b></center></div></p>";
                    }
                }
            else
                {
                ?>

                <tr>
                    <td class='tablesubheader' width='5%' align='left'>Site</td>
                    <td class='tablesubheader' width='15%' align='left'>Staff</td>
                    <td class='tablesubheader' width='15%' align='left'>Usuario</td>
                    <td class='tablesubheader' width='20%'>Detalhe</td>
                    <td class='tablesubheader' width='20%'>Dados</td>
                    <td class='tablesubheader' width='20%' align='left'>Data</td>
                </tr>
                <?php
                $get_users = Transaction::query("SELECT * FROM stafflogs ORDER BY id DESC");
                while ($row       = Transaction::fetch($get_users))
                    {
                    ?>

                    <script language="JavaScript" type="text/javascript">
                        function openWin () {
                            var newWin = window.open ('', '', 'height=330, width=560');
                            newWin.document.close ();
                        }
                    </script>

                    <?php
                    $userdata = Transaction::query("SELECT * FROM users WHERE id = '" . $row['userid'] . "' LIMIT 1");
                    $userdata = Transaction::fetch($userdata);

                    if (!empty($row['targetid']))
                        {
                        $targetdata = Transaction::query("SELECT * FROM users WHERE id = '" . $row['targetid'] . "' LIMIT 1");
                        $targetdata = Transaction::fetch($targetdata);
                        }
                    else
                        {
                        $targetdata['username'] = "-/-";
                        }

                    if (!empty($row['note']))
                        {
                        $note = $row['note'];
                        }
                    else
                        {
                        $note = "<i>None given</i>";
                        }
                    ?>

                    <tr>
                        <td class='tablerow1' align='left'><?php echo $row['action']; ?></td>
                        <td class='tablerow2' align='left'><?php echo $userdata['username'] ?> (ID: <?php echo $row['userid']; ?>)</td>
                        <td class='tablerow2' align='left'><?php
                            echo $targetdata['username'];
                            if (!empty($row['targetid']))
                                {
                                echo" (ID: " . $row['targetid'] . ")";
                                }
                            ?></td>
                        <td class='tablerow2'><?php echo $row['message']; ?> <?php
                            if ($note == "users_edit.php")
                                {
                                ?> <a href="<?php echo $adminpath; ?>/p/stafflogs&do=reading&key=<?php echo $row['id']; ?>" target="2941aeb24b02737dbd8720de2ebc95e8e240c39b" onclick="HabboClient.openOrFocus (this);
                                                return false;">[DETAILS]</a><?php } ?></td>
                        <td class='tablerow2'><?php echo $note; ?></td>
                        <td class='tablerow2' align='left'><?php echo $row['timestamp']; ?></td>
                    </tr>

                <?php } ?>

            </table>
        </div>
        <br />

        </div>
    <?php } ?>

    <!-- / RIGHT CONTENT BLOCK -->
    </td></tr>
    </table>
    </div><!-- / OUTERDIV -->

    <?php
    require_once('footer.php');
    }
else
    {
    include('error.php');
    exit;
    }
?>
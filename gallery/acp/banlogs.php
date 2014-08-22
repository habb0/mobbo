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

    $pagename = "Lista de usurios banidos";
    $pageid   = "banlogs";

    $page = Security::textFilter($_GET['page']);
    $do   = Security::textFilter($_GET['do']);

    $posts = Transaction::evaluate("SELECT COUNT(*) FROM bans");
    $pages = ceil(($posts + 0) / 50);

    if ($page > $pages || $page < 1)
        {
        $page = 1;
        }

    @include('subheader.php');
    ?>
    <div class='tableborder'>
        <div class='tableheaderalt'><center>Nmero de pessoas banidas:  <?php echo Transaction::evaluate("SELECT COUNT(*) FROM bans"); ?> | <?php echo Transaction::evaluate("SELECT COUNT(*) FROM bans WHERE bantype = 'user'"); ?> Usurios banidos por ID | <?php echo Transaction::evaluate("SELECT COUNT(*) FROM bans WHERE bantype = 'ip'"); ?> Usurios banidos por IP<br><br> Pgina:
                <?php
                for ($i = 1; $i <= $pages; $i++)
                    {
                    if ($page == $i)
                        {
                        echo"<blink><b><font color=\"#000000\">" . $i . "</font></b></blink>\n";
                        }
                    else
                        {
                        echo"<a href=\"./index.php?p=banlogs&page=" . $i . "\"><font color=\"#FFFFFF\">" . $i . "</a></font>\n ";
                        }
                    }
                ?></div>
                <table cellpadding='4' cellspacing='0' width='100%'>

                    <tr>
                        <td class='tablesubheader' width='1%' align='left'>ID</td>
                        <td class='tablesubheader' width='8%' align='left'>Estado</td>
                        <td class='tablesubheader' width='10%'>Valor</td> 
                        <td class='tablesubheader' width='10%'>Razo</td>
                        <td class='tablesubheader' width='10%' align='left'>Banido</td>
                        <td class='tablesubheader' width='10%' align='left'>IP</td>
                        <td class='tablesubheader' width='10%' align='left'>Desde</td>
                        <td class='tablesubheader' width='10%' align='left'>Acaba</td>
                        <td class='tablesubheader' width='1%' align='left'>IP Banido</td>
                    </tr>

                    <?php
                    $query_min = ($page * 50) - 50;

                    if ($query_min < 0)
                        { // Page 1
                        $query_min = 0;
                        }

                    $get_bans = Transaction::query("SELECT * FROM bans WHERE expire + 3600 > '" . time() . "' ORDER BY expire LIMIT " . $query_min . ", 50");
                    while ($row      = Transaction::fetch($get_bans))
                        {

                        if ($row['bantype'] == 'user')
                            {

                            $userdata = Transaction::query("SELECT * FROM users WHERE username = '" . $row['value'] . "'");
                            $users    = Transaction::fetch($userdata);

                            $ip_last = $users['ip_last'];
                            }
                        else
                            {
                            $ip_last = '-/-';
                            }

                        $minuten = $row['expire'] - time();

                        if (time() >= $row['expire'])
                            {
                            $stat  = "Expira em";
                            $color = "green";
                            }
                        elseif (time() + 3600 >= $row['expire'])
                            {
                            if (date('i', $minuten) > 0)
                                {
                                $stat  = "(H " . date('i', $minuten) . " minutos)";
                                $color = "orange";
                                }
                            else
                                {
                                $stat  = "(H " . date('s', $minuten) . " segundos)";
                                $color = "orange";
                                }
                            }
                        else
                            {
                            $stat  = "Ativado";
                            $color = "red";
                            }

                        if ($row['bantype'] == 'user')
                            {
                            $img = "del";
                            }
                        else
                            {
                            $img = "check";
                            }
                        ?>

                        <tr>
                            <td class='tablerow1' align='left'><?php echo $row['id']; ?></td>
                            <td class='tablerow1' align='left'><font color="<?php echo $color; ?>"><?php echo $stat; ?></font></td>
                            <td class='tablerow1' align='left'><font color="<?php echo $color; ?>"><?php echo $row['value']; ?></font></td>
                            <td class='tablerow1' align='left'><font color="<?php echo $color; ?>"><?php echo $row['reason']; ?></font></td>
                            <td class='tablerow1' align='left'><font color="<?php echo $color; ?>"><?php echo $row['added_by']; ?></font></td>
                            <td class='tablerow1' align='left'><font color="<?php echo $color; ?>"><?php echo $ip_last; ?></font></td>
                            <td class='tablerow1' align='left'><font color="<?php echo $color; ?>"><?php echo date('d/m/Y - H:i:s', $row['added_date']); ?></font></td>
                            <td class='tablerow1' align='left'><font color="<?php echo $color; ?>"><?php echo date('d/m/Y - H:i:s', $row['expire']); ?></font></td>
                            <td class='tablerow1' align='left'><center><img src="<?php echo $path; ?>/w/images/<?php echo $img; ?>.gif"></center></td>
                        </tr>

                    <?php } ?>

                </table>
        </div>
    </div><!-- / RIGHT CONTENT BLOCK -->
    </td></tr>
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
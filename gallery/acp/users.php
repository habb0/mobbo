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

    $pagename = "Usurios do Hotel";
    $pageid   = "users";

    $posts = Transaction::evaluate("SELECT COUNT(*) FROM USERS");
    $pages = ceil(($posts + 0) / 50);

    if ($page > $pages || $page < 1)
        {
        $page = 1;
        }

    if ($_POST['site'])
        {
        header("location: " . $adminpath . "/p/users&page=" . $_POST['page'] . "");
        }

    if ($_POST['site2'])
        {
        header("location: " . $adminpath . "/p/users&page=" . $_POST['page2'] . "");
        }

    $users_today     = Transaction::evaluate("SELECT COUNT(*) FROM users WHERE account_created > '" . strtotime("today") . "'");
    $users_yesterday = Transaction::evaluate("SELECT COUNT(*) FROM users WHERE account_created > '" . strtotime("yesterday") . "' && account_created < '" . strtotime("today") . "'");

    $zwischenround = round(100 / $users_yesterday * $users_today);

    if ($users_today < $users_yesterday)
        {
        $rounded = 100 - $zwischenround;
        }
    else
        {
        $rounded = $zwischenround - 100;
        }

    if ($users_today < $users_yesterday)
        {
        $icon  = "-";
        $color = "red";
        }
    elseif ($users_today == $users_yesterday)
        {
        $icon  = "+-";
        $color = "gray";
        }
    else
        {
        $icon  = "+";
        $color = "green";
        }

    $header = "" . Transaction::evaluate("SELECT COUNT(*) FROM users") . " Usuarios registrados</div><center>Registrados - (Hoje): " . $users_today . " | (Ontem): " . $users_yesterday . " = <font color=\"" . $color . "\">" . $icon . "" . $rounded . "%</font>";
    @include('subheader.php');
    ?>

    <form action='<?php echo $adminpath; ?>/p/users&do=save' method='post' name='theAdminForm' id='theAdminForm'>
        <div class='tableborder'>
            <div class='tableheaderalt'><div style="float: left"><?php echo $header; ?>

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
                            ?>><?php echo $i; ?></option>
                                <?php } ?>
                    </select>

                    <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site" value="M&aacute;s ">
                </div>

                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='1%' align='center'>ID</td>
                        <td class='tablesubheader' width='5%'>Nome</td>
                        <td class='tablesubheader' width='5%'>ltimo IP</td>	
                        <td class='tablesubheader' width='5%'>IP de registro</td>
                        <td class='tablesubheader' width='8%'>Data de registro</td>
                        <td class='tablesubheader' width='10%'>ltima visita ao Hotel</td>
                        <td class='tablesubheader' width='1%'>Status</td>
                        <td class='tablesubheader' width='1%'>Editar</td>
                    </tr>

                    <?php
                    $query_min = ($page * 50) - 50;

                    if ($query_min < 0)
                        {
                        $query_min = 0;
                        }

                    $get_users = Transaction::query("SELECT * FROM users ORDER BY id ASC LIMIT " . $query_min . ", 50");
                    while ($row       = Transaction::fetch($get_users))
                        {

                        if ($row['online'] == '0')
                            {
                            $status = 'offline';
                            }
                        else
                            {
                            $status = 'online';
                            }
                        ?>

                        <tr>
                            <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                            <td class='tablerow2'><strong><?php echo $row['username']; ?></strong></td>
                            <td class='tablerow2' align='left'><?php echo $row['ip_last']; ?>  [<a href='http://who.is/whois-ip/ip-address/<?php echo $row['ip_last']; ?>/' target='_blank'>WHOIS</a>]</td>
                            <td class='tablerow2' align='left'><?php echo $row['ip_reg']; ?>  [<a href='http://who.is/whois-ip/ip-address/<?php echo $row['ip_reg']; ?>/' target='_blank'>WHOIS</a>]</td>  
                            <td class='tablerow2' align='left'><?php echo date('d/m/Y', $row['account_created']); ?></td>
                            <td class='tablerow2' align='left'><?php echo $row['last_online']; ?></td>
                            <td class='tablerow1' align='center'><img src="<?php echo $path; ?>/web-gallery/v2/images/<?php echo $status; ?>.gif"></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/users_edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Editar usuarios'></a></td>
                        </tr>

                    <?php } ?>
                </table>

                <div class='tableborder'>
                    <div class='tableheaderalt'><div style="float: left"><?php echo $header; ?>

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

                            <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site2" value="Mais ">
                        </div>

                    </div>
                </div>

                </table></div></div></div></div>

    <?php
    require_once('footer.php');
    }
else
    {
    require_once('error.php');
    exit;
    }
?>
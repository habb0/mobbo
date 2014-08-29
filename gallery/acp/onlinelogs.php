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

    $pagename = "Pessoas online";
    $pageid   = "onlinelogs";

    $onlineCutOff = (time() - 601);

    $server        = Transaction::fetch($server_status = Transaction::query("SELECT * FROM server_status"));
    $onlineUsers   = $server['users_online'];

    @include('subheader.php');
    ?>
    <div class='tableborder'>
        <div class='tableheaderalt'> <center>Pessoas online (<?php echo $onlineUsers; ?>)</center> </div>
        <table cellpadding='4' cellspacing='0' width='100%'>
            <tr>
                <td class='tablesubheader' width='1%' align='center'>ID</td>
                <td class='tablesubheader' width='15%'>Nome de usurio</td>
                <td class='tablesubheader' width='18%' align='left'>E-mail</td>
                <td class='tablesubheader' width='10%' align='left'>Data de registro</td>
                <td class='tablesubheader' width='10%' align='left'>&Uacute;ltima vez conectado</td>
                <td class='tablesubheader' width='1%' align='left'>Editar</td>
            </tr>
            <?php
            $get_users = Transaction::query("SELECT * FROM users WHERE online > '0' ORDER BY username LIMIT " . $onlineUsers);
            while ($row       = Transaction::fetch($get_users))
                {
                ?>

                <tr>
                    <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                    <td class='tablerow2'><strong><?php echo $row['username']; ?> </strong><div class='desctext'><?php echo $row['ip_last']; ?> [<a href='http://who.is/whois-ip/ip-address/<?php echo $row['ip_last']; ?>/' target='_blank'>WHOIS</a>]</div></td>
                    <td class='tablerow2' align='left'><a href='mailto:<?php echo $row['mail']; ?>'><?php echo $row['mail']; ?></a></td>
                    <td class='tablerow2' align='left'><?php echo date('d/m/Y - H:i:s', $row['account_created']); ?></td>
                    <td class='tablerow2' align='left'><?php echo date('d/m/Y - H:i:s', $row['last_online']); ?></td>
                    <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/users_edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Edit User Data'></a></td>
                </tr>

            <?php } ?>

        </table>
    </div>
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
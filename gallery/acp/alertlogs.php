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

    $pagename = "Alertas Activas";
    $pageid   = "alertlogs";

    @include('subheader.php');
    ?>

    <div class='tableborder'>
        <div class='tableheaderalt'>Alertas Activas</div>
        <table cellpadding='4' cellspacing='0' width='100%'>
            <tr>
                <td class='tablesubheader' width='1%' align='center'>ID</td>
                <td class='tablesubheader' width='20%' align='left'><?php echo $shortname; ?> Nombre</td>
                <td class='tablesubheader' width='50%' align='left'>Alerta</td>
            </tr>

            <?php
            $get_em = Transaction::query("SELECT * FROM mobbo_alerts ORDER BY id DESC");
            while ($row    = Transaction::fetch($get_em))
                {

                $check = Transaction::query("SELECT * FROM users WHERE id = '" . $row['userid'] . "' LIMIT 1");
                $user  = Transaction::fetch($check);
                ?>

                <tr>
                    <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                    <td class='tablerow1' align='left'><?php echo $user['username']; ?> (ID: <?php echo $row['id']; ?>)</td>
                    <td class='tablerow1' align='left'><?php echo Security::textFilterHK($row['alert']); ?></td>
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
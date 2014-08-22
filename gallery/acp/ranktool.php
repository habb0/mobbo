<?php
session_start();
if ($user_rank > 7)
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

    $pagename = "Cargos administrativos";
    $pageid   = "ranktool";

    if (isset($_POST['rank']))
        {

        $check = Transaction::query("SELECT * FROM users WHERE username = '" . $_POST['name'] . "' LIMIT 1");
        $row   = Transaction::fetch($check);

        if ($row['rank'] !== '5')
            {
            if (Transaction::num_rows($check) > 0)
                {
                Transaction::query("UPDATE users SET rank = '" . $_POST['rank'] . "' WHERE username = '" . $_POST['name'] . "' LIMIT 1");
                $msg = "<div class='rounded rounded-green'><center>Rank de " . $_POST['name'] . " atualizado com sucesso! <img src=\"./w/images/check.gif\"></center></div>";
                }
            else
                {
                $msg = "<div class='rounded rounded-red'><center>No foi possvel encontrar o usurio <img src=\"./w/images/del.gif\"></center></div>";
                }
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>No  possvel alterar este cargo <img src=\"./w/images/del.gif\"></center></div>";
            }
        }

    $get_rank  = Transaction::query("SELECT * FROM ranks ORDER BY ID");
    $get_users = Transaction::query("SELECT * FROM users WHERE rank > 3 ORDER BY rank DESC");

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></p></strong><?php } ?>

    <form action='<?php echo $adminpath; ?>/p/ranktool' method='post' name='theAdminForm' id='theAdminForm'>
        <input type="hidden" value="<?= md5(session_id()); ?>" name="csrf">
        <div class='tableborder'>
            <div class='tableheaderalt'><center>Editar Cargos</center></div>

            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><strong>Nome do usurio</strong><div class='graytext'>Nome do usurio que deseja dar cargo</div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='name' value="<?php echo Security::textFilter($_POST['name']); ?>" size='30' class='textinput'></td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><strong>Cargo</strong><div class='graytext'>Cargo a dar ao usurio</div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><select name='rank'  class='dropdown' size='1'><?php
                            while ($rank = Transaction::fetch($get_rank))
                                {
                                ?>
                                <option value='<?php echo $rank['id']; ?>'><?php echo $rank['name']; ?></option><?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Salvar' class='realbutton' accesskey='s'></td></tr>
                </form></table></div><br />

        <div class='tableborder'>
            <div class='tableheaderalt'><center>Equipe staff</center></div>
            <table cellpadding='4' cellspacing='0' width='100%'>
                <tr>
                    <td class='tablesubheader' width='20%'>Nome</td>
                    <td class='tablesubheader' width='30%'>Email</td>
                    <td class='tablesubheader' width='20%'>IP</td>
                    <td class='tablesubheader' width='20%'>Cargo</td>
                    <td class='tablesubheader' width='1%' align='center'>Editar</td>
                </tr>
                <?php
                while ($row = Transaction::fetch($get_users))
                    {
                    $rank = Transaction::query("SELECT * FROM ranks WHERE id = '" . $row['rank'] . "' ");
                    $rank = Transaction::fetch($rank);
                    ?>
                    <tr>
                        <td class='tablerow1' align='left'><?php echo $row['username']; ?> (ID: <?php echo $row['id']; ?>)</td>
                        <td class='tablerow1' align='left'><?php echo $row['mail']; ?></td>
                        <td class='tablerow1' align='left'><?php echo $row['ip_last']; ?></td>
                        <td class='tablerow2'><?php echo $rank['name']; ?></td>
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
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

    $pagename = "Configuraes";

    if ($do == "save")
        {
        if ($_POST['url'])
            {

            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Alterou as configuraes do Hotel','settings.php','" . $my_id . "','0','" . $date_full . "')");
            Transaction::query("UPDATE mobbo_settings SET valuer = '" . $_POST['url'] . "' WHERE variabler = 'hotel_url'");
            Transaction::query("UPDATE mobbo_settings SET valuer = '" . $_POST['mobbo_name'] . "' WHERE variabler = 'hotel_name'");
            Transaction::query("UPDATE mobbo_settings SET valuer = '" . $_POST['maintenance'] . "' WHERE variabler = 'maintenance'");
			Transaction::query("UPDATE mobbo_settings SET valuer = '" . $_POST['mobbo_maintenancet'] . "' WHERE variabler = 'maintenance_text'");
			Transaction::query("UPDATE mobbo_settings SET valuer = '" . $_POST['mobbo_ticket'] . "' WHERE variabler = 'mobbo_ticket'");

            $msg = "<div class='rounded rounded-green'><center>Alteraes salvas com sucesso <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>No foi possvel salvar as alteraes <img src=\"./w/images/del.gif\"></center></div>";
            }
        }

    $mobbo_url         = Transaction::fetch($mobbo_url         = Transaction::query("SELECT * FROM mobbo_settings WHERE variabler = 'hotel_url'"));
    $mobbo_name        = Transaction::fetch($mobbo_name        = Transaction::query("SELECT * FROM mobbo_settings WHERE variabler = 'hotel_name'"));
    $mobbo_maintenance = Transaction::fetch($mobbo_maintenance = Transaction::query("SELECT * FROM mobbo_settings WHERE variabler = 'maintenance'"));
	$mobbo_maintenancet= Transaction::fetch($mobbo_maintenancet= Transaction::query("SELECT * FROM mobbo_settings WHERE variabler = 'maintenance_text'"));
	$mobbo_ticket      = Transaction::fetch($mobbo_ticket      = Transaction::query("SELECT * FROM mobbo_settings WHERE variabler = 'hotel_ticket'"));

    $pageid = "settings";

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></strong></p><?php } ?>

    <form action='<?php echo $adminpath; ?>/p/settings&do=save' method='post' name='theAdminForm' id='theAdminForm'>
        <div class='tableborder'>
            <div class='tableheaderalt'>Configuraes do site</div>

            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><b>URL do Hotel</b><div class='graytext'><?php echo $mobbo_url['description']; ?></div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='url' value="<?php echo $mobbo_url['valuer']; ?>" size='30' class='textinput'></td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><b>Nome do hotel</b><div class='graytext'><?php echo $mobbo_name['description']; ?></div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='mobbo_name' value="<?php echo $mobbo_name['valuer']; ?>" size='30' class='textinput'></td>
                </tr>
				
				<tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><b>Ticket do Hotel</b><div class='graytext'><?php echo $mobbo_ticket['description']; ?></div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='mobbo_ticket' value="<?php echo $mobbo_ticket['valuer']; ?>" size='30' class='textinput'></td>
                </tr>
				
				<tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><b>Texto Manutencao</b><div class='graytext'><?php echo $mobbo_maintenancet['description']; ?></div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='mobbo_maintenancet' value="<?php echo $mobbo_maintenancet['valuer']; ?>" size='30' class='textinput'></td>
                </tr>
                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><b>Manutencao</b><div class='graytext'><?php echo $mobbo_maintenance['description']; ?></div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><select name='maintenance'  class='dropdown'>
                            <option value='1'>Sim</option>
                            <option value='0' <?php
                            if ($mobbo_maintenance['valuer'] == "0")
                                {
                                echo "selected='selected'";
                                }
                            ?>>No</option>
                        </select>
                    </td>
                </tr>

                <tr>
                <tr>
                    <td align='center' class='tablesubheader' colspan='2' >
                        <input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Salvar alteraes' class='realbutton' accesskey='s'>
                    </td>
                </tr>

                </form></table></div><br />	 </div><!-- / RIGHT CONTENT BLOCK -->
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
<?php
/* Security Proof */
$included_files = 2345;
$included_files = get_included_files();
if (!in_array($_SERVER['DOCUMENT_ROOT'] . '\CORE.php', $included_files))
    die();

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

    $pagename = "Banimentos";
    $pageid   = "ban";

    if (isset($_POST['value']) && ($_POST['length']) && ($_POST['reason']))
        {

        $check_exists = Transaction::query("SELECT * FROM bans WHERE value = '" . Security::textFilter($_POST['value']) . "' AND bantype = '" . Security::textFilter($_POST['type']) . "'");

        $get_cc   = Transaction::query("SELECT * FROM users WHERE username = '" . $_POST['value'] . "'");
        $userdata = Transaction::fetch($get_cc);

        if (Transaction::num_rows($check_exists) > 0)
            {
            Transaction::query("UPDATE bans SET expire = expire + '" . Security::textFilter($_POST['length']) . "' WHERE value = '" . Security::textFilter($_POST['value']) . "' AND bantype = '" . Security::textFilter($_POST['type']) . "'");
            $msg = "<div class='rounded rounded-green'><center>El ban (" . Security::textFilter($_POST['type']) . " - " . Security::textFilter($_POST['value']) . ") ha sido actualizado. <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {


            if (Transaction::num_rows($get_cc) > 0 && $_POST['type'] == "user")
                {
                Transaction::query("INSERT INTO bans (bantype,value,reason,expire,added_by,added_date) VALUES ('" . Security::textFilter($_POST['type']) . "','" . Security::textFilter($_POST['value']) . "','" . Security::textFilter($_POST['reason']) . "','" . time() . "' + '" . Security::textFilter($_POST['length']) . "','" . $name . "','" . time() . "')");
                Transaction::query("UPDATE users SET auth_ticket = '' WHERE username = '" . Security::textFilter($_POST['value']) . "' LIMIT 1");
                $msg = "<div class='rounded rounded-green'><center>" . $_POST['value'] . " foi banido <img src=\"./w/images/check.gif\"></center></div>";
                }
            elseif (Transaction::num_rows($get_cc) < 1 && $_POST['type'] == "user")
                {
                $msg = "<div class='rounded rounded-red'><center>No foi possvel encontrar o usurio <img src=\"./w/images/del.gif\"></center></div>";
                }
            elseif ($_POST['type'] == "ip")
                {
                Transaction::query("INSERT INTO bans (bantype,value,reason,expire,added_by,added_date) VALUES ('" . Security::textFilter($_POST['type']) . "','" . Security::textFilter($_POST['value']) . "','" . Security::textFilter($_POST['reason']) . "','" . time() . "' + '" . Security::textFilter($_POST['length']) . "','" . $name . "','" . time() . "')");
                Transaction::query("UPDATE users SET auth_ticket = '' WHERE username = '" . Security::textFilter($_POST['value']) . "' LIMIT 1");
                $msg = "<div class='rounded rounded-green'><center>O IP " . Security::textFilter($_POST['value']) . " foi banido! <img src=\"./w/images/check.gif\"></center></div>";
                }
            }
        }

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></strong></p><?php } ?>

    <form action='<?php echo $adminpath; ?>/p/ban&do=banthebastard' method='post' name='theAdminForm' id='theAdminForm'>
        <div class='tableborder'>
            <div class='tableheaderalt'><center>Banir usurio</center></div>

            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

                <td class='tablerow1'  width='30%'  valign='middle'><b>Nome de usurio</b></td>
                <td class='tablerow2'  width='70%'  valign='middle'><input type='text' name='value' value="<?php echo $_POST['value']; ?>" size='50' class='textinput'></td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='30%'  valign='middle'><b>Razo</b></td>
                    <td class='tablerow2'  width='70%'  valign='middle'><input type='text' name='reason' value="<?php echo $_POST['reason']; ?>" size='50' class='textinput'></td>
                </tr>

                <script type="text/javascript">
                    function banPreset (val)
                    {
                        document.getElementById ('banlength').value = val;
                    }
                </script>


                <tr>
                    <td class='tablerow1'  width='30%'  valign='middle'><b>Durao</b></td>
                    <td class='tablerow2'  width='70%'  valign='middle'>
                        <input type="text" name="length" size='50' id="banlength" value="<?php echo $_POST['length']; ?>"> (segundos)<br /><br>
                        <small>
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (3600);">1 hora,</a>
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (7200);">2 horas,</a>
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (10800);">3 horas,</a> 
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (14400);">4 horas,</a>
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (43200);">12 horas,<br><br></a> 
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (86400);">1 dia,</a> 
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (259200);">3 dias,<br><br></a> 
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (604800);">1 semana,</a> 
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (1209600);">2 semanas,<br><br></a> 
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (2592000);">1 mes,</a> 
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (7776000);">3 meses,<br><br></a> 
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (1314000);">1 ano,</a> 
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (2628000);">2 anos,</a> 
                            <a href="<?php echo $adminpath; ?>/p/ban#" onclick="banPreset (360000000);"> 10 anos!</a></small><br />

                    </td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='30%'  valign='middle'><b>Banimento aplicado por:</b></td>
                    <td class='tablerow2'  width='70%'  valign='middle'><input type='text'disabled='disabled' name='added_by' value="<?php echo $name; ?>" size='30' class='textinput'></td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><b>Tipo:</b></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><select name='type' class='dropdown'><option value='user'>Usurio</option><option value='ip' <?php
                            if ($_POST['type'] == "ip")
                                {
                                echo"selected='selected'";
                                }
                            ?>>IP</option></select>
                    </td>
                </tr>

                <tr>
                <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Banir' class='realbutton' accesskey='s'></td></tr>
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
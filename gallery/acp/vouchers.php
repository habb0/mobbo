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

    $pagename = "Cdigo de Moedas";
    $pageid   = "vouchers";

    if (isset($_POST['submit']))
        {

        if (!empty($_POST['voucher']) && !empty($_POST['credits']))
            {

            Transaction::query("INSERT INTO credit_vouchers (code,value) VALUES ('" . Security::textFilter($_POST['voucher']) . "','" . Security::textFilter($_POST['credits']) . "')");
            $msg = "<div class='rounded rounded-green'><center>Cdigo criado corretamente! <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Preencha todos os campos!. <img src=\"./w/images/del.gif\"></center></div>";
            }
        }

    function randomVoucher($code)
        {
        $characters = "1234567890abdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $key        = $characters{rand(0, 71)};
        for ($i = 1; $i < $code; $i++)
            {
            $key .= $characters{rand(0, 71)};
            }
        return $key;
        }

    $get_vouchers = Transaction::query("SELECT * FROM credit_vouchers");

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></p></strong><?php } ?> 

    <form action='<?php echo $adminpath; ?>/p/vouchers&do=create' method='post' name='theAdminForm' id='theAdminForm'> 
        <div class='tableborder'> 
            <div class='tableheaderalt'><center>Criar cdigo de Moedas</center></div> 

            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'> 
                <tr> 
                    <td class='tablerow1'  width='40%'  valign='middle'><strong>Cdigo</strong><div class='graytext'>Cdigo de Moedas</div></td> 
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='voucher' value="<?php echo randomVoucher(8); ?>" size='30' class='textinput'></td> 
                </tr> 

                <tr> 
                    <td class='tablerow1'  width='40%'  valign='middle'><strong>Quantidade</strong><div class='graytext'>Quantidades de Moedas ao gerar o cdigo</div></td> 
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='credits' value="" size='30' class='textinput'></td> 
                </tr> 

                <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Guardar' name="submit" class='realbutton' accesskey='s'></td></tr> 
                </form></table></div><br /> 

        <?php ?> 

        <div class='tableborder'> 
            <div class='tableheaderalt'><center>Cdigos atuais</center></div> 
            <table cellpadding='4' cellspacing='0' width='100%'> 

                <tr> 
                    <td class='tablesubheader' width='60%' align='center'>Cdigo</td> 
                    <td class='tablesubheader' width='40%' align='center'>Moedas</td> 
                </tr> 

                <?php
                while ($row = Transaction::fetch($get_vouchers))
                    {
                    ?>
                    <tr> 
                        <td class='tablerow1' align='center'><?php echo $row['code']; ?></td> 
                        <td class='tablerow2' align='center'><?php echo $row['value']; ?></td> 
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
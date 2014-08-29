<?php
/* Security Proof */
$included_files = 2345;
$included_files = get_included_files();
if (!in_array($_SERVER['DOCUMENT_ROOT'] . '\CORE.php', $included_files))
    die();


if ($hkzone !== true)
    {
    header("Location: index.php?throwBack=true");
    exit;
    }
if (!mobbo::session_is_registered(acp))
    {
    header("Location: p/login");
    exit;
    }

$pagename = "Home";
$pageid   = "home";

@include('subheader.php');
@include('header.php');
?>
<style>
    table { border: 1px solid white; }
</style>
<table cellpadding='0' cellspacing='8' width='100%' id='tablewrap'>
    <tr>

        <td width='100%' valign='top' id='rightblock'>



            <div data-alert="" class="alert-box success"><?php echo $username; ?>, bem vindo ao Painel de Controle, aqui você gerencia o Hotel.<a href="#" class="close">×</a>
            </div>

            <table cellpadding='0' cellspacing='8' width='100%' id='tablewrap'>
                <tr>	<td width='100%' valign='top' id='rightblock'>
                        <div><!-- RIGHT CONTENT BLOCK -->
                            <div id='ipb-get-members' style='border:1px solid #000; background:#FFF; padding:2px;position:absolute;width:120px;display:none;z-index:100'></div>
                            <!--in_dev_notes-->
                            <!--in_dev_check-->
                            <table border='0' width='100%' cellpadding='0' cellspacing='4'>
                                <tr>
                                    <td valign='top' width='75%'>
                                        <table border='0' width='100%' cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td>

                                                    <table width='100%' cellspacing='0' cellpadding='4'>
                                                        <tr>

                                                            <?php //////////// System/Statistik Liste ////////////   ?>
                                                            <td width='15%' valign='top'  class='panel'>
                                                                <div class='tableborder'>
                                                                    <div class='tableheaderalt'><center>Estatísticas do Hotel</center></div>
                                                                    <table width='60%' cellpadding='4' cellspacing='0'>
                                                                        <tr>
                                                                            <td class='tablesubheader' width='50%'>Nome</td>
                                                                            <td class='tablesubheader' width='50%'>Estatísticas</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td class='tablerow1'>Emblemas</td>
                                                                            <td class='tablerow1'><a><?php echo Transaction::evaluate("SELECT * FROM users_badges"); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='tablerow2'>Banimentos</td>
                                                                            <td class='tablerow2'><a href="<?php echo $adminpath; ?>/p/banlogs"><?php echo Transaction::evaluate("SELECT * FROM bans"); ?></a></td>
                                                                        </tr>
                                                                        <tr>
                                                                        <tr>
                                                                            <td class='tablerow2'>Novidades do Hotel</td>
                                                                            <td class='tablerow2'><a href="<?php echo $adminpath; ?>/p/campaigns"><?php echo Transaction::evaluate("SELECT * FROM mobbo_news"); ?></a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='tablerow1'>Usuários registrados</td>
                                                                            <td class='tablerow1'><a href="<?php echo $adminpath; ?>/p/users"><?php echo Transaction::evaluate("SELECT * FROM users"); ?></a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='tablerow2'>Notícias</td>
                                                                            <td class='tablerow2'><a href="<?php echo $adminpath; ?>/p/news"><?php echo Transaction::evaluate("SELECT * FROM mobbo_news"); ?></a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='tablerow1'>Quartos</td>
                                                                            <td class='tablerow1'><?php echo Transaction::evaluate("SELECT * FROM rooms"); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='tablerow2'>Salas oficiais</td>
                                                                            <td class='tablerow2'><?php echo Transaction::evaluate("SELECT * FROM rooms WHERE owner =''"); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='tablerow2'>Tags</td>
                                                                            <td class='tablerow2'><?php echo Transaction::evaluate("SELECT * FROM user_tags"); ?></td>
                                                                        </tr>



                                                                    </table>


                                                                    <td width='42%' valign='top'  class='panel callout' >

                                                                        <img  align="right" src="w/images/quiz_question.png">
                                                                        <p><span style="font-size: 4 small;">Olá <?php echo $admin_username ?></span></p>
                                                                        <p><span style="font-size: 3 small;">Este &eacute; o Painel de Controle do <?php echo $shortname ?>  Hotel e &eacute; essencial que voc&ecirc; saiba algumas coisas b&aacute;sicas que mant&eacute;m o funcionamento correto do Hotel. Este &eacute; o lugar onde voc&ecirc; far&aacute; diversas coisas do Hotel como poder&aacute; ver os Pedidos de Ajuda realizados pelos usu&aacute;rios, Criar not&iacute;cias, Editar Usu&aacute;rios, e Gerenciar os membros do Clube VIP.</span></p>
                                                                        <p><span style="font-size: 3 small;">&Eacute; essencial a sua ajuda nesta nova caminhada, portanto e necess&aacute;rio a divulga&ccedil;&atilde;o, a colabora&ccedil;&atilde;o dos usu&aacute;rios tamb&eacute;m &eacute; uma otima op&ccedil;&atilde;o. Fa&ccedil;a Eventos de divulga&ccedil;&atilde;o valendo emblemas, oque voc&ecirc; achar melhor.</span></p>
                                                                        <p><span style="font-size: 3 small;">Qualquer erro ou bug que encontrar no site favor entrar em contato imediatamente com um Técnico.</span></p>
                                                                </div></td></tr></td></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
<br /><br /></div></div></div></div>
<?php include_once('footer.php'); ?>
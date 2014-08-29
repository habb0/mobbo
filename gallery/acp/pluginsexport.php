<?php
/* Security Proof */
$included_files = 2345;
$included_files = get_included_files();
if (!in_array($_SERVER['DOCUMENT_ROOT'] . '\CORE.php', $included_files))
    die();

if ($user_rank >= 7 AND $owner == 'yesiamtheowner'))
    {

    if ($hkzone !== true)
        {
        header("Location: index.php?throwBack=true");
        exit;
        }
    if (!isset($_SESSION['acp']))
        {
        header("Location: index.php?p=login");
        exit;
        }

    $pagename = "pluginsexport";
    $pageid   = "pluginsexport";

    $page = Security::textFilter($_GET['page']);

    $posts = Transaction::evaluate("SELECT COUNT(*) FROM mobbo_news");
    $pages = ceil(($posts + 0) / 50);

    if ($page > $pages || $page < 1)
        {
        $page = 1;
        }

    if ($_POST['site'])
        {
        header("location: " . $adminpath . "/p/plugins&page=" . $_POST['page'] . "");
        }

    if ($_POST['site2'])
        {
        header("location: " . $adminpath . "/p/plugins&page=" . $_POST['page2'] . "");
        }

    if ($do == "export" && is_numeric($key))
        {

        $fh     = fopen(SERVERE . '/PLUGINEXPORTADO.xml', 'w');
        $result = Transaction::query("SELECT * FROM mobbo_plugins WHERE id = '" . $key . "' LIMIT 1;");
        while ($row    = Transaction::fetch($result))
            {
            fwrite($fh, '<?xml version="1.0" encoding="utf-8"?>
<plugin>
	<plugin_name>' . $row['plugin_name'] . '</plugin_name>
	<plugin_version>' . $row['plugin_version'] . '</plugin_version>
	<plugin_author>' . $row['plugin_author'] . '</plugin_author>
	<mobbo_code>\n
	' . $row['mobbo_code'] . '\n
	</mobbo_code>
    <Transaction::query></Transaction::query>	
</plugin>');
            }
        fclose($fh);
        $msg = "<div class='rounded rounded-green'><center>Plugin Exportado com Nome de PLUGINEXPORTADO.txt na PASTA DO HOUSEKEEPING. <img src=\"./w/images/check.gif\"></center></div>";
        }

    @include('subheader.php');

    if (isset($msg))
        {
        ?>
        <style type="text/css">
            #theAdminForm .tableborder table tr .tablerow2 #story {
                width: 250px;
                overflow: auto;
            }
        </style>
        <p><strong><?php echo $msg; ?></strong></p><?php } ?>

    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     ?>
    <?php
    if ($editor_mode !== true)
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     ?>

        <form action='<?php echo $adminpath; ?>/p/plugins&do=save' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>Exportar Plugins

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

                        <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    class="small button" name="site" value="Mais "> <span class='button tiny radius'  href='./p/plugins&do=add'>Adicionar Plugins</span>
                </div>

                </center>

                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='1%' align='center'>ID</td>
                        <td class='tablesubheader' width='20%'>Nome do Plugins</td>
                        <td class='tablesubheader' width='12%' align='left'>Verso</td>
                        <td class='tablesubheader' width='10%' align='left'>Autor</td>
                        <td class='tablesubheader' width='1%' align='center'>Exportar</td>
                    </tr>
                    <?php
                    $query_min = ($page * 50) - 50;

                    if ($query_min < 0)
                        { // Page 1
                        $query_min = 0;
                        }

                    $get_articles = Transaction::query("SELECT * FROM mobbo_plugins ORDER BY id DESC LIMIT 100");
                    while ($row          = Transaction::fetch($get_articles))
                        {
                        ?>

                        <tr>
                            <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                            <td class='tablerow2'><strong><?php echo Security::textFilterHK($row['plugin_name']); ?></strong><div class='desctext'><?php echo $row['longstory']; ?></div></td>
                            <td class='tablerow2' align='left'><?php echo $row['plugin_version']; ?></td>
                            <td class='tablerow2' align='left'><?php echo $row['plugin_author']; ?></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/pluginsexport&do=export&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Exportar'></a></td>												
                        </tr>

                    <?php } ?>

                </table>

                <div class='tableborder'>
                    <div class='tableheaderalt'><center>Plugins do Hotel

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

                            <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    class="small button" name="site2" value="Mais "> <span class='button tiny radius'  href='./p/plugins&do=add'>Adicionar Plugins</span>
                    </div>
                </div>

                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     ?>
            <?php } ?>
            <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>
            <?php
            require_once('footer.php');
            }
        else
            {
            require_once('error.php');
            exit;
            }
        ?>
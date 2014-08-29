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

    $pagename = "plugins";
    $pageid   = "plugins";

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

    if ($do == "delete" && is_numeric($key))
        {

        $check = Transaction::query("SELECT id FROM mobbo_plugins WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            Transaction::query("DELETE FROM mobbo_plugins WHERE id = '" . $key . "' LIMIT 1");
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','News gelscht','news.php','" . $my_id . "','0','" . $date_full . "')");
            $msg = "<div class='rounded rounded-green'><center>Plugin Deletado ok. <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - Voc no pode excluir Notcias <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "edit")
        {

        $check = Transaction::query("SELECT * FROM mobbo_plugins WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            $article     = Transaction::fetch($check);
            $editor_mode = true;
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - Voc no pode editar notcias <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "save" && is_numeric($key))
        {

        $check = Transaction::query("SELECT id FROM mobbo_plugins WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {

            $newsdata = Transaction::fetch($check);

            if ($_POST['comments'] == true)
                {
                $checked = '1';
                }
            else
                {
                $checked = '0';
                }

            Transaction::query("UPDATE mobbo_plugins SET plugin_name = '" . $_POST['plugin_name'] . "', plugin_version = '" . $_POST['plugin_version'] . "', plugin_author = '" . $_POST['plugin_author'] . "', mobbo_code = '" . $_POST['editor1'] . "' WHERE id = '" . $key . "' LIMIT 1");
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','News wurde Bearbeitet','news.php','" . $my_id . "','0','" . $date_full . "')");
            $msg         = "<div class='rounded rounded-green'><center>Plugin Editado.. <img src=\"./w/images/check.gif\"></center></div>";
            $editor_mode = false;
            }
        else
            {

            $msg = "<div class='rounded rounded-red'><center>Error - A Plugin no existe! <img src=\"./w/images/check.gif\"></center></div>";
            }
        }
    elseif ($do == "add")
        {

        $editor_mode = true;

        if ($_POST['submit'])
            {

            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Plugin Adicionado','news_add.php','" . $my_id . "','0','" . $date_full . "')");
            Transaction::query("INSERT INTO `mobbo_plugins` (`id`, `plugin_name`, `plugin_version`, `plugin_author`, `mobbo_code`) VALUES ('" . $_POST['title'] . "','" . $_POST['plugin_name'] . "','" . $_POST['plugin_version'] . "','" . $_POST['plugin_author'] . "','" . $_POST['editor1'] . "')");
            $msg         = "<div class='rounded rounded-green'><center>Plugin Criado com Sucesso</center></div>";
            $editor_mode = false;
            }
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

    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>
    <?php
    if ($editor_mode !== true)
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

        <form  onSubmit="MirrorUpdate ();" action='<?php echo $adminpath; ?>/p/plugins&do=save' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center><h2>Centro de Plugins</h2>

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

                </div>

                </center>

                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='1%' align='center'>ID</td>
                        <td class='tablesubheader' width='20%'>Nome do Plugins</td>
                        <td class='tablesubheader' width='12%' align='left'>Versão</td>
                        <td class='tablesubheader' width='10%' align='left'>Autor</td>
                        <td class='tablesubheader' width='1%' align='center'>Editar</td>
                        <td class='tablesubheader' width='1%' align='center'>Excluir</td>
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
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/plugins&do=edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Editar'></a></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/plugins&do=delete&key=<?php echo $row['id']; ?>'><img src='./w/images/del.gif' alt='Eliminar'></a></td>															
                        </tr>

                    <?php } ?>

                </table>



                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     ?>
                <?php
                }
            elseif ($do == "add")
                {
                ?>
                <?php
                }
            elseif ($do == "edit" && is_numeric($key))
                {
                ?>
                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     ?>

                <form action='<?php echo $adminpath; ?>/p/plugins&do=save&key=<?php echo $article['id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
                    <div class='tableborder'>
                        <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Nome</b><div class='graytext'>Nome do Plugin</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='plugin_name' value="<?php echo $article['plugin_name']; ?>" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Verso do Plugins</b><div class='graytext'>Verso do Plugin</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='plugin_version' value="<?php echo $article['plugin_version']; ?>" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Contedo</b><div class='graytext'>Codigo HTML do Plugin<br /><font color="green"><a href="http://habbosearch.com.br">Edies <?php echo $shortname; ?>.</a></font></div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><fieldset>
                                        <button type="button" onclick="MirrorUpdate ();" class="submit right input-button">Toggle Toolbar</button>
                                        <div class="clear"></div>
                                        <div class="textarea-row">
                                            <textarea cols="80" id="editor1" class="ck-textarea" name="editor1" rows="10"><?php echo eval('?> ' . $article['mobbo_code'] . ' <?php '); ?></textarea>
                                        </div>
                                        <div class="clear"></div>
                                    </fieldset></td>
                            </tr>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Autor</b><div class='graytext'>Dono do Plugin?</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='plugin_author' value="<?php echo $article['plugin_author']; ?>" size='30' class='textinput'></td>
                            </tr>

                            <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Actualizar Plugin' class='realbutton' accesskey='s'></td></tr>
                            </form></table></div><br />

                    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     ?>
                <?php } ?>
                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

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
<script src="http://codemirror.net/1/web-gallery/js/codemirror.js" type="text/javascript"></script>
<script type="text/javascript">
                                    var editor = CodeMirror.fromTextArea ('editor1', {
                                        height: "350px",
                                        parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js",
                                            "http://codemirror.net/1/contrib/php/web-gallery/js/tokenizephp.js", "http://codemirror.net/1/contrib/php/web-gallery/js/parsephp.js",
                                            "http://codemirror.net/1/contrib/php/web-gallery/js/parsephphtmlmixed.js"],
                                        stylesheet: ["http://codemirror.net/1/css/xmlcolors.css", "http://codemirror.net/1/css/jscolors.css", "http://codemirror.net/1/css/csscolors.css", "http://codemirror.net/1/contrib/php/css/phpcolors.css"],
                                        path: "http://codemirror.net/1/web-gallery/js/",
                                        continuousScanning: 500
                                    });
</script>
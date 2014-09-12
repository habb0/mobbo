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

    $pagename = "Notcias";
    $pageid   = "news";
    $key      = htmlentities($_GET['key']);
    $do       = htmlentities($_GET['do']);
    $page     = Security::textFilter($_GET['page']);

    $posts = Transaction::evaluate("SELECT COUNT(*) FROM mobbo_news");
    $pages = ceil(($posts + 0) / 50);

    if ($page > $pages || $page < 1)
        {
        $page = 1;
        }

    if ($_POST['site'])
        {
        header("location: " . $adminpath . "/p/news&page=" . $_POST['page'] . "");
        }

    if ($_POST['site2'])
        {
        header("location: " . $adminpath . "/p/news&page=" . $_POST['page2'] . "");
        }

    if ($do == "delete" && is_numeric($key))
        {

        $check = Transaction::query("SELECT id FROM mobbo_news WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            Transaction::query("DELETE FROM mobbo_news WHERE id = '" . $key . "' LIMIT 1");
            $msg = "<div class='rounded rounded-green'><center>A notcia foi removida com xito!. <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Voc no tem permisso para remover notcias!<img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "edit")
        {

        $check = Transaction::query("SELECT * FROM mobbo_news WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            $check       = Transaction::query("SELECT * FROM mobbo_news WHERE id = '" . $key . "' LIMIT 1");
            $article     = Transaction::fetch($check);
            $editor_mode = true;
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Voc no tem permisso para editar notcias.<img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "save" && is_numeric($key) && isset($_POST['image']))
        {

        $check = Transaction::query("SELECT id FROM mobbo_news WHERE id = '" . $key . "' LIMIT 1");

        if (Transaction::num_rows($check) > 0)
            {
            $check    = Transaction::query("SELECT id FROM mobbo_news WHERE id = '" . $key . "' LIMIT 1");
            $newsdata = Transaction::fetch($check);

            if ($_POST['comments'] == true)
                {
                $checked = '1';
                }
            else
                {
                $checked = '0';
                }

            Transaction::query("UPDATE mobbo_news SET title = '" . $_POST['title'] . "', image = '" . $_POST['image'] . "', shortstory = '" . $_POST['shortstory'] . "', longstory = '" . $_POST['longstory'] . "', author = '" . $_POST['author'] . "' WHERE id = '" . $key . "' LIMIT 1");
            $msg         = "<div class='rounded rounded-green'><center>A notcia foi publicada corretamente!. <img src=\"./w/images/check.gif\"></center></div>";
            $editor_mode = false;
            }
        else
            {

            $msg = "<div class='rounded rounded-red'><center>Esta notcia no existe<img src=\"./w/images/check.gif\"></center></div>";
            }
        }
    elseif ($do == "add")
        {

        $editor_mode = true;

        if ($_POST['submit'])
            {

            Transaction::query("INSERT INTO mobbo_news (title,longstory,shortstory,published,image,author) VALUES ('" . $_POST['title'] . "','" . $_POST['shortstory'] . "','" . $_POST['longstory'] . "','" . time() . "','" . $_POST['image'] . "','" . $_POST['author'] . "')");
            $msg         = "<div class='rounded rounded-green'><center>A notcia foi publicada!</center></div>";
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

    <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  ?>
    <?php
    if ($editor_mode !== true)
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>

        <form action='<?php echo $adminpath; ?>/p/news&do=save' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>Todas as notcias do Hotel

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

                        <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site" value="Prxima pgina >>"/> <a class='button tiny radius'  href='./p/news&do=add'>Publicar Notcia</a>
                </div>

                </center>

                <table cellpadding='4' cellspacing='0' width='100%'>
                    <tr>
                        <td class='tablesubheader' width='1%' align='center'>ID</td>
                        <td class='tablesubheader' width='20%'>Ttulo</td>
                        <td class='tablesubheader' width='12%' align='left'>Data</td>
                        <td class='tablesubheader' width='10%' align='left'>Autor</td>
                        <td class='tablesubheader' width='1%' align='center'>Editar</td>
                        <td class='tablesubheader' width='1%' align='center'>Remover</td>
                    </tr>
                    <?php
                    $query_min = ($page * 50) - 50;

                    if ($query_min < 0)
                        { // Page 1
                        $query_min = 0;
                        }

                    $get_articles = Transaction::query("SELECT * FROM mobbo_news ORDER BY id DESC LIMIT " . $query_min . ", 50");
                    while ($row          = Transaction::fetch($get_articles))
                        {
                        ?>

                        <tr>
                            <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                            <td class='tablerow2'><strong><?php echo Security::textFilterHK($row['title']); ?></strong><div class='desctext'><?php echo $row['longstory']; ?></div></td>
                            <td class='tablerow2' align='left'><?php echo date('d/m/Y', $row['published']); ?></td>
                            <td class='tablerow2' align='left'><?php echo $row['author']; ?></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/news&do=edit&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Editar'></a></td>
                            <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/news&do=delete&key=<?php echo $row['id']; ?>'><img src='./w/images/del.gif' alt='Eliminar'></a></td>															
                        </tr>

                    <?php } ?>

                </table>

                <div class='tableborder'>
                    <div class='tableheaderalt'><center>Todas as notcias do Hotel

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

                            <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    name="site2" value="Prxima pgina "/> <a class='button tiny radius'  href='./p/news&do=add'>Publicar Notcia</a>
                    </div>
                </div>

                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>
                <?php
                }
            elseif ($do == "add")
                {
                ?>
                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

                <form action='<?php echo $adminpath; ?>/p/news&do=add' method='post' name='theAdminForm' id='theAdminForm'>
                    <div class='tableborder'>
                        <div class='tableheaderalt'><center>Publicar Notcias</center></div>

                        <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Ttulo</b><div class='graytext'>Ttulo da Notcia</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='title' value="" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Resumo</b><div class='graytext'>Resumo da Notcia</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='shortstory' value="" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Histria</b><div class='graytext'>Notcia<br /><font color="green"></font></div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><textarea id="story" name="longstory" cols='60' rows='8' style="width: 15%"></textarea></td>
                            </tr>
                            <script type="text/javascript" src="w/tiny_mce/tiny_mce.js"></script>
                            <script type="text/javascript">
                                tinyMCE.init ({
                                    language: "en",
                                    // General options
                                    mode: "exact",
                                    elements: "story",
                                    theme: "advanced",
                                    plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
                                    // Theme options
                                    theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                                    theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                                    theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                                    theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
                                    theme_advanced_toolbar_location: "top",
                                    theme_advanced_toolbar_align: "left",
                                    theme_advanced_statusbar_location: "bottom",
                                    theme_advanced_resizing: true,
                                    // Example content CSS (should be your site CSS)
                                    content_css: "<?php echo HPATH; ?>w/tiny_mce/css/content.css",
                                    // Drop lists for link/image/media/template dialogs
                                    template_external_list_url: "<?php echo HPATH; ?>w/tiny_mce/lists/template_list.js",
                                    external_link_list_url: "<?php echo HPATH; ?>w/tiny_mce/lists/link_list.js",
                                    external_image_list_url: "<?php echo HPATH; ?>w/tiny_mce/lists/image_list.js",
                                    media_external_list_url: "<?php echo HPATH; ?>w/tiny_mce/lists/media_list.js",
                                    // Style formats
                                    style_formats: [
                                        {title: 'Bold text', inline: 'b'},
                                        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                                        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                                        {title: 'Example 1', inline: 'span', classes: 'example1'},
                                        {title: 'Example 2', inline: 'span', classes: 'example2'},
                                        {title: 'Table styles'},
                                        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                                    ],
                                    // Replace values for the template plugin
                                    template_replace_values: {
                                        username: "Some User",
                                        staffid: "991234"
                                    }
                                });
                            </script>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Topstory</b><div class='graytext'>Imagem ou cor do fundo da noticia (ex: #FFFFF, oi.com/oi.jpg)</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='image' value="" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Autor</b><div class='graytext'>Nome de quem escreveu a notcia</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='author' value="" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                            <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' name='submit' value='Publicar Notcia' class='realbutton' accesskey='s'></td></tr>

                        </table>

                    </div>
            </div>
        </form>

        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>
        <?php
        }
    elseif ($do == "edit" && is_numeric($key))
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

        <form action='<?php echo $adminpath; ?>/p/news&do=save&key=<?php echo $article['id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center>Notcia <u><?php echo $article['title']; ?></u> (ID: <?php echo $article['id']; ?>) <img src="./w/images/edit.gif"></center></div>

                <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Ttulo</b><div class='graytext'>Ttulo da Notcia</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='title' value="<?php echo $article['title']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Resumo</b><div class='graytext'>Resumo da Notcia</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='shortstory' value="<?php echo $article['longstory']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Histria</b><div class='graytext'>Notcia<br /><font color="green"></font></div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><textarea id="story" name="longstory" cols='60' rows='8' style="width: 8%"><?php echo $article['shortstory']; ?></textarea></td>
                    </tr>
                    <script type="text/javascript" src="./w/tiny_mce/tiny_mce.js"></script>
                    <script type="text/javascript">
                                tinyMCE.init ({
                                    language: "es",
                                    // General options
                                    mode: "exact",
                                    elements: "story",
                                    theme: "advanced",
                                    plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
                                    // Theme options
                                    theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                                    theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,forecolor,backcolor",
                                    theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,ltr,rtl,|,fullscreen",
                                    theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,|,insertdate,inserttime,preview",
                                    theme_advanced_toolbar_location: "top",
                                    theme_advanced_toolbar_align: "left",
                                    theme_advanced_statusbar_location: "bottom",
                                    theme_advanced_resizing: true,
                                    width: "750px",
                                    // Example content CSS (should be your site CSS)
                                    content_css: "./w/tiny_mce/css/content.css",
                                    // Drop lists for link/image/media/template dialogs
                                    template_external_list_url: "./w/tiny_mce/lists/template_list.js",
                                    external_link_list_url: "./>w/tiny_mce/lists/link_list.js",
                                    external_image_list_url: "./w/tiny_mce/lists/image_list.js",
                                    media_external_list_url: "./w/tiny_mce/lists/media_list.js",
                                    // Style formats
                                    style_formats: [
                                        {title: 'Bold text', inline: 'b'},
                                        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                                        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                                        {title: 'Example 1', inline: 'span', classes: 'example1'},
                                        {title: 'Example 2', inline: 'span', classes: 'example2'},
                                        {title: 'Table styles'},
                                        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                                    ],
                                    // Replace values for the template plugin
                                    template_replace_values: {
                                        username: "Some User",
                                        staffid: "991234"
                                    }
                                });
                    </script>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Topstory</b><div class='graytext'>Imagem ou cor do fundo da noticia (ex: #FFFFF, oi.com/oi.jpg)</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='image' value="<?php echo $article['image']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Autor</b><div class='graytext'>Nome de quem escreveu a Notcia</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='author' value="<?php echo $article['author']; ?>" size='30' class='textinput'></td>
                    </tr>


                    <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' value='Atualizar Notcia' class='realbutton' accesskey='s'></td></tr>
                    </form></table></div><br />

            <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>
        <?php } ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   ?>

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
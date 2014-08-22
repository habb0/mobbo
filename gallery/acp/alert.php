<?php
if ($user_rank > 4)
    {

    if ($hkzone !== true)
        {
        header("Location: index/?throwBack=true");
        exit;
        }
    if (!mobbo::session_is_registered(acp))
        {
        header("Location: p/login");
        exit;
        }

    $pagename = "Alertas";
    $pageid   = "alert";

    if (isset($_POST['alert']))
        {

        $check = Transaction::query("SELECT * FROM users WHERE username = '" . Security::textFilter($_POST['name']) . "' LIMIT 1");
        if (Transaction::num_rows($check) > 0)
            {
            $userdata = Transaction::fetch($check);
            Transaction::query("INSERT INTO mobbo_alerts (userid,alert) VALUES ('" . $userdata['id'] . "','" . Security::textFilter($_POST['alert']) . "')");
            $msg      = "<div class='rounded rounded-green'><center>Alerta enviada a  " . Security::textFilter($_POST['name']) . " (ID: " . $userdata['id'] . ") <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Oops! este usurio no foi encontrado. <img src=\"./w/images/del.gif\"></center></div>";
            }
        }

    @include('subheader.php');

    if (isset($msg))
        {
        ?><p><strong><?php echo $msg; ?></strong></p><?php } ?>

    <form action='<?php echo $adminpath; ?>/p/alert' method='post' name='theAdminForm' id='theAdminForm'>
        <div class='tableborder'>
            <div class='tableheaderalt'><center>Enviar alertas</center></div>

            <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><b>Nome do usurio</b><div class='graytext'>Nome do usurio que deseja enviar um alerta.</div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='name' value="<?php echo $_POST['name']; ?>" size='50' class='textinput'></td>
                </tr>

                <tr>
                    <td class='tablerow1'  width='40%'  valign='middle'><b>Alerta</b><div class='graytext'>Mensagem para o usurio</div></td>
                    <td class='tablerow2'  width='60%'  valign='middle'><textarea id="story" name="alert" cols='60' rows='8' style="width: 15%"></textarea></td>
                </tr>
                <script type="text/javascript" src="./w/tiny_mce/tiny_mce.js"></script>
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
                <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Enviar alerta' class='realbutton' accesskey='s'></td></tr>
                </form></table></div><br>	 </div><!-- / RIGHT CONTENT BLOCK -->
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
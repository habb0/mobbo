<?php
if ($user_rank >= 7 AND $myrow['owner'] == 1)
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

    $pagename = "templates";
    $pageid   = "templates";

    $page = Security::textFilter($_GET['page']);

    $posts = Transaction::evaluate("SELECT COUNT(*) FROM mobbo_news");
    $pages = ceil(($posts + 0) / 50);

    if ($page > $pages || $page < 1)
        {
        $page = 1;
        }

    if ($_POST['site'])
        {
        header("location: " . $adminpath . "/p/templates&page=" . $_POST['page'] . "");
        }

    if ($_POST['site2'])
        {
        header("location: " . $adminpath . "/p/templates&page=" . $_POST['page2'] . "");
        }

    if ($do == "delete" && is_numeric($key))
        {
        $id    = $_GET['key'];
        $id    = (is_numeric($id)) ? $id : 0;
        $check = Transaction::query("SELECT id FROM mobbo_templates WHERE id = '" . $id . "' LIMIT 1");
        if (Transaction::num_rows($check) > 0)
            {
            $tem = Transaction::fetch($check);
            $tem = $tem['path'];
            if (Templates::Delete($tem))
                {
                $msg = "<div class='rounded rounded-green'><center>Template Deletado Ok.. <img src=\"./w/images/check.gif\"></center></div>";
                }
            else
                {
                $msg = "<div class='rounded rounded-red'><center>Error - Template nao Deletado.. :( <img src=\"./w/images/del.gif\"></center></div>";
                }
            }
        }
    elseif ($do == "active" && is_numeric($key))
        {
        $id    = $_GET['key'];
        $id    = (is_numeric($id)) ? $id : 0;
        $query = Transaction::query("SELECT * FROM mobbo_templates WHERE id = '" . $id . "'");
        $fetch = Transaction::fetch($query);
        $name  = $fetch['path'];
        if (Transaction::Active($name))
            {
            $msg = "<div class='rounded rounded-green'><center>Template Ativado Ok.. <img src=\"./w/images/check.gif\"></center></div>";
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Error - Template nao Ativado :( <img src=\"./w/images/del.gif\"></center></div>";
            }
        }
    elseif ($do == "download" && is_numeric($key))
        {
        $template = $_POST['template'];
        $url      = $_POST['template'];
        if (Templates::Download($template))
            {
            $patan = explode('/', $url);
            $pates = $patan[5];
            $name  = str_replace('.zip', '', $pates);
            if (Templates::Install($name))
                {
                if (Templates::Active($name))
                    {
                    $msg = "<div class='rounded rounded-green'><center>Template Baixado e Extraido com Sucesso<img src=\"./w/images/check.gif\"></center></div>";
                    }
                }
            else
                {
                if (Templates::Active($name))
                    {
                    $msg = "<div class='rounded rounded-green'><center>Template já Estava Instalado, mas foi Ativado<img src=\"./w/images/check.gif\"></center></div>";
                    }
                }
            }
        else
            {
            $msg = "<div class='rounded rounded-red'><center>Erro ao Extrair<img src=\"./w/images/check.gif\"></center></div>";
            }
        }
    elseif ($do == "add")
        {

        $editor_mode = true;

        if ($_POST['submit'])
            {

            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Plugin Adicionado','news_add.php','" . $my_id . "','0','" . $date_full . "')");
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

        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        ?>
        <?php
        if ($editor_mode !== true)
        {
        ?>
                <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    ?>

        <form  onSubmit="MirrorUpdate ();" action='<?php echo $adminpath; ?>/p/templates&do=download' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <div class='tableheaderalt'><center><h2>Centro de Templates</h2>



                </div>

                </center>
                <h5>Escolha um Template</h5>
                <iframe src="http://bi0s.hostingsiteforfree.com/listar.php" width="800" height="200" style="width:800px;height:300px;" frameborder="0" scrolling="yes"></iframe><br><br>      
                <h5>Coloque a URL do Template Aqui</h5>
                <input type="text" name="template" placeholder="Coloque Aqui a Url do Template"/>
                <input type="submit" class='button success tiny radius' style='margin-top: -10px;'    value="Baixar e Instalar" class="small button"/>
        </form>

        <h5>Listar Templates</h5>
        <table cellpadding='4' cellspacing='0' width='100%'>
            <tr>
                <td class='tablesubheader' width='1%' align='center'>ID</td>
                <td class='tablesubheader' width='20%'>Nome do Template</td>
                <td class='tablesubheader' width='12%' align='left'>Versão</td>
                <td class='tablesubheader' width='12%' align='left'>Autor</td>
                <td class='tablesubheader' width='10%' align='left'>Ativado?</td>
                <td class='tablesubheader' width='1%' align='center'>Ativar</td>
                <td class='tablesubheader' width='1%' align='center'>Deletar</td>
            </tr>
            <?php
            $query_min = ($page * 50) - 50;

            if ($query_min < 0)
            { // Page 1
            $query_min = 0;
            }

            $get_articles = Transaction::query("SELECT * FROM mobbo_templates ORDER BY id DESC LIMIT 100");
            while ($row = Transaction::fetch ($get_articles))
            {
            ?>

            <tr>
                <td class='tablerow1' align='center'><?php echo $row['id']; ?></td>
                                <td class='tablerow2'><strong><?php echo Security::textFilterHK($row['name']); ?></strong><div class='desctext'><?php echo $row['longstory']; ?></div></td>
                <td class='tablerow2' align='left'><?php echo $row['version']; ?></td>
                <td class='tablerow2' align='left'><?php echo $row['creator']; ?></td>
                <td class='tablerow2' align='left'><?php echo $row['active']; ?></td>
                <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/templates&do=active&key=<?php echo $row['id']; ?>'><img src='./w/images/edit.gif' alt='Ativar'></a></td>
                <td class='tablerow2' align='center'><a href='<?php echo $adminpath; ?>/p/templates&do=delete&key=<?php echo $row['id']; ?>'><img src='./w/images/del.gif' alt='Eliminar'></a></td>															
            </tr>

            <?php } ?>

        </table>



        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////         ?>
        <?php
        }
        elseif ($do == "add")
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     ?>

        <form  onSubmit="MirrorUpdate ();" action='<?php echo $adminpath; ?>/p/templates&do=add' method='post' name='theAdminForm' id='theAdminForm'>
                    <div class='tableborder'>
                        <div class='tableheaderalt'><center>Criar Template</center></div>

                        <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Nome</b><div class='graytext'>Nome do Template</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='plugin_name' value="" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Versao do Template</b><div class='graytext'>Verso do Template</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='plugin_version' value="" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Pasta do Template (/public/skins/NOMEDAPASTA/</b><div class='graytext'>Nome da pasta</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='folder' value="" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                                <td class='tablerow1'  width='40%'  valign='middle'><b>Autor</b><div class='graytext'>Dono do Plugin?</div></td>
                                <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='plugin_author' value="" size='30' class='textinput'></td>
                            </tr>

                            <tr>
                            <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' name='submit' value='Criar Template' class='realbutton' accesskey='s'></td></tr>

                        </table>

                    </div>
                </div>
                </form>

        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////          ?>
        <?php
        }
        elseif ($do == "edit" && is_numeric($key))
        {
        ?>
        <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     ?>

        <form action='<?php echo $adminpath; ?>/p/templates&do=save&key=<?php echo $article['id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
            <div class='tableborder'>
                <table width='100%' cellspacing='0' cellpadding='5' align='center' border='0'>
                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Nome</b><div class='graytext'>Nome do Template</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='plugin_name' value="<?php echo $article['name']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Verso do Plugins</b><div class='graytext'>Verso do Template</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='plugin_version' value="<?php echo $article['version']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Pasta do Template (/public/skins/NOMEDAPASTA/)</b><div class='graytext'>Nome da pasta</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='folder' value="<?php echo $article['folder']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr>
                        <td class='tablerow1'  width='40%'  valign='middle'><b>Autor</b><div class='graytext'>Dono do Template?</div></td>
                        <td class='tablerow2'  width='60%'  valign='middle'><input type='text' name='plugin_author' value="<?php echo $article['author']; ?>" size='30' class='textinput'></td>
                    </tr>

                    <tr><td align='center' class='tablesubheader' colspan='2' ><input type="submit" class='button success tiny radius' style='margin-top: -10px;' value='Actualizar Template' class='realbutton' accesskey='s'></td></tr>
                    </form></table></div><br />

            <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////         ?>
            <?php } ?>
            <?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     ?>

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


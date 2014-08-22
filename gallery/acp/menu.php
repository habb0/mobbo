<?php
if ($hkzone !== true)
    {
    header("Location: index.php?throwBack=true");
    exit;
    }

if ($tab == "3")
    {
    ?>

    <div class='menuouterwrap'>
        <div class='menucatwrap'><div id="content_kat"><img src='./w/images/menu_title_bullet.gif'> Configuraçõs</div></div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/settings' style='text-decoration:none'><?php
                if ($pageid == "settings")
                    {
                    ?><b>Configurçõs</b><?php
                    }
                else
                    {
                    ?>Configuraçõs<?php } ?></a>
        </div><br>

        <div class='menuouterwrap'>
            <div class='menucatwrap'><div id="content_kat"><img src='./w/images/menu_title_bullet.gif'>Notícias</div></div>


            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/news' style='text-decoration:none'><?php
                    if ($pageid == "news")
                        {
                        ?><b>Notícias</b><?php
                        }
                    else
                        {
                        ?>Notícias<?php } ?></a>
            </div>



            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/campaigns' style='text-decoration:none'><?php
                    if ($pageid == "campaigns")
                        {
                        ?><b>Campanhas</b><?php
                        }
                    else
                        {
                        ?>Campanhas<?php } ?></a>
            </div>






        </div>
        <br />



        <div class='menuouterwrap'>
            <div class='menucatwrap'><div id="content_kat"><img src='./w/images/menu_title_bullet.gif'>Plugins</div></div>


            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/plugins' style='text-decoration:none'><?php
                    if ($pageid == "plugins")
                        {
                        ?><b>Plugins</b><?php
                        }
                    else
                        {
                        ?>Plugins<?php } ?></a>
            </div>



            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/pluginsadd' style='text-decoration:none'><?php
                    if ($pageid == "pluginsadd")
                        {
                        ?><b>Add Plugins</b><?php
                        }
                    else
                        {
                        ?>Add Plugins<?php } ?></a>
            </div>






        </div>
        <br />



        <div class='menuouterwrap'>
            <div class='menucatwrap'><div id="content_kat"><img src='./w/images/menu_title_bullet.gif'>Templates</div></div>


            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/templates' style='text-decoration:none'><?php
                    if ($pageid == "templates")
                        {
                        ?><b>Templates</b><?php
                        }
                    else
                        {
                        ?>Templates<?php } ?></a>
            </div>



        </div>
        <br />

    </div>


    <div class='menuouterwrap'>
        <div class='menucatwrap'><div id="content_kat"><img src='./w/images/menu_title_bullet.gif'> Loja de Emblemas</div></div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/marktplatz' style='text-decoration:none'><?php
                if ($pageid == "webstore_item")
                    {
                    ?><b>Editar Items</b><?php
                    }
                else
                    {
                    ?>Editar Items<?php } ?></a>
        </div>


    </div>
    <br />

    <?php
    } if ($tab == "4")
    {
    ?>

    <div class='menuouterwrap'>
        <div class='menucatwrap'><div id="content_kat"><img src='./w/images/menu_title_bullet.gif'> Quartos</div></div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/room_guestrooms' style='text-decoration:none'>Quartos <img src="./w/images/<?php
                if ($pageid == "room_guestroom")
                    {
                    echo'check';
                    }
                else
                    {
                    echo'del';
                    }
                ?>.gif" align="right"></a>
        </div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/room_officialrooms' style='text-decoration:none'>Quartos oficiais <img src="./w/images/<?php
                if ($pageid == "room_officialroom")
                    {
                    echo'check';
                    }
                else
                    {
                    echo'del';
                    }
                ?>.gif" align="right"></a>
        </div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/room_categories' style='text-decoration:none'>Categorias <img src="./w/images/<?php
                if ($pageid == "room_categories")
                    {
                    echo'check';
                    }
                else
                    {
                    echo'del';
                    }
                ?>.gif" align="right"></a>
        </div>

    </div>
    <br>

    </div>
    <br>

    <?php
    } if ($tab == "5")
    {
    ?>

    <div class='menuouterwrap'>
        <div class='menucatwrap'><div id="content_kat"><img src='./w/images/menu_title_bullet.gif'> Gesto de Usurios</div></div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/badgetool' style='text-decoration:none'><?php
                if ($pageid == "badgetool")
                    {
                    ?><b>Emblemas</b><?php
                    }
                else
                    {
                    ?>Emblemas<?php } ?></a>
        </div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/cloner' style='text-decoration:none'><?php
                if ($pageid == "cloner")
                    {
                    ?><b>Multiplas Contas</b><?php
                    }
                else
                    {
                    ?>Multiplas Contas<?php } ?></a>
        </div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/massa' style='text-decoration:none'><?php
                if ($pageid == "massa")
                    {
                    ?><b>Moedas/Emblemas</b><?php
                    }
                else
                    {
                    ?>Moedas/Emblemas<?php } ?></a>
        </div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/users' style='text-decoration:none'><?php
                if ($pageid == "users")
                    {
                    ?><b>Usuários do Hotel</b><?php
                    }
                else
                    {
                    ?>Usuários do Hotel<?php } ?></a>
        </div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/users_edit' style='text-decoration:none'><?php
                if ($pageid == "users_edit")
                    {
                    ?><b>Procurar usuários</b><?php
                    }
                else
                    {
                    ?>Procurar usuários<?php } ?></a>
        </div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/passwordtool' style='text-decoration:none'><?php
                if ($pageid == "passwordtool")
                    {
                    ?><b>Senha</b><?php
                    }
                else
                    {
                    ?>Senha<?php } ?></a>
        </div>

        <div class='menulinkwrap'>&nbsp;
            <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
            <a href='./p/ranktool' style='text-decoration:none'><?php
                if ($pageid == "ranktool")
                    {
                    ?><b>Cargos</b><?php
                    }
                else
                    {
                    ?>Cargos<?php } ?></a>
        </div>

        <br />


        <div class='menuouterwrap'>
            <div class='menucatwrap'><div id="content_kat"><img src='./w/images/menu_title_bullet.gif'> Ferramenta VIP</div></div>

            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/viptool' style='text-decoration:none'><?php
                    if ($pageid == "viptool")
                        {
                        ?><b>Dar VIP</b><?php
                        }
                    else
                        {
                        ?>Dar VIP<?php } ?></a>
            </div>

            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/viptool2' style='text-decoration:none'><?php
                    if ($pageid == "viptool2")
                        {
                        ?><b>Tirar VIP</b><?php
                        }
                    else
                        {
                        ?>Tirar VIP<?php } ?></a>
            </div>

        </div>
        <br />


        <div class='menuouterwrap'>
            <div class='menucatwrap'><div id="content_kat"><img src='./w/images/menu_title_bullet.gif'> Moderao</div></div>

            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/ban' style='text-decoration:none'><?php
                    if ($pageid == "ban")
                        {
                        ?><b>Banimento</b><?php
                        }
                    else
                        {
                        ?>Banimento<?php } ?></a>
            </div>

            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/unban' style='text-decoration:none'><?php
                    if ($pageid == "unban")
                        {
                        ?><b>Desbanir</b><?php
                        }
                    else
                        {
                        ?>Desbanir<?php } ?></a>
            </div>

            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/helper' style='text-decoration:none'><?php
                    if ($pageid == "helper")
                        {
                        ?><b>Pedidos de ajuda</b><?php
                        }
                    else
                        {
                        ?>Pedidos de ajuda<?php } ?></a>
            </div>

            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/alert' style='text-decoration:none'><?php
                    if ($pageid == "alert")
                        {
                        ?><b>Alertar Usuário (Site)</b><?php
                        }
                    else
                        {
                        ?>Alertar Usuário (Site)<?php } ?></a>
            </div>

        </div>
        <br />


        <div class='menuouterwrap'>
            <div class='menucatwrap'><div id="content_kat"><img src='./w/images/menu_title_bullet.gif'> Dados Salvos</div></div>

            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/stafflogs' style='text-decoration:none'><?php
                    if ($pageid == "stafflogs")
                        {
                        ?><b>Dados da Moderação</b><?php
                        }
                    else
                        {
                        ?>Dados da Moderação<?php } ?></a>
            </div>

            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/banlogs' style='text-decoration:none'><?php
                    if ($pageid == "banlogs")
                        {
                        ?><b>Lista de usuários banidos</b><?php
                        }
                    else
                        {
                        ?>Lista de usuários banidos<?php } ?></a>
            </div>

            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/alertlogs' style='text-decoration:none'><?php
                    if ($pageid == "alertlogs")
                        {
                        ?><b>Dados de Alertas</b><?php
                        }
                    else
                        {
                        ?>Dados de Alertas<?php } ?></a>
            </div>

            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/chatlogs' style='text-decoration:none'><?php
                    if ($pageid == "chatlogs")
                        {
                        ?><b>Conversas</b><?php
                        }
                    else
                        {
                        ?>Conversas<?php } ?></a>
            </div>

            <div class='menulinkwrap'>&nbsp;
                <img src='./w/images/item_bullet.gif' border='0' alt='' valign='absmiddle'>&nbsp;
                <a href='./p/onlinelogs' style='text-decoration:none'><?php
                    if ($pageid == "onlinelogs")
                        {
                        ?><b>Pessoas online</b><?php
                        }
                    else
                        {
                        ?>Pessoas online<?php } ?></a>
            </div>

        </div>
        <br />


    <?php } ?>

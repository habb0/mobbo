 <?php
 				/*
				Hooks System 0.1a - mobbo 6.0
				:: NAME :: Shop Plugin
				:: VERSION :: 1.0
				:: AUTHOR :: bi0s
				*/
                                $query_min = ($page * 50) - 50;

                                if ($query_min < 0)
                                    { // Page 1
                                    $query_min = 0;
                                    }

                                $get_marktplatz = Transaction::query("SELECT * FROM mobbo_shop ORDER BY id DESC LIMIT " . $query_min . ", 50") or die(mysql_error());
                                while ($row            = Transaction::fetch($get_marktplatz))
                                    {
                                    ?>
                                    <tr>
                                        <td class='tablerow2' align='center'><img src="http://images.habbo.com/c_images/album1584/<?php echo $row['image']; ?>.gif" alt="<?php echo $row['image']; ?>"></td>
                                        <td class='tablerow2' align='center'><?php echo $row['name']; ?></td>
                                        <td class='tablerow2' align='center'><?php echo $row['dolares']; ?></td>
                                        <td class='tablerow2' align='center'><a class="small button" onclick="buyItem ('<?php echo $row['image'] ?>');">Comprar</a></td>
                                        <?php
                                        if (mobbo::users_info('rank') >= 6)
                                            {
                                            ?> <td class='tablerow2' align='center'><a href='../acp/index/p/marktplatzdo&do=edit&key=<?php echo $row['id']; ?>' class='small button'>Editar</a></td>
                                            <td class='tablerow2' align='center'><a href='../acp/index/p/marktplatzdo&do=delete&key=<?php echo $row['badge_id']; ?>' class='small button alert'>Deletar</a></td><?php } ?>
                                    </tr>
                                <?php } ?>
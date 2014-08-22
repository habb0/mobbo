<?php
 				/*
				Hooks System 0.1a - mobbo 6.0
				:: NAME :: Users with More Ranks
				:: VERSION :: 1.0
				:: AUTHOR :: bi0s
				*/
                $query1 = Transaction::query("SELECT * FROM users ORDER BY rank DESC LIMIT 4");
                while ($row    = Transaction::fetch($query1))
                    {
                    $query2 = Transaction::query("SELECT * FROM users WHERE id = '" . $row['id'] . "' ORDER BY username ASC LIMIT 4");
                    while ($row2   = Transaction::fetch($query2))
                        {
                        if ($row2['rank'] == "1")
                            {
                            $ranq = 'Membro';
                            } if ($row2['rank'] == "2")
                            {
                            $ranq = 'VIP';
                            } if ($row2['rank'] == "3")
                            {
                            $ranq = 'Silver';
                            } if ($row2['rank'] == "4")
                            {
                            $ranq = 'Hobba';
                            } if ($row2['rank'] == "5")
                            {
                            $ranq = 'Moderador';
                            }
                        if ($row2['rank'] == "6")
                            {
                            $ranq = 'Administrador';
                            } if ($row2['rank'] == "7")
                            {
                            $ranq = 'Gerente';
                            } if ($row2['rank'] == "8")
                            {
                            $ranq = 'Diretor';
                            } if ($row2['rank'] == "9")
                            {
                            $ranq = 'Dono';
                            }
                        echo('<a class="th" style="border-radius: 50px;margin-right:6px;height: 92px;width: 90px;overflow: hidden;"><img style="margin-left:9px" data-tooltip class="has-tip" title="' . $row2['username'] . ', com ' . $row2['rank'] . ' (' . $ranq . ')"  src="http://habbo.de/habbo-imaging/avatarimage?figure=' . $row2['look'] . '" data-reveal-id="homeswall" onclick=\'loadHomes("' . $row2['username'] . '")\'></a>&#32;&#32;&#32;');
                        }
                    }
                ?>
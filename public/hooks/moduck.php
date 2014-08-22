                <?php
								/*
				Hooks System 0.1a - mobbo 6.0
				:: NAME :: Users With More Duckets
				:: VERSION :: 1.0
				:: AUTHOR :: bi0s
				*/
                $query1 = Transaction::query("SELECT * FROM users ORDER BY activity_points DESC LIMIT 4");
                while ($row    = Transaction::fetch($query1))
                    {
                    $query2 = Transaction::query("SELECT * FROM users WHERE id = '" . $row['id'] . "' ORDER BY username ASC LIMIT 4");
                    while ($row2   = Transaction::fetch($query2))
                        {
                        echo('<a class="th" style="border-radius: 50px;margin-right:6px;height: 92px;width: 90px;overflow: hidden;"><img style="margin-left:9px" data-tooltip class="has-tip" title="' . $row2['username'] . ', com ' . $row2['activity_points'] . ' duckets"  src="http://habbo.de/habbo-imaging/avatarimage?figure=' . $row2['look'] . '" data-reveal-id="homeswall" onclick=\'loadHomes("' . $row2['username'] . '")\'></a>&#32;&#32;&#32;');
                        }
                    }
                ?>
<?php
 				/*
				Hooks System 0.1a - mobbo 6.0
				:: NAME :: Badges of Home
				:: VERSION :: 1.0
				:: AUTHOR :: bi0s
				*/
$query  = Transaction::query("SELECT * FROM users WHERE username = '" . $geter . "' LIMIT 1");
$fetch  = Transaction::fetch($query);
$id     = $fetch['id'];
$query1 = Transaction::query("SELECT * FROM user_badges WHERE user_id = '" . $id . "' ORDER BY id DESC LIMIT 5");
while ($row    = Transaction::fetch($query1))
    {
    if (preg_match('/ACH/', $row['badge_id']))
        {
        echo('<a class="th"><img data-tooltip class="has-tip" title="' . $row['badge_id'] . '"  src="http://images.habbo.com/c_images/album1584/' . $row['badge_id'] . '.gif"></a>&#32;&#32;&#32;');
        }
    else
        {
        echo('<a class="th"><img data-tooltip class="has-tip" title="' . $row['badge_id'] . '"  src="http://images.habbo.com/c_images/album1584/' . $row['badge_id'] . '.gif"></a>&#32;&#32;&#32;');
        }
    }
?>
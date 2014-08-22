<?php
 				/*
				Hooks System 0.1a - mobbo 6.0
				:: NAME :: Mobbo News System
				:: VERSION :: 1.0
				:: AUTHOR :: bi0s
				*/
?>
<div class="large-12 columns" id="numero2">
    <br>
    <h4>[{(43)}]</h4><br>
    <ul class="example-orbit-content" data-orbit>
        <?php
        $query_display = Transaction::query("SELECT * FROM mobbo_news");
        $row_news      = Transaction::num_rows($query_display);
        if ($row_news == 0)
            {
            echo(' ');
            };
        $query = Transaction::query("SELECT * FROM mobbo_news ORDER BY published DESC LIMIT 4");

        $c = 0;

        while ($row = Transaction::fetch($query))
            {
            $display = 'block';

            if ($c > 0)
                {
                $display = 'none';
                }
            $imagem = $row['image'];
            if (strpos($imagem, "#") !== false)
                {
                $background = 'background:' . $imagem . ';';
                }
            else
                {
                $background = 'background:url(' . $imagem . ');';
                }

            echo '
 <li data-orbit-slide="headline-1">
    <div style="' . $background . 'background-position-y:-4px;border-radius:0px;">
      <h2> ' . $row["title"] . ' </h2>
      <h3> ' . $row["shortstory"] . '</h3>
	  <a href="#" style="float:right" data-reveal-id="new_' . $row["id"] . '" class="radius button">Leia Mais…</a>
	  <br><br><br>
    </div>
  </li>							 
  ';
            $c++;
            }
        ?>
    </ul>
    <?php
    $query_display = Transaction::query("SELECT * FROM mobbo_news");
    $row_news      = Transaction::num_rows($query_display);
    if ($row_news == 0)
        {
        echo(' ');
        };
    $query = Transaction::query("SELECT * FROM mobbo_news ORDER BY published DESC LIMIT 4");

    $c = 0;

    while ($row = Transaction::fetch($query))
        {
        $display = 'block';

        if ($c > 0)
            {
            $display = 'none';
            }
        $imageme = $row['image'];
        if (strpos($imageme, "#") !== false)
            {
            $backgrounde = 'background:' . $imageme . ' !important;';
            }
        else
            {
            $backgrounde = 'background:url(' . $imageme . ') !important;';
            }
        echo '
  <div id="new_' . $row["id"] . '" class="reveal-modal xlarge" data-reveal>
  <div class="interior-header green" id="lolca" style="margin-top: -30px;height: 110px !important;background:#eee;background-position-y: -4px !important;">
            <div class="row">
              <div class="large-12 columns">
                   <a class="sidebar-button show-for-small" id="sidebarButton" href="#sidebar" style="display: initial !important;"> <h4 style="font-weight: lighter;color: white;font-size: 36px;margin-top: 40px;">' . $row["title"] . '</h4></a>
                </div>
            </div>
        </div>
<div class="row" style="margin-top: -1px;width: 100%;max-width: 100%;">
<div class="panel callout" style="width: 100%;"><h3 style="">história</h3><br><br><p style="font-weight:lighter;">' . $row["longstory"] . '</p></div></div>
     
	 <br>
	 <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=188976921264081";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>
<div class="row" style="max-width: 100%;width: 100%;margin-left: 0px;">
<div class="large-12 columns" style="margin-top: -37px;width: 100%;max-width: 100%;padding: 0px;">
<div class="panel" style="background-color: #e9e9e9;"><br><h4>Comente</h4><br>
<div class="fb-comments" data-href="http://m0vame.com.br/mobbo/' . $sitename . '/' . $row['id'] . '" data-width="900" data-numposts="5" data-colorscheme="light"></div></div>
</div></div>
	 <br><br>
    <a class="close-reveal-modal">&#215;</a>
</div>
   ';
        $c++;
        }
    ?>
</div>

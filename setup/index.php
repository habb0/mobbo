<?php
include_once('../CORE.php');

if (!file_exists(SERVERE . '/setup/trava.php'))
    {

    setlocale(LC_ALL, 'pt_BR.utf8');
    header('Content-Type: text/html; charset=UTF-8');
    if (isset($_POST['language']))
        {
        $lang               = $_POST['language'];
        $mensagem5          = "\r\n";
        $mensagem2          = "[language of the hotel] \r\n";
        $mensagem           = "language = $lang \r\n";
        $mensagem3          = "[mysql configuration] \r\n";
        $mensagem5          = "\r\n";
        $log                = fopen(SERVERE . "/settings.ini", "a+");
        fwrite($log, $mensagem5);
        fwrite($log, $mensagem2);
        fwrite($log, $mensagem);
        fwrite($log, $mensagem3);
        fwrite($log, $mensagem5);
        $_SESSION['langer'] = 12;
        }
    if (!isset($_SESSION['langer']))
        {
        ?>
        <html class=" js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms no-csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" lang="en" data-useragent="Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36" style=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>mobbo - setup</title>

                <meta name="author" content="m0vame.com.br - bi0s">
                <meta name="copyright" content="PowerPíxel Fórum (c) 2014">
                <link rel="stylesheet" href="./gallery/css/foundation.css" />
                <link rel="stylesheet" href="./gallery/css/cms.css" />
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
                <link type="text/css" rel="stylesheet" href="./gallery/css/marketing.css">
            </head>
            <body>
                <div class="row">
                    <form method="post">
                        <div class="large-12 columns">
                            <br><h4>Select your Language</h4><br> 
                            <p> Select the Language of the CMS (This Language goes the default of the CMS)</p>
                            <select name="language" class="dateselector">
                                <option value="">Select The Language</option>
                                <option value="pt_BR">Portuguese</option>
                                <option value="en_US">English</option>
                                <option value="es_ES">Spanish</option>
                            </select>
                            <input type="submit" class="small button success" value="Select"/>
                        </div>
                    </form>
                </div>

                <script src="./gallery/web-gallery/js/foundation.min.js"></script>
                <script src="./gallery/web-gallery/js/foundation/foundation.joyride.js"></script>
                <script src="./gallery/web-gallery/js/foundation/foundation.clearing.js"></script>
                <script src="./gallery/web-gallery/js/vendor/jquery.cookie.js"></script>
                <script>
                    $ (document).foundation ();
                    $ (document).foundation ('joyride', 'start');</script>
            </body>
        </html>		
        <?php
        }
    else
        {

        // start the translation system

        Translation::setLanguage($language);
        Security::ddosprotect();
        $hosting = 'http://' . $_SERVER['HTTP_HOST'];
        ?>
        <html>
            <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>mobbo - setup</title>
                <meta name="author" content="ZURB, inc. ZURB network also includes zurb.com">
                <meta name="copyright" content="ZURB, inc. Copyright (c) 2013">
                <link rel="stylesheet" href="./gallery/css/foundation.css" />
                <link rel="stylesheet" href="./gallery/css/cms.css" />
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
                <script src="./gallery/js/modernizr.js"></script>
                <link type="text/css" rel="stylesheet" href="./gallery/css/marketing.css">
                <link rel="stylesheet" type="text/css" href="./gallery/css/css">
                <script type="text/javascript">

                    jQuery (document).ready (function ($) {
                        var $form = $ ('#okay');
                        $form.submit (function (event) {
                            $.ajax ({
                                type: 'POST',
                                url: './install.php',
                                data: $form.serialize (),
                                success: function (data) {

                                    if (data == 'TudoCertoTudoCerto') {
                                        window.top.location.href = '/setup/welcome.php';
                                    } else {
                                        $ ('#mensagem').html (data + '<a href="#" class="close">&times;</a>');
                                        $ ('#mensagem2').html (data + '<a href="#" class="close">&times;</a>');
                                        $ ('#sucha').show ();
                                    }
                                }
                            });
                            event.preventDefault;
                            return false;
                        });
                    });
                </script>
                <script>
                    $ (document).ready (function () {
                        $ ("#sucha").click (function () {
                            $ ('#mensagem').html ('Installing Mobbo Wait Please.. This can take 15minutes');
                            $ ('#mensagem2').html ('Installing Mobbo Wait Please.. This can take 15minutes');
                            $ ('#sucha').hide ();
                        });
                    });
                </script>
            </head>
            <body>
                <nav class="top-bar" data-topbar>
                    <ul class="title-area">
                        <li class="name">
                            <h1><a href="#">mobbo</a></h1>
                        </li>
                    </ul>

                    <section class="top-bar-section">
                        <!-- Right Nav Section -->
                        <ul class="right">
                            <li class="active"><a href="#">Setup</a></li>
                        </ul>

                        <!-- Left Nav Section -->
                        <ul class="left">
                            <li><a href="#">v6.0</a></li>
                        </ul>
                    </section>
                </nav>
                <div class="row">
                    <form method="post" name="okay" id="okay">
                        <div class="large-12 columns">
                            <br><h4>Setup</h4><h5> Acesse www.power-pixel.net</h5><br>
                            <div id="mensagem" data-alert class="alert-box"><?php echo _t(1); ?> <a href="#" class="close">&times;</a></div>
                            <dl class="accordion" id="setupovo" data-accordion>
                                <dd>
                                    <a href="#panel0"><?php echo _t(2); ?></a>
                                    <div id="panel0" class="content active">
                                        <div class="panel">
                                            <h5><?php echo _t(2); ?></h5>
                                            <p> <?php echo _t(3); ?></p>
                                        </div>
                                    </div>
                                </dd>
                                <dd>
                                <dd>
                                    <a href="#panel1"><?php echo _t(4); ?></a>
                                    <div id="panel1" class="content">
                                        <div class="panel">
                                            <input type="hidden" name="hosts" value="1"/>
                                            <h5><?php echo _t(5); ?></h5>
                                            <p><?php echo _t(6); ?></p>
                                            <input type="text" name="host" placeholder="Eg: localhost" maxlenght="100"/>
                                            <p><?php echo _t(7); ?></p>
                                            <input type="text" name="host_user" placeholder="Eg: root" maxlenght="100"/>
                                            <p><?php echo _t(8); ?></p>
                                            <input type="password" name="host_pass" placeholder="Eg: pass" maxlenght="100"/>
                                            <p><?php echo _t(9); ?></p>
                                            <input type="text" name="host_db" placeholder="Eg: db" maxlenght="100"/>
                                            <p><?php echo _t(23); ?></p>
                                            <select name="host_type">
                                                <option value="mysql">MySQL</option>
                                                <option value="pgsql">PostGreSQL</option>
                                                <option value="oci8">Oracle</option>
                                                <option value="ibase">IBM DB2</option>
                                                <option value="mssql">Microsoft SQL Server</option>
                                                <option value="sqlite">SQLite</option>
                                            </select>
                                            <p><?php echo _t(24); ?></p>
                                            <input type="text" name="host_port" placeholder="Eg: 3306" maxlenght="100"/>
                                        </div>
                                    </div>
                                </dd>
                                <dd>
                                    <a href="#panel2"><?php echo _t(10); ?></a>
                                    <div id="panel2" class="content">
                                        <div class="panel">
                                            <input type="hidden" name="accounts" value="1"/>
                                            <h5><?php echo _t(11); ?></h5>
                                            <p><?php echo _t(12); ?></p>
                                            <input type="text" name="user_name" placeholder="Eg: admin" maxlenght="100"/>
                                            <p><?php echo _t(13); ?></p>
                                            <input type="password" name="user_pass" placeholder="Eg: senha" maxlenght="100"/>
                                            <p><?php echo _t(14); ?></p>
                                            <input type="text" name="user_rank" placeholder="Eg: 7(recomended)" maxlenght="10"/>
                                        </div>
                                    </div>
                                </dd>
                                <dd>
                                    <a href="#panel3"><?php echo _t(15); ?></a>
                                    <div id="panel3" class="content">
                                        <div class="panel">
                                            <h5><?php echo _t(16); ?></h5>
                                            The Template in Setup its only the Default Theme
                                        </div>
                                    </div>
                                </dd>
                                <dd>
                                    <a href="#panel4"><?php echo _t(18); ?></a>
                                    <div id="panel4" class="content">
                                        <div class="panel">
                                            <input type="hidden" name="basics" value="1"/>
                                            <h5><?php echo _t(19); ?></h5>
                                            <p><?php echo _t(20); ?></p>
                                            <select name="client">
                                                <option value="phoenix">Client Phoenix</option>
                                                <option value="atom">Client Atom/Butterstorm</option>
                                                <option value="bcstorm">Client BCSTORM</option>
                                                <option value="fstorm">Client fStorm/rStorm</option>
                                                <option value="fstorm2">Client Illumina</option>
                                                <option value="fstorm3">Client SwiftEmu/Plus</option>
                                            </select>
                                            <p><?php echo _t(21); ?></p>
                                            <input type="text" name="hotel_name" placeholder="Eg: mobbo" maxlenght="100"/>
                                            <p>Host</p>
                                            <input type="text" name="host_url" value="<?php echo $hosting; ?>" maxlenght="100"/>
                                            <p><?php echo _t(22); ?></p>
                                        </div>
                                    </div>
                                    <h4><?php echo _t(25); ?></h4>
                                    <br><input id="sucha" type="submit" class="small button success" value="Install"/>
                                    <div id="mensagem2" data-alert class="alert-box"><?php echo _t(0); ?> <a href="#" class="close">&times;</a></div>

                                </dd>
                            </dl>
                        </div>
                    </form>
                </div>
                <script src="./gallery/js/foundation.min.js"></script>
                <script>
                    $ (document).foundation ();
                </script>
            </body>
        </html>
        <?php
        }
    }?>
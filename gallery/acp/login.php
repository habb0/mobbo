<?php
if ($hkzone !== true)
    {
    header("Location: index.php?throwBack=true");
    exit;
    }
if (mobbo::session_is_registered(acp))
    {
    header("Location: index.php?loginThrowBack=true");
    exit;
    }


$pagename = "Login";
$pageid   = "login";


if (isset($_POST['username']))
    {


    $form_name  = addslashes($_POST['username']);
    $form_pass  = mobbo::HoloHash($_POST['password']);
    $form_pass2 = mobbo::HoloHashMD5($_POST['password']);
    $form_code  = $_POST['codeword'];


    $check = Transaction::query("SELECT * FROM users WHERE username = '" . $form_name . "' AND password = '" . $form_pass . "' AND rank > 3 or username = '" . $form_name . "' AND password = '" . $form_pass2 . "' AND rank > 3 LIMIT 1");
    $valid = Transaction::num_rows($check);


    if (!empty($form_name) && !empty($form_pass))
        {
        if ($valid > 0)
            {
            $row = Transaction::fetch($check);


            $_SESSION['acp']        = true;
            $_SESSION['hkusername'] = $row['username'];
            $_SESSION['hkpassword'] = $form_pass2;
            $_SESSION['hkcode']     = $form_code;


            $my_id = $row['id'];


            if (!mobbo::session_is_registered(username))
                {
                $_SESSION['username'] = $row['username'];
                $_SESSION['password'] = $form_pass2;
                $_SESSION['code']     = $form_code;
                }


            Transaction::query("UPDATE users SET ip_last = '" . $remote_ip . "' WHERE id = '" . $row['id'] . "' LIMIT 1");
            Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Login (IP: " . $remote_ip . ")','login.php','" . $my_id . "','0','" . $date_full . "')");
            if ($_POST['headerclient'] == true)
                {
                header("location: $path/client");
                exit;
                }
            else
                {
                header("location: " . $adminpath . "/p/home");
                exit;
                }
            }
        else
            {
            $msg = "Nome de usuario, senha o Habbo ID incorrectos.";
            header("location: " . $adminpath . "/p/login");
            }
        }
    else
        {
        $msg = "Voc deve preencher todos os campos!";
        }
    }
elseif ($notify_logout == true)
    {
    Transaction::query("INSERT INTO stafflogs (action,message,note,userid,targetid,timestamp) VALUES ('Housekeeping','Logout','notify_logout','" . $my_id . "','0','" . $date_full . "')");
    $msg = "<font color='green'>Voc foi desconectado corretamente.</font>";
    }
else
    {
    $msg = "Faa o login";
    }


include('subheader.php');
?>
<style type="text/css">
    body {
        background-color: #fff


    }
    #fudeugeral {
        display:none;
        visibility:hidden;
    }
</style>


<div id='ipdwrapper'>
    <div align='center'>
        <br><br><br>
        <br>
        <div class='row'>
            <div class='small-2 large-8 columns'>
                <div class='panel'><!-- OUTERDIV -->

                    <form id='loginform' action='<?php echo $adminpath; ?>/p/login&do=submit' method='post'>

                        <?php
                        if ($notify_login !== "login")
                            {
                            ?>
                            <div class='small-2 large-6 columns'>
                                <p>Nome de usuário</p>
                                <input  type='text' size='25' name='username' id='namefield' value='' />
                            </div>

                            <div class='small-2 large-6 columns'>
                                <p>Senha</p>
                                <input  type='password' size='25' name='password' value='' />
                            </div>

                            <input type='submit'class='button smal success radius' value='Entrar' />
                        <?php } ?>

                </div>
            </div><div class='small-2 large-4 columns'>
                <div class='panel radius' style='background-color:white;'><h3>Welcome</h3>
                    <br/><p>Aqui é o Painel somente autorizados entram</p><img src="http://www.zuninojr.com/images/cadeado.png" alt='oi'/></div>
            </div></div>
        <script type='text/javascript'>
            if (top.location != self.location) {
                top.location = self.location
            }

            try
            {
                window.onload = function () {
                    document.getElementById ('namefield').focus ();
                }
            }
            catch (error)
            {
                alert (error);
            }

        </script>
        <?php include_once('footer.php'); ?>
 <?php
  				/*
				Hooks System 0.1a - mobbo 6.0
				:: NAME :: Admin Reffers
				:: VERSION :: 1.0
				:: AUTHOR :: bi0s
				*/
        if (mobbo::users_info('rank') >= 6)
            {
            ?>
            <div class="large-6 columns">
                <div class="panel">
                    <h4>Admin</h4>
                    <h5>Admin, se você quiser checar a quantidade de referidos de alguem coloque o nome dele a seguir</h5>
                    <form method="post">
                        <input type="text" name="usernameCheck" maxlenght="100" placeholder="Digite o Nome Aqui"/><input type="submit" value="Checar" class="button tiny success radius small"/>
                    </form>
                </div>
                <div class="panel"><br>
                    <h4>Seus Doláres</h4><br>
                    <h5 align="center">você tem <span style="font-size:x-large;"><?php echo mobbo::users_info('dolares'); ?></span> Doláres</h5>
                </div>
            </div>
        <?php } ?>
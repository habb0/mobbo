 <?php
  				/*
				Hooks System 0.1a - mobbo 6.0
				:: NAME :: Reffers of a User
				:: VERSION :: 1.0
				:: AUTHOR :: bi0s
				*/
                $query = Transaction::query("SELECT * FROM users_referidos WHERE usuario = '" . mobbo::users_info('username') . "'");
                $rows  = Transaction::num_rows($query);
                if ($rows == NULL or $rows == 0)
                    {
                    $rows = "Nenhum";
                    }
                ?>
                <h5 align="center">você tem <span style="font-size:x-large;"><?php echo $rows; ?></span> Referido(s)</h5>
                <?php
                if ($rows > 0)
                    {
                    ?>

                    <a href="#" class="button tiny success radius alert" data-dropdown="drop2">Trocar Referidos por Doláres</a>
                    <div id="drop2" class="f-dropdown content medium" data-dropdown-content>
                        <h4>Compras</h4>
                        <p>Atenção se você tiver 5 Referidos, Ganha 1 Dolar, se Você tiver 10 Referidos Ganha 2 Dolares, Assim Vai Adiante até 40 Referidos Que Ganha 8 Dolares, Se Você tiver 40 Referidos Automaticamente Ganha 8 Dolares, não Há como Escolher a Opção de Trocar 5 Referidos, Se você tiver mais de 40 Referidos basta Apenas Trocar Mais Uma Vez, E Assim Por Diante.</p>
                        <p>Grato, A Direção.</p>
                        <a class="button tiny success radius" href="/loja?buy=dolares">Trocar Os Seus Referidos por Doláre(s)</a>
                    </div>   
                    <?php
                    }
                ?>
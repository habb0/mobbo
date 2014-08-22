<?php
 				/*
				Hooks System 0.1a - mobbo 6.0
				:: NAME :: Message from Home
				:: VERSION :: 1.0
				:: AUTHOR :: bi0s
				*/
if (mobbo::mobbo_settings('maintenance') == 1)
    {
    ?>
    <div data-alert class="alert-box alert">
        [{(33)}]
        <a href="#" class="close">&times;</a>
    </div>
<?php } ?>
<div data-alert class="alert-box success">
    Olá, [{(34)}]
    <?php
    date_default_timezone_set("Brazil/East");
    $meses           = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
    $diasdasemana    = array(1 => "Segunda-Feira", 2 => "Terça-Feira", 3 => "Quarta-Feira", 4 => "Quinta-Feira", 5 => "Sexta-Feira", 6 => "Sábado", 0 => "Domingo");
    $hoje            = getdate();
    $dia             = $hoje["mday"];
    $mes             = $hoje["mon"];
    $nomemes         = $meses[$mes];
    $ano             = $hoje["year"];
    $diadasemana     = $hoje["wday"];
    $nomediadasemana = $diasdasemana[$diadasemana];
    echo " $nomediadasemana, $dia de $nomemes e são: ";
    $timestamp       = time();
    $hora            = date("H", $timestamp);
    $minutos         = date("i", $timestamp);
    echo ("$hora Horas e $minutos minutos");
    ?>
    <a href="#" class="close">&times;</a>
</div>
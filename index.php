<?php
include 'vendor/autoload.php';

$redeNeural = new RedeNeural\RedeNeural();
$redeNeural->treinar();

$resultados = $redeNeural->classificar();

//Exibe resultado da classificação
foreach($resultados as $resultado){
    
    echo '<p>';
        $string = str_split($resultado->getStringArquivo(),5);
        echo implode('<br>',$string);
        echo '<br>'.$redeNeural->determinarClassificacao($resultado->getDadoSaida());
    echo '</p>';   
}

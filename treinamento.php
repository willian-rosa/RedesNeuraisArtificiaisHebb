<?php
include 'vendor/autoload.php';

$redeNeural = new RedeNeural\RedeNeural();
$redeNeural->treinar();


$resultados = $redeNeural->classificar();

foreach($resultados as $resultado){
    
    $string = str_split($resultado->getStringArquivo(),5);
    echo implode('<br>',$string);
    
    echo $redeNeural->determinarClassificacao($resultado->getDadoSaida());
    d($resultado);
    
    
}
<?php
include 'vendor/autoload.php';

$isCli		= (php_sapi_name() == 'cli');
$lineBreak	= ($isCli)?PHP_EOL:'<br>';

$redeNeural = new RedeNeural\RedeNeural();
$redeNeural->treinar();

$resultados = $redeNeural->classificar();



//Exibe resultado da classificação
foreach($resultados as $resultado){
    
    echo ($isCli)?PHP_EOL:'<p>';
        $string = str_split($resultado->getStringArquivo(),5);
        echo implode($lineBreak,$string);
        echo $lineBreak.$redeNeural->determinarClassificacao($resultado->getDadoSaida());
    echo ($isCli)?PHP_EOL:'</p>';
}

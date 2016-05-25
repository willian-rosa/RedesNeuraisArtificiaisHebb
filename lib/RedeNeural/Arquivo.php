<?php
namespace RedeNeural;

class Arquivo{
    
    private $caminhoPasta;
    
    public function __construct(){
        $this->caminhoPasta = dirname(dirname(dirname(__FILE__)));
    }
    
    private function buscarConteudoArquivo($nomeArquivo){
        $conteudo = '';
                
        //Abre arquivo
        $arquivo = fopen ($this->caminhoPasta.$nomeArquivo, "r");
        
        if($arquivo){
            //Read file, line to line
            while (!feof ($arquivo)) {
                //Read one line
                $conteudo.= trim(fgets($arquivo, 4096));        
            }
            //Close$arquivo
            fclose ($arquivo);
        }
        
        return $conteudo;
    }
    
    private function scanear($pastaSelecionada){
        
        $pasta = $this->caminhoPasta.$pastaSelecionada;
        
        $arquivos = scandir($pasta);
        return array_diff($arquivos, array('..', '.'));
    }
    
    public function buscarArquivosTreinamento(){
        
        $pasta = '/treino/';
        $arquivos = $this->scanear($pasta);
        
        
        $entradas = array();
        
        foreach($arquivos as $arquivo){
            $entradas[] = $this->buscarConteudoArquivo($pasta.$arquivo);
        }
        
        return $entradas;
        
    }
    
    public function buscarArquivosClassificacao(){
        
        $pasta = '/classificacao/';
        
        $arquivos = $this->scanear($pasta);
        
        $entradas = array();
                
        foreach($arquivos as $arquivo){
            $entradas[] = $this->buscarConteudoArquivo($pasta.$arquivo);
        }
        
        return $entradas;
    }
        
}
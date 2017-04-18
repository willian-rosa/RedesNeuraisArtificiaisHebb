<?php
namespace RedeNeural;

class RedeNeural{
    
    private $pesos = array();
    
    private function converteCaracterEmValor($caracter){
        if($caracter == '#'){
            return -1;
        }elseif($caracter == '.'){
            return 1;
        }
        
        return 0;
        
    }
    
    private function popularSaidaNeuronio(Neuronio $neuronio, $arquivo){
        //Verifica se encontro a tag var no arquivo
        if(preg_match('/^valor="(.*)"/', $arquivo, $saida)){
            $valor = end($saida);
            $neuronio->setDadoSaida($valor);
        }
        
        return $neuronio;
        
    }
    
    private function popularEntradaNeuronio(Neuronio $neuronio, $arquivo){
        
        //renove tag da string
        $strinfEntrada = preg_replace('/^valor="(.*)"/', '', $arquivo);
        
        //Explode a string em array
        $caracterEntradas = str_split($strinfEntrada);
        
        foreach($caracterEntradas as $caracter){
            $neuronio->addDadoEntrada($this->converteCaracterEmValor($caracter));
        }
                
        return $neuronio;
        
    }
    
    //função Soma
    private function somar($neuronio){
        $soma = 0;
        foreach($neuronio->getDadosEntrada() as $indice => $entrada){
            $soma = $soma + ($this->pesos[$indice] * $entrada);
        }
        return $soma;
    }
    
    //Algoritmo de Hebb
    private function treinarRede(array $neuronios){
        foreach($neuronios as $neuronio){
            
            //Para cada vetor de treinamento faça
            foreach($neuronio->getDadosEntrada() as $indice => $entrada){
                
                //Ajustar pesos
                $pesosAntigo = isset($this->pesos[$indice])?$this->pesos[$indice]:0; 
                
                $this->pesos[$indice] = $pesosAntigo + ($entrada * $neuronio->getDadoSaida());
                                
            }
        }
                
    }
    
    //função de Transferência
    public function determinarClassificacao($soma){
        if($soma>=1){
            return 'Letra X';
        }elseif($soma<=-1){
            return 'Letra O';
        }
        
        return 'Indeterminado';
        
    }
    
    public function treinar(){
        
        //busca arquivos de treinamento
        $arquivo = new Arquivo();
        $arquivos = $arquivo->buscarArquivosTreinamento();
        
        //converte os arquivos em neuronios
        $neuronios = array();
        foreach($arquivos as $arquivo){
            $neuronio = new Neuronio();
            
            $this->popularSaidaNeuronio($neuronio, $arquivo);
            $this->popularEntradaNeuronio($neuronio, $arquivo);
            $neuronios[] = $neuronio;
        }
        
        $this->treinarRede($neuronios);
        
    }
    
    public function classificar(){
        
        $arquivo = new Arquivo();
        $arquivos = $arquivo->buscarArquivosClassificacao();
        
        $neuronios = array();
        
        foreach($arquivos as $arquivo){
            
            $neuronio = new Neuronio();
            
            $neuronio->setStringArquivo($arquivo);
            
            $this->popularEntradaNeuronio($neuronio, $arquivo);
            $soma = $this->somar($neuronio);
            
            $neuronio->setDadoSaida($soma);
            $resultadoClassificacao = $this->determinarClassificacao($soma);
            
            
            $neuronios[] = $neuronio;
            
        }
        
        return $neuronios;
        
    }
}
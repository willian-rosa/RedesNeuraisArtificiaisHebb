<?php
namespace RedeNeural;

class Neuronio{
    
    private $stringArquivo;
    private $dadoSaida;
    private $dadosEntrada = array();
    
    public function getDadoSaida(){
        return $this->dadoSaida;
    }
    
    /**
    * @return array
    */
    public function getDadosEntrada(){
        return $this->dadosEntrada;
    }
    
    public function setDadoSaida($dadoSaida){
        $this->dadoSaida = $dadoSaida;
    }
    
    public function setDadosEntrada(array $dadosEntrada){
        $this->dadosEntrada = $dadosEntrada;
    }
    
    public function addDadoEntrada($dado){
        $this->dadosEntrada[] = $dado;
    }
    
    public function setStringArquivo($stringArquivo){
        $this->stringArquivo = $stringArquivo;
    }
    
    public function getStringArquivo(){
        return $this->stringArquivo;
    }
    
} 
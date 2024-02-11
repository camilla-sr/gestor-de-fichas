<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tendencias extends CI_Controller{
    private $json;
    private $resultado;
    
    private $idTend;            #o que identifica a tendência no sistema
    private $tendencia;         #o nome da tendência

    //Getters e Setters
    public function getIdTend(){
        return $this->idTend;
    }

    public function setIdTend($idTendFront){
        $this->idTend = $idTendFront;
    }

    public function getTendencia(){
        return $this->tendencia;
    }

    public function setTendencia($tendenciaFront){
        $this->tendencia = $tendenciaFront;    
    }

    public function inserirTendencias(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('tendencia' => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setTendencia($resultado->tendencia);

            if($strlen($this->getTend()) == 0){
                $retorno = array('codigo' => 08,
                                 'msg'    => 'Tendência não informada');
            }elseif(is_numeric($this->getTend()) == True){
                $retorno = array('codigo' => 09,
                                 'msg'    => 'Nome da tendência não condiz com o permitido');
            }else{
                $this->load->model('M_tendencias');
                $retorno = $this->M_tendencias->inserirTendencia($this->getTendencia());
            }
        }else{
            $retorno = array('codigo' => 999,
                             'msg'    => 'Campos do front não condiz com o permitido');
        }
            echo json_encode($retorno);
    }

    public function atualizarTendencias(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idTend'    => '0'
                       'tendencia' => '0');
    
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdTend($resultado->idTend);
            $this->setTendencia($resultado->tendencia);

            if(strlen($this->getIdTend()) == 0){
                $retorno = array('codigo' => 10,
                                 'msg'    => 'ID da tendência não informada');
            }elseif(is_string($this->getTendencia()) == True) {
                $retorno = array('codigo' => 11,
                                 'msg'    => 'ID da tendência não condiz com o permitido');
            }else{
                $this->load->model('M_tendencias');
                $retorno->$this->M_tendencias->atualizarTendencias($this->getIdTend(), $this->getTendencia());
            }
        }else{
            $retorno = array('codigo' => 999,
                             'msg'    => 'Campos do front não condiz com o permitido');
        }
            echo json_encode($retorno);
    }
}


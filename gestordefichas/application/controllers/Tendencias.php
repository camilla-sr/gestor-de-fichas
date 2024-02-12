<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tendencias extends CI_Controller{
    private $json;
    private $resultado;
    
    private $idTend;
    private $tendencia;

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

            if(strlen($this->getTendencia()) == 0){
                $retorno = array('codigo' => 8,
                                 'msg'    => 'Tendência não informada');
            }elseif(is_numeric($this->getTend()) == True){
                $retorno = array('codigo' => 9,
                                 'msg'    => 'Nome da tendência não condiz com o permitido');
            }else{
                $this->load->model('M_tendencias');
                $retorno = $this->M_tendencias->inserirTendencia($this->getTendencia());
            }
        }else{
            $retorno = array('codigo' => 999,
                             'msg'    => 'Campos do front não condizem com o permitido');
        }
            echo json_encode($retorno);
    }

    public function atualizarTendencias(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idTend'    => '0',
                       'tendencia' => '0');
    
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdTend($resultado->idTend);
            $this->setTendencia($resultado->tendencia);

            if(strlen($this->getIdTend()) == 0){
                $retorno = array('codigo' => 10,
                                 'msg'    => 'ID da tendência não informada');
            }elseif(is_string($this->getIdTend()) == true) {
                $retorno = array('codigo' => 11,
                                 'msg'    => 'ID da tendência não condiz com o permitido');
            }elseif(strlen($this->getTendencia()) == 0){
                $retorno = array('codigo' => 12,
                                 'msg'    => 'Tendência não informada');
            }elseif(is_numeric($this->getTendencia()) == true){
                $retorno = array('codigo' => 13,
                                 'msg'    => 'Tendência não condiz com o permitido');
            }else{
                $this->load->model('M_tendencias');
                $retorno->$this->M_tendencias->atualizarTendencias($this->getIdTend(), $this->getTendencia());
            }
        }else{
            $retorno = array('codigo' => 999,
                             'msg'    => 'Campos do front não condizem com o permitido');
        }
            echo json_encode($retorno);
    }

    public function apagarTendencias(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idTend' => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setIdTend($resultado->idTend);
        
            if(strlen($this->getIdTend()) == 0){
                $dados = array('codigo' => ,
                               'msg'    => 'ID da tendência não informado');
            }elseif(is_string($this->getIdTend()) == true){
                $dados = array('codigo' => ,
                                'msg'   => 'ID da tendência não condiz com o permitido');
            }else{
                $this->load->model('M_tendencias');
                $retorno = $this->M_tendencias->apagarTendencias($this->getIdTend());
            }
        }else{
            $dados = array('codigo' => 999,
                           'msg'    => 'Campos do front não condizem com o permitido');
       }
    }
}   


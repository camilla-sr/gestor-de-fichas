<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tendencia extends CI_Controller{
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

    public function inserirTendencia(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('tendencia' => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setTendencia($resultado->tendencia);

            if(strlen($this->getTendencia()) == 0){
                $retorno = array('codigo' => 16,
                                 'msg'    => 'Tendência não informada');
            }elseif(is_numeric($this->getTendencia()) == True){
                $retorno = array('codigo' => 17,
                                 'msg'    => 'Tendência não condiz com o permitido');
            }else{
                $this->load->model('M_Tendencia');
                $retorno = $this->M_Tendencia->inserirTendencia($this->getTendencia());
            }
        }else{
            $retorno = array('codigo' => 999,
                             'msg'    => 'Campos do front diferentes dos requisitados.');
        }
            echo json_encode($retorno);
    }

    public function consultarTendencia(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idTend'     => '0',
                       'tendencia'  => '0');
        if(verificarParam($resultado,$lista) == 1){
            $this->setIdTend($resultado->idTend);
            $this->setTendencia($resultado->tendencia);
            
            if(is_numeric($this->getIdTend()) == False && $this->getIdTend() != ""){
                $retorno = array('codigo' => 17,
                                'msg' => 'Tendencia não condiz com o permitido');
            }elseif(is_numeric($this->getTendencia()) == True && $this->getTendencia() != ""){
                $retorno = array('codigo' => 17,
                                'msg' => 'Tendência não condiz com o permitido');
            }else{
                $this->load->model('M_Tendencia');
                $retorno = $this->M_Tendencia->consultarTendencia($this->getIdTend(), $this->getTendencia());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => 'Campos do front diferentes dos requisitados.');
        }
        echo json_encode($retorno);
    }

    public function alterarTendencia(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idTend'    => '0',
                       'tendencia' => '0');
    
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdTend($resultado->idTend);
            $this->setTendencia($resultado->tendencia);

            if(strlen($this->getIdTend()) == 0){
                $retorno = array('codigo' => 16,
                                 'msg'    => 'Tendência não informada');
            }elseif(is_numeric($this->getIdTend()) == False) {
                $retorno = array('codigo' => 8,
                                 'msg'    => 'ID não condiz com o permitido');
            }elseif(strlen($this->getTendencia()) == 0){
                $retorno = array('codigo' => 16,
                                 'msg'    => 'Tendência não informada');
            }elseif(is_numeric($this->getTendencia()) == True){
                $retorno = array('codigo' => 17,
                                 'msg'    => 'Tendência não condiz com o permitido');
            }else{
                $this->load->model('M_Tendencia');
                $retorno = $this->M_Tendencia->alterarTendencia($this->getIdTend(), $this->getTendencia());
            }
        }else{
            $retorno = array('codigo' => 999,
                             'msg'    => 'Campos do front diferentes dos requisitados.');
        }
            echo json_encode($retorno);
    }

    public function apagarTendencia(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idTend' => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setIdTend($resultado->idTend);
        
            if($this->getIdTend() == ""){
                $retorno = array('codigo' => 14,
                                'msg'   => 'Nenhum dado selecionado');
            }elseif(is_numeric($this->getIdTend()) == False){
                $retorno = array('codigo' => 17,
                                'msg' => 'Tendência não condiz com o permitido');
            }else{
                $this->load->model('M_Tendencia');
                $retorno = $this->M_Tendencia->apagarTendencia($this->getIdTend());
            }
        }else{
            $retorno = array('codigo' => 999,
                           'msg'    => 'Campos do front diferentes dos requisitados.');
       }
       echo json_encode($retorno);
    }
}   


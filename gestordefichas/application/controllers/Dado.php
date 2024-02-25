<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dado extends CI_Controller{
    private $json;
    private $resultado;

    private $idDado;
    private $tipo;

    // GETTERS E SETTER
    public function getIdDado(){
        return $this->idDado;
    }
    public function setIdDado($idDadoFront){
        $this->idDado = $idDadoFront;
    }
    public function getTipo(){
        return $this->tipo;
    }
    public function setTipo($descricaoFront){
        $this->tipo = $descricaoFront;
    }

    public function inserirDado(){
        $json = file_get_contents("php://input");
        $resultado = json_decode($json);
        $lista = array('tipo'  => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setTipo($resultado->tipo);

            if(strlen($this->getTipo()) == 0){
                $retorno = array('codigo' => 29,
                                'msg' => 'Campo vazio');
            }elseif(strlen($this->getTipo()) <= 1 || strlen($this->getTipo()) > 3){
                $retorno = array('codigo' => 30,
                                'msg' => 'Descrição não condiz com o tamanho permitido');
            }elseif(trim($this->getTipo()) == ""){
                $retorno = array('codigo' => 29,
                                'msg' => 'Campo vazio');
            }else{
                $this->load->model('M_Dado');
                $retorno = $this->M_Dado->inserirDado($this->getTipo());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => "Campos do front diferente dos requisitados");
        }
        echo json_encode($retorno);
    }

    public function consultarDado(){
        $json = file_get_contents("php://input");
        $resultado = json_decode($json);
        $lista = array('idDado'     => '0',
                       'tipo'  => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdDado($resultado->idDado);
            $this->setTipo($resultado->tipo);

            if(is_numeric($this->getIdDado()) == False && $this->getIdDado() != ""){
                $retorno = array('codigo' => 8,
                                'msg' => 'ID não condiz com o permitido');
            }else{
                $this->load->model('M_Dado');
                $retorno = $this->M_Dado->consultarDado($this->getIdDado(), $this->getTipo());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => "Campos do front diferente dos requisitados");
        }
        echo json_encode($retorno);
    }

    public function alterarDado(){
        $json = file_get_contents("php://input");
        $resultado = json_decode($json);
        $lista = array('idDado'     => '0',
                       'tipo'  => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdDado($resultado->idDado);
            $this->setTipo($resultado->tipo);

            if($this->getIdDado() == "" && strlen($this->getTipo()) == 0){
                $retorno = array('codigo' => 28,
                                'msg' => 'Nenhum dado para alteração informado');
            }elseif(strlen($this->getTipo()) == 0){
                $retorno = array('codigo' => 25,
                                'msg' => 'Descrição não informada');
            }elseif(strlen($this->getTipo()) <= 1 || strlen($this->getTipo()) > 3){
                $retorno = array('codigo' => 30,
                                'msg' => 'Descrição não condiz com o tamanho permitido');
            }elseif(is_numeric($this->getIdDado()) == False){
                $retorno = array('codigo' => 8,
                                'msg' => 'ID não condiz com o permitido');
            }else{
                $this->load->model('M_Dado');
                $retorno = $this->M_Dado->alterarDado($this->getIdDado(), $this->getTipo());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => "Campos do front diferente dos requisitados");
        }
        echo json_encode($retorno);
    }

    public function apagarDado(){
        $json = file_get_contents("php://input");
        $resultado = json_decode($json);
        $lista = array('idDado' => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdDado($resultado->idDado);

            if($this->getIdDado() == ""){
                $retorno = array('codigo' => 14,
                                'msg' => 'Nenhum dado selecionado');
            }elseif(is_numeric($this->getIdDado()) == False){
                $retorno = array('codigo' => 8,
                                'msg' => 'ID não condiz com o permitido');
            }else{
                $this->load->model('M_Dado');
                $retorno = $this->M_Dado->apagarDado($this->getIdDado());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => "Campos do front diferente dos requisitados");
        }
        echo json_encode($retorno);
    }
}
?>
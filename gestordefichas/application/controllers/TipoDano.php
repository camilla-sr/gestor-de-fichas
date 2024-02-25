<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TipoDano extends CI_Controller{
    private $json;
    private $resultado;

    private $idDano;
    private $descricao;

    //  GETTERS E SETTERS
    public function getIdDano(){
        return $this->idDano;
    }
    public function setIdDano($idDanoFront){
        $this->idDano = $idDanoFront;
    }
    public function getDescricao(){
        return $this->descricao;
    }
    public function setDescricao($descricaoFront){
        $this->descricao = $descricaoFront;
    }

    public function inserirDano(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('descricao' => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setDescricao($resultado->descricao);

            if(strlen($this->getDescricao()) == 0){
                $retorno = array('codigo' => 25,
                                'msg' => 'Descrição não informada');
            }elseif(is_numeric($this->getDescricao()) == True){
                $retorno = array('codigo' => 32,
                                'msg' => 'Descrição não condiz com o permitido');
            }else{
                $this->load->model('M_TipoDano');
                $retorno = $this->M_TipoDano->inserirDano($this->getDescricao());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => "Campos do front diferente dos requisitados");
        }
        echo json_encode($retorno);
    }

    public function consultarDano(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idDano'     => '0',
                       'descricao' => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdDano($resultado->idDano);
            $this->setDescricao($resultado->descricao);

            if(is_numeric($this->getIdDano()) == False && $this->getIdDano() != ""){
                $retorno = array('codigo' => 8,
                                'msg' => 'ID não condiz com o permitido');
            }else{
                $this->load->model('M_TipoDano');
                $retorno = $this->M_TipoDano->consultarDano($this->getIdDano(), $this->getDescricao());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => "Campos do front diferente dos requisitados");
        }
        echo json_encode($retorno);
    }

    public function alterarDano(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idDano'     => '0',
                       'descricao' => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdDano($resultado->idDano);
            $this->setDescricao($resultado->descricao);

            if(trim($this->getIdDano()) == "" && trim($this->getDescricao()) == ""){
                $retorno = array('codigo' => 28,
                                'msg' => 'Nenhum dado para alteração informado');
            }elseif($this->getIdDano() == ""){
                $retorno = array('codigo' => 23,
                                'msg' => 'ID não informado');
            }elseif(is_numeric($this->getIdDano()) == False){
                $retorno = array('codigo' => 8,
                                'msg' => 'ID não condiz com o permitido');
            }elseif(trim($this->getDescricao()) == ""){
                $retorno = array('codigo' => 25,
                                'msg' => 'Descrição não informada');
            }elseif(is_numeric($this->getDescricao()) == True){
                $retorno = array('codigo' => 32,
                                'msg' => 'Descrição não condiz com o permitido');
            }else{
                $this->load->model('M_TipoDano');
                $retorno = $this->M_TipoDano->alterarDano($this->getIdDano(), $this->getDescricao());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => "Campos do front diferente dos requisitados");
        }
        echo json_encode($retorno);
    }

    public function apagarDano(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idDano' => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdDano($resultado->idDano);

            if($this->getIdDano() == ""){
                $retorno = array('codigo' => 14,
                                'msg' => 'Nenhum dado selecionado');
            }elseif(is_numeric($this->getIdDano()) == False){
                $retorno = array('codigo' => 8,
                                'msg' => 'ID não condiz com o permitido');
            }else{
                $this->load->model('M_TipoDano');
                $retorno = $this->M_TipoDano->apagarDano($this->getIdDano());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => "Campos do front diferente dos requisitados");
        }
        echo json_encode($retorno);
    }
}
?>
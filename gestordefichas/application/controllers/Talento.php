<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Talento extends CI_Controller{
    private $json;
    private $resultado;

    private $idTalento;
    private $talento;
    private $descricao;
    private $requisito;

    public function getIdTalento(){
        return $this->idTalento;
    }
    public function setIdTalento($idTalentoFront){
        $this->idTalento = $idTalentoFront;
    }
    public function getTalento(){
        return $this->talento;
    }
    public function setTalento($talentoFront){
        $this->talento = $talentoFront;
    }
    public function getDescricao(){
        return $this->descricao;
    }
    public function setDescricao($descricaoFront){
        $this->descricao = $descricaoFront;
    }
    public function getRequisito(){
        return $this->requisito;
    }
    public function setRequisito($requisitoFront){
        $this->requisito = $requisitoFront;
    }

    public function inserirTalento(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('talento'    => '0',
                       'descricao'  => '0',
                       'requisito'  => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setTalento($resultado->talento);
            $this->setDescricao($resultado->descricao);
            $this->setRequisito($resultado->requisito);

            if($this->getTalento() == ""){
                $retorno = array('codigo' => 24,
                                'msg' => 'Talento não informado');
            }elseif(is_numeric($this->getTalento()) == True){
                $retorno = array('codigo' => 26,
                                'msg' => 'Talento não condiz com o permitido');
            }elseif($this->getDescricao() == ""){
                $retorno = array('codigo' => 25,
                                'msg' => 'Descrição não informada');
            }else{
                $this->load->model('M_Talento');
                $retorno = $this->M_Talento->inserirTalento($this->getTalento(), $this->getDescricao(), $this->getRequisito());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => 'Campos do front diferentes dos requisitados.');
        }
        echo json_encode($retorno);
    }

    public function consultarTalento(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idTalento'  => '0',
                       'talento'    => '0',
                       'requisito'  => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdTalento($resultado->idTalento);
            $this->setTalento($resultado->talento);
            $this->setRequisito($resultado->requisito);

            if(is_numeric($this->getIdTalento()) == False && $this->getIdTalento() != ""){
                $retorno = array('codigo' => 8,
                                'msg' => 'ID não condiz com o permitido');
            }elseif(is_numeric($this->getTalento()) == True && $this->getTalento() != ""){
                $retorno = array('codigo' => 26,
                                'msg' => 'Talento não condiz com o permitido');
            }else{
                $this->load->model('M_Talento');
                $retorno = $this->M_Talento->consultarTalento($this->getIdTalento(), $this->getTalento(), $this->getRequisito());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => 'Campos do front diferentes dos requisistados.');
        }
        echo json_encode($retorno);
    }
}
?>
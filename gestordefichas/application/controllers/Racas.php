<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Racas extends CI_Controller{
    private $json;
    private $resultado;

    #ATRIBUTOS DE CLASSE
    private $idRaca;            #o que identifica a raça no sistema
    private $raca;              #o nome da raça
    private $deslocamento;      #o deslocamento base (em metros) que a raça tem por turno

    #GETTERS E SETTERS
    public function getIdRaca(){
        return $this->idRaca;
    }
    public function setIdRaca($idRacaFront){
        $this->idRaca = $idRacaFront;
    }
    public function getRaca(){
        return $this->raca;
    }
    public function setRaca($racaFront){
        $this->raca = $racaFront;
    }
    public function getDeslocamento(){
        return $this->deslocamento;
    }
    public function setDeslocamento($deslocFront){
        $this->deslocamento = $deslocFront;
    }

    public function inserirRaca(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array( 'raca'          => '0',
                        'deslocamento'  => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setRaca($resultado->raca);
            $this->setDeslocamento($resultado->deslocamento);

            if(strlen($this->getRaca()) == 0){
                $retorno = array('codigo' => 1,
                                'msg' => 'Raça não informada');
            }elseif(is_numeric($this->getRaca()) == True){
                $retorno = array('codigo' => 3,
                                'msg' => 'Nome da raça não condiz com o permitido');
            }elseif($this->getDeslocamento() == ""){
                $retorno = array('codigo' => 2,
                                'msg' => 'Deslocamento não informado');
            }elseif($this->getDeslocamento() == is_float($this->getDeslocamento())){
                $retorno = array('codigo' => 4,
                                'msg' => 'Deslocamento não condiz com o permitido');
            }else{
                $this->load->model('M_Raca');
                $retorno = $this->M_Raca->inserirRaca($this->getRaca(), $this->getDeslocamento());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg'   => 'Campos do front diferentes dos requisitados.');
        }
        echo json_encode($retorno);
    }

    public function consultarRaca(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idRaca'         => '0',
                        'raca'          => '0',
                        'deslocamento'  => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdRaca($resultado->idRaca);
            $this->setRaca($resultado->raca);
            $this->setDeslocamento($resultado->deslocamento);

            if(is_numeric($this->getIdRaca()) == False && $this->getIdRaca() == 0){
                $retorno = array('codigo' => 8,
                                'msg' => 'Id não condiz com o permitido');
            }elseif(is_string($this->getRaca()) == False && $this->getRaca() == ""){
                $retorno = array('codigo' => 3,
                                'msg' => 'Nome da raça não condiz com o permitido');
            }elseif(is_float($this->getDeslocamento()) == False && $this->getDeslocamento() == 0){
                $retorno = array('codigo' => 4,
                                'msg' => 'Deslocamento não condiz com o permitido');
            }else{
                $this->load->model('M_Raca');
                $retorno = $this->M_Raca->consultarRaca($this->getIdRaca(), $this->getRaca(), $this->getDeslocamento());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => 'Campos do front diferentes dos requisitados.');
        }
        echo json_encode($retorno);
    }

    public function alterarRaca(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idRaca'         => '0',
                        'raca'          => '0',
                        'deslocamento'  => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdRaca($resultado->idRaca);
            $this->setRaca($resultado->raca);
            $this->setDeslocamento($resultado->deslocamento);

            if($this->getIdRaca() != "" && $this->getRaca() == "" && $this->getDeslocamento() == ""){
                $retorno = array('codigo' => 13,
                                'msg' => 'Informe dado para alteração');
            }elseif(is_numeric($this->getIdRaca()) == False){
                $retorno = array('codigo' => 8,
                                'msg' => 'Id não condiz com o permitido');
            }elseif(is_string($this->getRaca()) == False && strlen($this->getRaca()) == 0){
                $retorno = array('codigo' => 3,
                                'msg' => 'Nome da raça não condiz com o permitido');
            }elseif(is_float($this->getDeslocamento()) == False && $this->getDeslocamento() == ""){
                $retorno = array('codigo' => 4,
                                'msg' => 'Deslocamento não condiz com o permitido');
            }else{
                $this->load->model('M_Raca');
                $retorno = $this->M_Raca->alterarRaca($this->getIdRaca(), $this->getRaca(), $this->getDeslocamento());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => 'Campos do front diferentes dos requisitados.');
        }
        echo json_encode($retorno);
    }

    public function apagarRaca(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idRaca'         => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdRaca($resultado->idRaca);
            if(is_numeric($this->getIdRaca()) == False){
                $retorno = array('codigo' => 14,
                                'msg' => 'Nenhum dado selecionado');
            }else{
                $this->load->model('M_Raca');
                $retorno = $this->M_Raca->apagarRaca($this->getIdRaca());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => 'Campos do front diferente dos requisitados.');
        }
        echo json_encode($retorno);
    }
}
?>
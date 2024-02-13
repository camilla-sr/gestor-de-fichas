<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Antecedente extends CI_Controller{
    private $json;
    private $resultado;

    private $idAntec;
    private $antecedente;

    //Getters e setters
    public function getIdAntec(){
        return $this->idAntec;
    }
    public function setIdAntec($idAntecFront){
        $this->idAntec = $idAntecFront;
    }
    public function getAntecedente(){
        return $this->antecedente;
    }
    public function setAntecedente($antecedenteFront){
        $this->antecedente = $antecedenteFront;
    }

    public function inserirAntecedente(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('antecedente' => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setAntecedente($resultado->antecedente);

            if(strlen($this->getAntecedente()) == 0){
                $retorno = array('codigo' => 20,
                                 'msg' => 'Antecedente não informado');
            }elseif(is_numeric($this->getAntecedente()) == true){
                $retorno = array('codigo' => 21,
                                 'msg'    => 'Antecedente não condiz com o permitido');
            }else{
                $this->load->model('M_Antecedente');
                $retorno = $this->M_Antecedente->inserirAntecedente($this->getAntecedente());
            }
        }else{
            $retorno = array('codigo' => 999,
                             'msg'    => 'Campos do front diferente dos requisitados.');
        }
            echo json_encode($retorno);
    }

    public function consultarAntecedente(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idAntec'        => '0',
                       'antecedente'    => '0');
   
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdAntec($resultado->idAntec);
            $this->getAntecedente($resultado->antecedente);

            if(is_numeric($this->getIdAntec()) == False && $this->getIdAntec() != ""){
                $retorno = array('codigo' => 21,
                                'msg' => 'Antecedente não condiz com o permitido');
            }elseif(is_numeric($this->getAntecedente()) == True && $this->getAntecedente() != ""){
                $retorno = array('codigo' => 21,
                                'msg' => 'Antecedente não condiz com o permitido');
            }else{
                $this->load->model('M_Antecedente');
                $retorno = $this->M_Antecedente->consultarAntecedente($this->getIdAntec(), $this->getAntecedente());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => 'Campos do front diferente dos requisitados.');
        }
        echo json_encode($retorno);
    }

    public function alterarAntecedente(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idAntec'        => '0',
                       'antecedente'    => '0');
   
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdAntec($resultado->idAntec);
            $this->getAntecedente($resultado->antecedente);

            if($this->getIdAntec() == ""){
                $retorno = array('codigo' => 23,
                                 'msg'    => 'Antecedente não informado ID');
            }elseif(is_numeric($this->getIdAntec()) == False){
                $retorno = array ('codigo' => 21,
                                  'msg'    => 'Antecedente não condiz com o permitido');
            }elseif(strlen($this->getAntecedente()) == 0){
                $retorno = array('codigo'  => 20,
                                 'msg'     => 'Antecedente não informado');
            }elseif(is_numeric($this->getAntecedente()) == True){
                $retorno = array('codigo' => 21,
                                 'msg' => 'Antecedente não condiz com o permitido');
            }else{
                $this->load->model('M_Antecedente');
                $retorno = $this->M_Antecedente->alterarAntecedente($this->getIdAntec(), $this->getAntecedente());
            }    
        }else{
            $retorno = array('codigo' => 999,
                             'msg'    => 'Campos do front diferente dos requisitados.');
        }
        echo json_encode($retorno);
    }

    public function apagarAntecedente(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idAntec' => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setIdAntec($resultado->idAntec);

            if($this->getIdAntec() == ""){
                $retorno = array('codigo' => 14,
                               'msg'    => 'Nenhum dado selecionado');
            }elseif(is_numeric($this->getIdAntec()) == False){
                $retorno = array('codigo' => 21,
                                'msg' => 'Antecedente não condiz com o permitido');
            }else{
                $this->load->model('M_Antecedente');
                $retorno = $this->M_Antecedente->apagarAntecedente($this->getIdAntec());
            }
        }else{
            $retorno = array('codigo' => 999,
                           'msg'    => 'Campos do front diferente dos requisitados.');
        }
        echo json_encode($retorno);
    }
}
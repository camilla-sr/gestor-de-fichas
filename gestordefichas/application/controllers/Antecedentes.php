<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class antecedentes extends CI_Controller{
    private $json;
    private $resultado;

    private $idAntec;
    private $antecedente;

    //Getters e setters
    public function getIdAntec(){
        return $this->getIdAntec;
    }
    public function setIdAntec($idAntecFront){
        $this->idAntec = $idAntecFront;
    }
    public function getNome(){
        return $this->getNome;
    }
    public function setNome($nomeFront){
        $this->nome = $nomeFront;
    }

    public function inserirAntecedentes(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('nome' => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setNome->($resultado->nome);

            if(strlen($this->getNome()) == 0){
                $retorno = array('codigo' => 16,
                                 'msg' => 'Antecedente não informado');
            }elseif(is_numeric($this->getNome()) == true){
                $reotnro = array('codigo' => 17,
                                 'msg'    => 'Nome do antecedente não condiz com o permitido');
            }else{
                $this->load->model('M_antecedentes');
                $retorno = $this->M_antecedentes->inserirAntecedentes($this->getNome());
            }
        }else{
            $retorno = array('codigo' => 999,
                             'msg'    => 'Campos do front não condiz com o permitido');
        }
            echo json_encode($retorno);
    }

    public function atualizarAntecedentes(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idAntec' => '0',
                       'nome'    => '0');
   
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdAntec($resultado->idAntec);
            $this->setNome($resultado->nome);

            if(strlen($this->getIdAntec()) == 0){
                $retorno = array('codigo' => 18,
                                 'msg'    => 'ID do antecedente não informado');
            }elseif(is_string($this->getIdAntec()) == true){
                $retorno = array ('codigo' => 19,
                                  'msg'    => 'ID do antecedente não condiz com o permitido');
            }elseif(strlen($this->getNome()) == 0){
                $retorno = array('codigo'  => 20,
                                 'msg'     => 'Antecedente não informado');
            }elseif(is_numeric($this->getNome()) == true){
                $retorno = array('codigo' => 17,
                                 'msg'    => 'Nome do antecedente não condiz com o permitido');
            }else{
                $this->load->model('M_antecedentes');
                $retorno = $this->M_antecedentes->atualizarAntecedentes($this->getIdAntec(), $this->getNome());
            }    
        }else{
            $retorno = array('codigo' => 999,
                             'msg'    => 'Campos do front não condizem com o permitido');
        }
        echo json_encode($retorno);
    }

    public function apagarAntecedente(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = ('idAntec' => '0');

        if(verificarParam($resultado, $lista) == 1){
            $this->setIdAntec($resultado->idAntec);

            if(strlen($this->getIdAntec()) == 0){
                $dados = array('codigo' => 22,
                               'msg'    => 'ID do antecedente não inserido');
            }elseif(is_string($this->getIdAntec()) == true){
                $dados = array('codigo' => 22,
                               'msg'    => 'ID do Antecedente não condiz com o permitido'); 
            }else{
                $this->load->model('M_antecedentes');
                $retorno = $this->M_antecedentes->apagarAntecedente($this->getIdAntec());
            }
        }else{
            $dados = array('codigo' => 999,
                           'msg'    => 'Campos do front não condizem com o permitido');
        }
        echo json_encode($retorno);
    }
}
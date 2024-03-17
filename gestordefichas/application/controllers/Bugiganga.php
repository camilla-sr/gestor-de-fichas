<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bugiganga extends CI_Controller{
    private $json;
    private $resultado;

    private $idBugig;
    private $descricao;

    //  GETTERS E SETTERS
    public function getIdBugiganga(){
        return $this->idBugig;
    }
    public function setIdBugiganga($idBugigFront){
        $this->idBugig = $idBugigFront;
    }
    public function getDescricao(){
        return $this->descricao;
    }
    public function setDescricao($descricaoFront){
        $this->descricao = $descricaoFront;
    }

    public function inserirBugiganga(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('descricao'  => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setDescricao($resultado->descricao);

            if(trim($this->getDescricao()) == ""){
                $retorno = array('codigo' => 25,
                                'msg' => 'Descrição não informada');
            }elseif(is_numeric($this->getDescricao()) == True){
                $retorno = array('codigo' => 32,
                                'msg' => 'Descrição não condiz com o permitido');
            }else{
                $this->load->model('M_Bugiganga');
                $retorno = $this->M_Bugiganga->inserirBugiganga($this->getDescricao());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => "Campos do front diferente dos requisitados");
        }
        echo json_encode($retorno);
    }

    public function consultarBugiganga(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idBugig'        => '0',
                        'descricao'     => '0');
        if(verificarParam($resultado, $lista) == 1){
            $this->setIdBugiganga($resultado->idBugig);
            $this->setDescricao($resultado->descricao);

            if(is_numeric($this->getIdBugiganga()) == False && $this->getIdBugiganga() != ""){
                $retorno = array('codigo' => 8,
                                'msg' => 'ID não condiz com o permitido');
            }else{
                $this->load->model('M_Bugiganga');
                $retorno = $this->M_Bugiganga->consultarBugiganga($this->getIdBugiganga(), $this->getDescricao());
            }
        }else{
            $retorno = array('codigo' => 999,
                            'msg' => 'Campos do front diferente dos requisitados');
        }
        echo json_encode($retorno);
    }

	public function alterarBugiganga(){
		$json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array('idBugig'        => '0',
                        'descricao'     => '0');
		if(verificarParam($resultado, $lista) == 1){
			$this->setIdBugiganga($resultado->idBugig);
            $this->setDescricao($resultado->descricao);

            if($this->getIdBugiganga() == ""){
                $retorno = array('codigo' => 36,
                                'msg' => 'Bugiganga não informada');
            }elseif(is_numeric($this->getIdBugiganga()) == False){
                $retorno = array('codigo' => 8,
                                'msg' => 'ID não condiz com o permitido');
            }elseif(strlen($this->getDescricao()) == 0){
                $retorno = array('codigo' => 28,
                                'msg' => 'Nenhum dado para alteração informado');
            }else{
                $this->load->model('M_Bugiganga');
                $retorno = $this->M_Buginganga->alterarBugiganga($this->getIdBugiganga(), $this->getDescricao());
            }
		}else{
			$retorno = array('codigo' => 999,
							'msg' => 'Campos do front diferente dos requisitados');
	    }
		echo json_encode($retorno);
    }
}
?>

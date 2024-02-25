<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Dado extends CI_Model{
    public function inserirDado($tipo){
        $retornoDado = $this->conferirDado($tipo);
        if($retornoDado['codigo'] == 1){
            $dados = array('codigo' => 31,
                            'msg' => 'Dado já cadastrado');
        }else{
            $sql = "insert into DADOS (tipo) values ('$tipo')";
            $this->db->query($sql);
            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 7,
                                'msg' => 'Cadastro concluído');
            }else{
                $dados = array('codigo' => 6,
                                'msg' => 'Houve um problema ao efetuar função');
            }
        }
        return $dados;
    }

    public function consultarDado($idDado, $tipo){
        if($idDado != "" and $tipo == ""){
            $sql = "select * from DADOS where = $idDado";
        }elseif($idDado == "" and $tipo != ""){
            $sql = "select * from DADOS where tipo like '%$tipo%'";
        }elseif($idDado != "" and $tipo != ""){
            $sql = "select * from DADOS where id_dado = $idDado and tipo like '%$tipo%'";
        }else{
            $sql = "select * from DADOS";
        }
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 88,
                            'dados' => $retorno->result());
        }else{
            $dados = array('codigo' => 11,
                            'msg' => 'Nada encontrado');
        }
        return $dados;
    }

    public function alterarDado($idDado, $tipo){
        $retornoID = $this->validarDado($idDado);
        if($retornoID['codigo'] == 2){
            $dados = array('codigo' => 11,
                            'msg' => $retornoID['msg']);
        }else{
            $retornoDado = $this->conferirDado($tipo);
            if($retornoDado['codigo'] == 1){
                $dados = array('codigo' => 31,
                                'msg' => $retornoDado['msg']);
            }else{
                $sql = "update DADOS set tipo = '$tipo' where id_dado = $idDado";
                $this->db->query($sql);
                if($this->db->affected_rows() > 0){
                    $dados = array('codigo' => 12,
                                    'msg' => 'Dados alterados');
                }else{
                    $dados = array('codigo' => 6,
                                    'msg' => 'Houve um problema ao efetuar função');
                }
            }
        }
        return $dados;
    }

    public function apagarDado($idDado){
        $retornoID = $this->validarDado($idDado);
        if($retornoID['codigo'] == 2){
            $dados = array('codigo' => 11,
                            'msg' => $retornoID['msg']);
        }else{
            $sql = "delete from DADOS where id_dado = $idDado";
            $this->db->query($sql);
            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 15,
                                'msg' => 'Dado apagado');
            }else{
                $dados = array('codigo' => 6,
                                'msg' => 'Houve um problema ao efetuar função');
            }
        }
        return $dados;
    }

    // MÉTODOS DE APOIO
    private function conferirDado($tipo){
        $sql = "select * from DADOS where tipo = '$tipo'";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Dado já cadastrado');
        }else{
            $dados = array('codigo' => 2,
                            'msg' => 'Nada encontrado');
        }
        return $dados;
    }

    private function validarDado($idDado){
        $sql = "select * from DADOS where id_dado = $idDado";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Dado válido');
        }else{
            $dados = array('codigo' => 2,
                            'msg' => 'Nada encontrado');
        }
        return $dados;
    }
}
?>
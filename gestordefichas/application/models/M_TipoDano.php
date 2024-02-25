<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_TipoDano extends CI_Model{
    public function inserirDano($descricao){
        $retornoDano = $this->conferirDano($descricao);
        if($retornoDano['codigo'] == 1){
            $dados = array('codigo' => 33,
                            'msg' => $retornoDano['msg']);
        }else{
            $sql = "insert into TIPO_DANO (descricao) values ('$descricao')";
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

    public function consultarDano($idDano, $descricao){
        if($idDano != "" and $descricao == ""){
            $sql = "select * from TIPO_DANO where id_dano = $idDano";
        }elseif($idDano == "" and $descricao != ""){
            $sql = "select * from TIPO_DANO where descricao like '%$descricao%'";
        }elseif($idDano != "" and $descricao != ""){
            $sql = "select * from TIPO_DANO where id_dano = $idDano and descricao like '%$descricao%'";
        }else{
            $sql = "select * from TIPO_DANO";
        }
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 88,
                            'dados' => $retorno->result());
        }else{
            $dados = array('codigo' => 6,
                            'msg' => 'Nenhum dado encontrado');
        }
        return $dados;
    }

    public function alterarDano($idDano, $descricao){
        $retornoID = $this->validarDano($idDano);
        if($retornoID['codigo'] == 2){
            $dados = array('codigo' => 11,
                            'msg' => $retornoID['msg']);
        }else{
            $retornoDano = $this->conferirDano($descricao);
            if($retornoDano['codigo'] == 1){
                $dados = array('codigo' => 33,
                                'msg' => $retornoDano['msg']);
            }else{
                $sql = "update TIPO_DANO set descricao = '$descricao' where id_dano = $idDano";
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

    public function apagarDano($idDano){
        $retornoID = $this->validarDano($idDano);
        if($retornoID['codigo'] == 2){
            $dados = array('codigo' => 11,
                            'msg' => $retornoID['msg']);
        }else{
            $sql = "delete from TIPO_DANO where id_dano = $idDano";
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

    #   MÉTODOS DE APOIO
    private function conferirDano($descricao){
        $sql = "select * from TIPO_DANO where descricao like '%$descricao%'";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Tipo de dano já cadastrado');
        }else{
            $dados = array('codigo' => 2,
                            'msg' => 'Nenhum dado encontrado');
        }
        return $dados;
    }

    private function validarDano($idDano){
        $sql = "select * from TIPO_DANO where id_dano = $idDano";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Dano válido');
        }else{
            $dados = array('codigo' => 2,
                            'msg' => 'Nenhum dado encontrado');
        }
        return $dados;
    }
}

?>
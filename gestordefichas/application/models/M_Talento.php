<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Talento extends CI_Model{
    public function inserirTalento($talento, $descricao, $requisito){
        $retornoTalento = $this->conferirTalento($talento);
        if($retornoTalento['codigo'] == 1){
            $dados = array('codigo' => 27,
                            'msg' => $retornoTalento['msg']);
        }else{
            if($requisito == ""){
                $sql = "insert into TALENTOS (talento, descricao) values ('$talento', '$descricao')";
            }else{
                $sql = "insert into TALENTOS (talento, descricao, requisito) values ('$talento', '$descricao', '$requisito')";
            }
            $this->db->query($sql);
            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 7,
                                'msg' => 'Cadastro concluído');
            }else{
                $dados = array('codigo' => 6,
                                'msg' => 'Houve algum problema ao efetuar função');
            }
        }
        return $dados;
    }

    public function consultarTalento($idTalento, $talento, $requisito){
        if($idTalento == "" and $talento == "" and $requisito == ""){
            $sql = "select * from TALENTOS";
        }elseif($idTalento != "" and $talento == "" and $requisito == ""){
            $sql = "select * from TALENTOS where id_talento = $idTalento";
        }elseif($idTalento != "" and $talento != "" and $requisito == ""){
            $sql = "select * from TALENTOS where id_talento = $idTalento and talento like '%$talento%'";
        }elseif($idTalento != "" and $talento == "" and $requisito != ""){
            $sql = "select * from TALENTOS where id_talento = $idTalento and requisito like '%$requisito%'";
        }elseif($idTalento == "" and $talento != "" and $requisito != ""){
            $sql = "select * from TALENTOS where talento like '%$talento%' and requisito like '%$requisito%'";
        }elseif($idTalento == "" and $talento != "" and $requisito == ""){
             $sql = "select * from TALENTOS where talento like '%$talento%'";
        }elseif($idTalento == "" and $talento == "" and $requisito != ""){
            $sql = "select * from TALENTOS where requisito like '%$requisito%'";
        }
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 88,
                            'dados' => $retorno->result());
        }else{
            $dados = array('codigo' => 11,
                            'msg' => 'Nenhum dado encontrado');
        }
        return $dados;
    }

    #   MÉTODOS DE APOIO
    public function conferirTalento($talento){
        $sql = "select * from TALENTOS where talento like '%$talento%'";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Talento já cadastrado');
        }else{
            $dados = array('codigo' => 2,
                            'msg' => 'Nenhum dados encontrado');
        }
        return $dados;
    }

    public function validarTalento($idTalento){
        $sql = "select * from TALENTOS where id_talento = $idTalento";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Talento válido');
        }else{
            $dados = array('codigo' => 2,
                            'msg' => 'Nenhum dado encontrado');
        }
        return $dados;
    }
}
?>
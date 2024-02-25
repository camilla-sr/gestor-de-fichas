<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Bugiganga extends CI_Model{
    public function inserirBugiganga($descricao){
        $retornoBugi = $this->conferirBugiganga($descricao);
        if($retornoBugi['codigo'] == 1){
            $dados = array('codigo' => 34,
                            'msg' => $retornoBugi['msg']);
        }else{
            $sql = "insert into BUGIGANGAS (descricao) values ('$descricao')";
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

    public function consultarBugiganga($idBugig, $descricao){
        if($idBugig != "" and $descricao == ""){
            $sql = "select * from BUGIGANGAS where id_bugig = $idBugig";
        }elseif($idBugig == "" and $descricao != ""){
            $sql = "select * from BUGIGANGAS where descricao like '%$descricao%'";
        }elseif($idBugig != "" and $descricao != ""){
            $sql = "select * from BUGIGANGAS where descricao like '%$descricao%' and id_bugig = $idBugig";
        }else{
            $sql = "select * from BUGIGANGAS";
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
    private function conferirBugiganga($descricao){
        $sql = "select * from BUGIGANGAS where descricao like '%$descricao%'";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Bugiganga já cadastrada');
        }else{
            $dados = array('codigo' => 2,
                            'msg' => 'Nenhum dado encontrado');
        }
        return $dados;
    }

    private function validarBugiganga($idBugig){
        $sql = "select * from BUGIGANGAS where id_bugig = $idBugig";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Bugiganga válida');
        }else{
            $dados = array('codigo' => 2,
                            'msg' => 'Nenhum dado encontrado');
        }
        return $dados;
    }
}
?>
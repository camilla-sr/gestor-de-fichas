<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Raca extends CI_Model{
    public function inserirRaca($raca, $deslocamento){
        $retornoRaca = $this->conferirRaca($raca);
        if($retornoRaca['codigo'] == 1){
            $dados = array('codigo' => 10,
                            'msg' => $retornoRaca['msg']);
        }else{
            $sql = "insert into RACAS (raca, deslocamento) values ('$raca', $deslocamento)";
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

    public function consultarRaca($idRaca, $raca, $deslocamento){
        if($idRaca == "" and $raca == "" and $deslocamento == ""){
            $sql = "select * from RACAS";
        }elseif($idRaca != "" and $raca == "" and $deslocamento == ""){
            $sql = "select * from RACAS where id_raca = $idRaca";
        }elseif($idRaca == "" and $raca != "" and $deslocamento == ""){
            $sql = "select * from RACAS where raca like '%$raca%'";
        }elseif($idRaca == "" and $raca == "" and $deslocamento != ""){
            $sql = "select * from RACAS where deslocamento = $deslocamento";
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

    public function alterarRaca($idRaca, $raca, $deslocamento){
        $retornoRaca = $this->conferirRaca($idRaca);
        if($retornoRaca['codigo'] == 1){
            $dados = array('codigo' => 10,
                            'msg' => $retornoRaca['msg']);
        }else{
            if($deslocamento == "" and $raca != ""){
                $sql = "update RACAS set raca = '$raca' ";
            }elseif($deslocamento != "" and $raca == ""){
                $sql = "update RACAS set deslocamento = $deslocamento ";
            }elseif($deslocamento != "" and $raca != ""){
                $sql = "update RACAS set raca = '$raca', deslocamento = $deslocamento ";
            }

            $sql = $sql . "where id_raca = $idRaca";
            $this->db->query($sql);
            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 12,
                                'msg' => 'Dados alterados');
            }else{
                $dados = array('codigo' => 6,
                                'msg' => 'Houve um problema ao efetuar função');
            }
        }
        return $dados;
    }

    public function apagarRaca($idRaca){
        $retornoRaca = $this->validarRaca($idRaca);
        if($retornoRaca['codigo'] == 2){
            $dados = array('codigo' => 11,
                            'msg' => $retornoRaca['msg']);
        }else{
            $sql = "delete from RACAS where id_raca = $idRaca";
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


    #MÉTODOS DE APOIO
    public function conferirRaca($raca){
        $sql = "select * from RACAS where raca = '$raca'";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Raça já cadastrada');
        }else{
            $dados = array('codigo' => 2,
                            'msg' => 'Nenhum dado encontrado');
        }
        return $dados;
    }

    public function validarRaca($idRaca){
        $sql = "select * from RACAS where id_raca = $idRaca";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                            'msg' => 'Id válido');
        }else{
            $dados = array('codigo' => 2,
                            'msg' => 'Nenhum dado encontrado');
        }
        return $dados;
    }
}
?>